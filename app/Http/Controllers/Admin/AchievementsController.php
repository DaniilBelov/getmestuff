<?php

namespace App\Http\Controllers\Admin;

use App\Achievement;
use App\GlobalSettings;
use App\Http\Controllers\Admin\Traits\RefactorData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewAchievementForm;
use App\Http\Requests\Admin\NewPrizeForm;
use App\Http\Requests\Admin\UpdateAchievementForm;
use App\Http\Requests\Admin\UpdatePrizeForm;
use App\Prize;
use Yajra\Datatables\Facades\Datatables;

class AchievementsController extends Controller
{
    use RefactorData;

    protected $visibleForAdmins = [];
    protected $translatedFields = ['item', 'title', 'description'];

    public function allAchievements(Achievement $achievement) {
        return Datatables::of(
            $this->refactorData(
                $this->getData($achievement, [
                    'id', 'need', 'prize', 'renew', 'type', 'updated_at', 'created_at'
                ])
            )
        )->make(true);
    }

    public function allPrizes(Prize $prize) {
        return Datatables::of(
            $this->refactorData(
                $this->getData($prize, [
                    'id', 'price', 'bought', 'user_column', 'updated_at', 'created_at'
                ])
            )
        )->make(true);
    }

    public function newAchievement(NewAchievementForm $form) {
        $form->save();

        return response(['status' => 'Achievement created']);
    }

    public function newPrize(NewPrizeForm $form) {
        $form->save();

        return response(['status' => 'Prize created']);
    }

    public function settings() {
        $settings = GlobalSettings::getSettingsGroup([
            'disable_achievements'
        ]);
        return view('admin.achievements.achievements_settings', compact('settings'));
    }

    public function updateAchievement(Achievement $achievement, UpdateAchievementForm $form)
    {
        $form->save($achievement);

        return response(['status' => 'Row updated successfully']);
    }

    public function updatePrize(Prize $prize, UpdatePrizeForm $form)
    {
        $form->save($prize);

        return response(['status' => 'Row updated successfully']);
    }

    public function destroyAchievement(Achievement $achievement)
    {
        $achievement->delete();

        return response(['status' => 'Row deleted successfully']);
    }

    public function destroyPrize(Prize $prize)
    {
        $prize->delete();

        return response(['status' => 'Row deleted successfully']);
    }

    protected function getData($data, $select, $where = false)
    {
        $data = $data->select($select)->with('translations');

        if ($where) {
            $data = $data->where([$where]);
        }

        return $data->get()->makeVisible($this->visibleForAdmins);
    }
}
