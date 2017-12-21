<?php

namespace App\Http\Controllers;

use App\GlobalSettings;
use App\Http\Requests\DonateForm;
use App\Http\Requests\WishesForm;
use App\Wish;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Jobs\ReturnMoney;
use App\User;

class WishesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('getSet', 'process');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;

        $wishes = Wish::getWishes($id);

        return view('wishes', compact('wishes'));
    }

    /**
     * Stores wishes
     *
     * @param WishesForm $form
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(WishesForm $form)
    {
        try {
            $form->save();
        } catch (\Exception $e) {
            return response()->json(
                ['amount' => [$e->getMessage()]], 422
            );
        }

        return response(['status' => 'Wish published successfully']);
    }


    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function show(Request $request)
    {
        return Wish::getWishes($request->user()->id, 1, $request->set);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function edit(Wish $wish)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param DonateForm $form
     * @param Wish $wish
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($wish, DonateForm $form)
    {
        try {
            $wish = Wish::findOrFail($wish);
        } catch (\Exception $e) {
            $message = getErrorMessage(
                'The wish was not found, try refreshing the page.',
                'Желание не найдено, попробуйте перезагрузить страницу.');

            return response()->json(
                ['message' => [$message]], 404
            );
        }

        try {
            $form->save($wish);
        } catch (\Exception $e) {
            return response()->json(
                ['message' => [$e->getMessage()]], 422
            );
        }

        return response(['status' => 'Donated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wish $wish)
    {
        if ($wish->user_id == auth()->user()->id) {
            ReturnMoney::dispatch($wish->donated);
            $wish->delete();
            return response(['status' => 'Wish has been deleted']);
        }

        return response()->json(
            ['message' => ['Something wen wrong']], 404
        );
    }

    public function report(Wish $wish, Request $request)
    {
        $reports = collect(json_decode($wish->reported))->push(sprintf("user.%s.report", $request->user()->id));
        $wish->reported = $reports->toJson();

        if ($reports->count() >= GlobalSettings::getSettings('number_of_reports_before_notifications')->data['value']) {
            $wish->validated = 0;
        }

        $wish->save();

        return response(['status' => 'Wish has been reported']); 
    }

    public function getCurrency(Request $request)
    {
        $amount = $request->amount;
        $currency = $request->currency;

        return getConvertedValue($amount, $currency);
    }

    public function getSet(Request $request, $number_of_wishes)
    {
        $key = $request->only("23en51NRL4");

        if ($key["23en51NRL4"] != "5F0u0mQ84pZ7ZcyEa8Hn") {
            return abort(401);
        }

        $wishes = Wish::where([
            ["completed", true],
            ["processed", false]
        ])->limit($number_of_wishes)->with(['user' => function ($query) {
            return $query->select(['id', 'first_name', 'last_name']);
        }])->get()->makeVisible(['user_id', 'url', 'address']);

        return $wishes;
    }

    public function process(Request $request, Wish $wish)
    {
        $key = $request->only("O1031SbEA7");

        if ($key["O1031SbEA7"] != "f864YG5135156Qb0jp17") {
            return abort(401);
        }

        $wish->processed = true;
        $wish->save();

        return response(['message' => 'Wish updated']);
    }
}
