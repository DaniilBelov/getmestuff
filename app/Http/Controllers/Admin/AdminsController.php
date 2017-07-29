<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\GlobalSettings;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Wish;

class AdminsController extends Controller
{
    public function index(Country $country, Wish $wish, Payment $payment)
    {
        $colors = [
            'info', 'success', 'danger', 'warning', 'primary', 'inverse'
        ];

        $wishes_data = $wish->getData();
        $payment_data = $payment->getData();

        if ($payment_data['this_month'] == 0) {
            $net_flow = 0;
        } else {
            if ($wishes_data['outflow'] == 0) $net_flow = 100;
            else {
                $net_flow = number_format(
                    100 - ($wishes_data['outflow'] * 100 / $payment_data['this_month']), 2
                );
            }
        }

        $cash_flow = [
            'inflow' => $payment_data['this_month'],
            'outflow' => $wishes_data['outflow'],
            'new_flow' => $net_flow,
            'change' => $payment_data['change']
        ];

        unset($wishes_data['outflow']);

        return view('admin.dashboard', [
            'country_data' => $country->getVisits(),
            'wishes_data' => $wishes_data,
            'profits_data' => $payment_data,
            'cash_flow' => $cash_flow,
            'colors' => $colors
        ]);
    }

    public function settings()
    {
        $settings = GlobalSettings::getGeneralSetting();

        return view('admin.settings', compact('settings'));
    }

    public function payment()
    {
        $settings = GlobalSettings::getSettingsGroup(['commissions', 'turn_on/of_payment_systems']);

        return view('admin.payment', compact('settings'));
    }
}
