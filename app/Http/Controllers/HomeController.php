<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Bot\Bot;
use App\Bots\Amazon;
use App\Events\AchievementsOutdated;
use App\GlobalSettings;
use Illuminate\Http\Request;
use App\Http\Requests\PrizesForm;
use App\User;
use App\Wish;
use App\Prize;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('test');;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refresh = cache(User::cacheKey());
        if (!is_null($refresh) && $refresh->lte(Carbon::now())) {
            event(new AchievementsOutdated(auth()->user()));
        }

        $random = Wish::getWishes(auth()->user()->id, 1);

        $ref_info = User::getRefs();
        $ref_info['link'] = auth()->user()->ref_link;

        $achievements = Achievement::all();
        $prizes = Prize::all();
        $wishes = $this->getUserWishes();
        $settings = GlobalSettings::getSettingsGroup(
            ['disable_achievements', 'commissions', 'turn_on/of_payment_systems']
        );

        $reasons = [
            'en' => [
                'Fixing Bugs',
                'Updating',
                'Back Soon'
            ],
            'ru' => [
                'Исправление ошибок',
                'Обновление',
                'Скоро вернемся'
            ]
        ];

        return view('userpage', [
            'random' => $random,
            'ref_info' => $ref_info,
            'achievements' => $achievements,
            'prizes' => $prizes,
            'wishes' => $wishes,
            'settings' => $settings,
            'reasons' => $reasons
        ]);
    }

    public function prizes(PrizesForm $form)
    {
        try {
            $form->save();
        } catch (\Exception $e) {
            return response()->json(
                ['message' => [$e->getMessage()]], 422
            );
        }

        return response(['status' => 'Points redeemed successfully']);
    }

    public function subscribed(Request $request)
    {
        $request->user()->recordAchievements(1, [2]);

        return response(['status' => 'Thanks for subsciption']);
    }

    protected function getUserWishes()
    {
        return auth()->user()->wishes()->where('completed', 0)->get()->map(function ($item) {
            $item = collect($item);
            $item['current_amount'] = $item['current_amount'] + $item['initial_amount'];
            return $item;
        });
    }

    public function test()
    {
        $bot = new Amazon("https://www.amazon.co.uk/Apple-iPhone-Smartphone-Certified-Refurbished/dp/B00X3CSVT4/ref=sr_1_1?ie=UTF8&qid=1503561657&sr=8-1&keywords=iphone");

        dd($bot->buy());
    }
}
