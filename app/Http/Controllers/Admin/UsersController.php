<?php

namespace App\Http\Controllers\Admin;

use App\GlobalSettings;
use App\Http\Controllers\Admin\Traits\RefactorData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserActivityFrom;
use App\Http\Requests\Admin\UpdateUserFrom;
use App\User;
use Yajra\Datatables\Facades\Datatables;

class UsersController extends Controller
{
    use RefactorData;

    protected $visibleForAdmins = [
        'ip_address', 'verified'
    ];

    public function all(User $user)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getUsers($user, [
                    'id', 'first_name', 'last_name', 'email', 'verified',
                    'balance', 'donated', 'status', 'admin', 'created_at',
                ])
            )
        )->make(true);
    }

    public function activity(User $user)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getUsers($user, [
                    'id', 'first_name', 'last_name', 'balance', 'points',
                    'ref_link', 'number_of_wishes', 'priority', 'amount_donated',
                    'amount_received', 'updated_at', 'created_at'
                ])
            )
        )->make(true);
    }

    public function settings()
    {
        $settings = GlobalSettings::getSettingsGroup([
            'banned_emails', 'min_length', 'weak_passwords',
            'number_of_points_to_be_added'
        ]);
        return view('admin.users.users_settings', compact('settings'));
    }

    public function update(User $user, UpdateUserFrom $form)
    {
        $form->save($user);

        return response(['status' => 'Row edited successfully']);
    }

    public function updateActivity(User $user, UpdateUserActivityFrom $form)
    {
        $form->save($user);

        return response(['status' => 'Row edited successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response(['status' => 'Row deleted successfully']);
    }

    protected function getUsers(User $user, $select, $where = false)
    {
        if ($where) {
            return $user->select($select)->where([$where])->get()->makeVisible($this->visibleForAdmins);
        }
        return $user->select($select)->get()->makeVisible($this->visibleForAdmins);
    }
}
