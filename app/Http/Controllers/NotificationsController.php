<?php

namespace App\Http\Controllers;

use function foo\func;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $notifications = auth()->user()->notifications
            ->groupBy(function ($item) {
                return $item->created_at->format('y-m-d');
            });

        $notifications = $notifications->map(function ($item) {
            return $item->groupBy(function ($item) {
                return $item['data']['wish'];
            })->map(function ($item) {
                return collect($item);
            });
        });

        $donated = $notifications->map(function ($item) {
            return $item->map(function ($item) {
                return $item->filter(function ($item) {
                    return $item->type == 'App\Notifications\UserHasDonated';
                })->map(function ($item) {
                    return $item->data['amount'];
                });
            })->each(function ($item) {
                $item->prepend($item->sum(), 'total');
                $item->prepend(($item->count() - 1), 'count');
            })->map(function ($item) {
                return $item->only('count', 'total');
            });
        });

        $completed = $notifications->map(function ($item) {
            return $item->map(function ($item) {
                return $item->filter(function ($item) {
                    return $item->type == 'App\Notifications\WishCompleted';
                })->map(function () {
                    return 'completed';
                });
            })->filter(function ($item) {
                return $item->isNotEmpty();
            });
        })->filter(function ($item) {
            return $item->isNotEmpty();
        });

        $notifications = $donated->map(function ($item, $key) use ($completed) {
            if (isset($completed[$key])) {
                return $item->map(function ($item, $wish) use ($completed, $key) {
                    if (isset($completed[$key][$wish])) {
                        $item['completed'] = 1;
                        return $item;
                    } else {
                        return $item;
                    }
                });
            } else {
                return $item;
            }
        });

        $notifications = $this->paginate($notifications, 2)->setPath('notifications');

        return $notifications;
    }

    public function show()
    {
        if (\Auth::check()) return auth()->user()->unreadNotifications;

        return response(['message' => 'No user is logged in']);
    }

    public function destroy()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response(['status' => 'Notifications Updated']);
    }

    protected function paginate($items, $perPage = 10)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);

        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }
}
