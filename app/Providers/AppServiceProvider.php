<?php

namespace App\Providers;

use App\Country;
use App\GlobalSettings;
use App\Ticket;
use App\Wish;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\Facades\Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->setLocale(request()->segment(1));

        view()->composer([
            'index', 'about', 'auth.authenticate', 'terms', 'privacy', 'faq'
        ], function ($view) {
            $country = new Country();
            $country->setCountry();
//            $view->with('refresh', \App\User::lastOnline());
        });

        view()->composer('*', function ($view) {
            $view->with('lang', app()->getLocale());
        });

        view()->composer([
            'admin.wishes.wishes_table', 'admin.users.users_table',
            'admin.achievements.achievements_table', 'admin.tickets.tickets_table',
            'admin.payments.payments_table'
        ], function ($view) {
            $table = explode('/', request()->path());
            $table = end($table);

            $view->with('table', $table);
        });

        view()->composer([
            'admin.layouts.blocks.sidebar_left'
        ], function ($view) {
            $wishes = Wish::query()->where('validated', false)->count();
            $tickets = Ticket::query()->where([
                ['type', '!=', 2],
                ['is_admin', '=', 0]
            ])->count();
            $view->with([
                'reported' => $wishes,
                'open' => $tickets
            ]);
        });

        view()->composer('construction', function ($view) {
            $message = GlobalSettings::getSettings('state')->data['value'];

            $view->with([
                'message' => $message
            ]);
        });

        \Validator::extend('spamfree', '\App\Rules\SpamFree@passes');
        \Validator::extend('maxwish', '\App\Rules\MaxWish@passes');
        \Validator::extend('uniquearray', '\App\Rules\UniqueArray@passes');
        \Validator::extend('alpha_num_s', '\App\Rules\AlphaNumS@passes');
        \Validator::extend('less_than', '\App\Rules\LessThan@passes');

        Queue::failing(function (JobFailed $event) {
            \Log::error($event->exception);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
