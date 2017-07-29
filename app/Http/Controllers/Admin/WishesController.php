<?php

namespace App\Http\Controllers\Admin;

use App\GlobalSettings;
use App\Http\Controllers\Admin\Traits\RefactorData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateWishAddressFrom;
use App\Http\Requests\Admin\UpdateWishForm;
use App\Wish;
use Yajra\Datatables\Facades\Datatables;

class WishesController extends Controller
{
    use RefactorData;

    protected $visibleForAdmins = [
        'user_id', 'url', 'address', 'priority', 'validated', 'completed', 'donated', 'updated_at'
    ];

    protected $translatedFields = ['item'];

    public function all(Wish $wish)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getWishes($wish, [
                    'id', 'initial_amount', 'current_amount', 'amount_needed', 'validated', 'completed', 'created_at'
                ])
            )
        )->make(true);
    }

    public function reported(Wish $wish)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getWishes(
                    $wish, ['id', 'user_id', 'validated', 'created_at'], false, [['validated', false]]
                )
            )
        )->make(true);
    }

    public function address(Wish $wish)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getWishes($wish, ['id', 'user_id', 'address', 'created_at'], ['id', 'email'])
            )
        )->make(true);
    }

    public function completed(Wish $wish)
    {
        return Datatables::of(
            $this->refactorData(
                $this->getWishes($wish, [
                    'id', 'url', 'initial_amount', 'current_amount', 'amount_needed',
                    'address', 'processed'
                ], false, [
                    ['completed', true],
                    ['processed', false]
                ])
            )
        )->make(true);
    }

    public function settings()
    {
        $settings = GlobalSettings::getSettingsGroup([
            'max_number_of_words_in_title', 'default_wishes_allowance', 'number_of_reports_before_notifications',
            'word_replacements'
        ]);
        return view('admin.wishes.wishes_settings', compact('settings'));
    }

    public function update(Wish $wish, UpdateWishForm $form)
    {
        $form->save($wish);

        return response(['status' => 'Row has been updated successfully']);
    }

    public function updateAddress(Wish $wish, UpdateWishAddressFrom $form)
    {
        $form->save($wish);

        return response(['status' => 'Row has been updated successfully']);
    }

    public function destroy(Wish $wish)
    {
        $wish->delete();

        return response(['status' => 'Wish has been deleted']);
    }

    protected function getWishes(Wish $wish, $select, $with = false, $where = false)
    {
        $wish = $wish->select($select)->with('translations');

        if ($with) {
            $wish = $wish->with(['user' => function ($query) use ($with) {
                $query->select($with);
            }]);
        }

        if ($where) {
            $wish = $wish->where($where);
        }

        return $wish->get()->makeVisible($this->visibleForAdmins);
    }
}
