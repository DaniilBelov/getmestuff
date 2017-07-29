<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->middleware('guest');

Route::get('/about', function () {
    return view('about');
})->middleware('guest');

Route::get('/lang/{language}', 'LanguagesController@switchLang');
Route::get('/terms', function () {
    return view('terms');
});
Route::get('/privacy', function () {
    return view('privacy');
});
Route::get('/rules', function () {
    return view('rules');
});
Route::get('/faq', function () {
    return view('faq');
});


Route::namespace('Auth')->group(function () {
    $this->get('login', 'LoginController@showLoginForm');
    $this->post('login', 'LoginController@login')->name('login');
    $this->post('logout', 'LoginController@logout')->name('logout');

    $this->get('register', 'RegisterController@showRegistrationForm');
    $this->post('register', 'RegisterController@register')->name('register');

    $this->get('/register/confirm/{token}', 'RegisterController@confirmEmail');
    $this->get('/register/{ref}', 'RegisterController@showRegistrationFormWithRef');

    $this->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'ResetPasswordController@reset')->name('password.reset.post');
});

Route::get('/home', 'HomeController@index');
Route::get('/home/confirm/{token}', 'UserSettingsController@verify');

Route::get('/wishes', 'WishesController@index');

Route::get('/contact', function () {
    return view('contact');
})->middleware('auth');

Route::get('/notifications', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return view('notifications');
})->middleware('auth');

Route::middleware(['auth', 'ajax'])->group(function () {
    $this->patch('/home/update', 'UserSettingsController@update');
    $this->post('/home/achievements', 'HomeController@prizes');

    $this->post('/topup', 'PurchasesController@store');
    $this->get('/braintree/token', 'PurchasesController@token');

    $this->post('/wishes/refresh', 'WishesController@show');
    $this->post('/wishes', 'WishesController@store')->middleware('donated');
    $this->patch('/wish/{wish}/donate', 'WishesController@update');
    $this->patch('/wish/{wish}/report', 'WishesController@report');
    $this->delete('/wish/{wish}', 'WishesController@destroy');

    $this->get('/unread', 'NotificationsController@show');
    $this->get('/donations', 'NotificationsController@index');
    $this->get('/payments', 'PurchasesController@index');

    $this->get('/subscribe', 'HomeController@subscribed');
    $this->get('/convert', 'WishesController@getCurrency');

    $this->get('/interkassa', 'PurchasesController@makeForm');
});

Route::namespace('Admin\Auth')->prefix('admin')->group(function () {
    $this->get('/abc', 'LoginController@showLoginForm');

    $this->post('/login', 'LoginController@login');
    $this->post('/logout', 'LoginController@logout');

    $this->post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');

    $this->get('/password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset.admin');
    $this->post('/password/reset', 'ResetPasswordController@reset');
});

Route::middleware(['auth', 'admin'])->namespace('Admin')->prefix('admin')->group(function () {
    $this->get('/dashboard', 'AdminsController@index');

    $this->get('/settings', 'AdminsController@settings');
    $this->get('/payment', 'AdminsController@payment');

    $this->get('/wishes', function () {
        return view('admin.wishes.wishes_table');
    });
    $this->get('/wishes/reported', function () {
        return view('admin.wishes.wishes_table');
    });
    $this->get('/wishes/address', function () {
        return view('admin.wishes.wishes_table');
    });
    $this->get('/wishes/completed', function () {
        return view('admin.wishes.wishes_table');
    });
    $this->get('/wishes/settings', 'WishesController@settings');

    $this->get('/users', function () {
        return view('admin.users.users_table');
    });
    $this->get('/users/activity', function () {
        return view('admin.users.users_table');
    });
    $this->get('/users/settings', 'UsersController@settings');

    $this->get('/achievements', function () {
        return view('admin.achievements.achievements_table');
    });
    $this->get('/achievements/prizes', function () {
        return view('admin.achievements.achievements_table');
    });
    $this->get('/achievements/new', function () {
        return view('admin.achievements.achievements_new');
    });
    $this->get('/achievements/settings', 'AchievementsController@settings');

    $this->get('/tickets', function () {
        return view('admin.tickets.tickets_table');
    });
    $this->get('/tickets/open', function () {
        return view('admin.tickets.tickets_table');
    });
    $this->get('/tickets/create', function () {
        return view('admin.tickets.tickets_new');
    });

    $this->get('/payments', function () {
        return view('admin.payments.payments_table');
    });
    $this->get('/payments/failed', function () {
        return view('admin.payments.payments_table');
    });

    $this->get('/tickets/{ticket}', 'TicketsController@show');
});

Route::middleware(['auth', 'admin', 'ajax'])->namespace('Admin')->prefix('admin/api')->group(function () {
    $this->get('/wishes', 'WishesController@all');
    $this->get('/wishes/reported', 'WishesController@reported');
    $this->get('/wishes/address', 'WishesController@address');
    $this->get('/wishes/completed', 'WishesController@completed');

    $this->patch('/wishes/{wish}', 'WishesController@update');
    $this->delete('/wishes/{wish}', 'WishesController@destroy');
    $this->delete('/wishes/address/{wish}', 'WishesController@destroy');
    $this->patch('/wishes/address/{wish}', 'WishesController@updateAddress');

    $this->get('/users', 'UsersController@all');
    $this->get('/users/activity', 'UsersController@activity');
    $this->get('/users/emails', 'TicketsController@emails');

    $this->patch('/users/{user}', 'UsersController@update');
    $this->delete('/users/{user}', 'UsersController@destroy');
    $this->patch('/users/activity/{user}', 'UsersController@updateActivity');
    $this->delete('/users/activity/{user}', 'UsersController@destroy');

    $this->patch('/users/settings', 'GlobalSettingsController@changeState');
    $this->patch('/users/settings/{setting}', 'GlobalSettingsController@changeValue');

    $this->get('/achievements', 'AchievementsController@allAchievements');
    $this->patch('/achievements/{achievement}', 'AchievementsController@updateAchievement');
    $this->delete('/achievements/{achievement}', 'AchievementsController@destroyAchievement');

    $this->post('/achievement/create', 'AchievementsController@newAchievement');
    $this->post('/prize/create', 'AchievementsController@newPrize');

    $this->get('/achievements/prizes', 'AchievementsController@allPrizes');
    $this->patch('/achievements/prizes/{prize}', 'AchievementsController@updatePrize');
    $this->delete('/achievements/prizes/{prize}', 'AchievementsController@destroyPrize');

    $this->get('/tickets', 'TicketsController@all');
    $this->get('/tickets/open', 'TicketsController@open');
    $this->patch('/tickets/{ticket}', 'TicketsController@update');
    $this->post('/tickets/create', 'TicketsController@new');
    $this->post('/tickets/reply/{ticket}', 'TicketsController@reply');

    $this->get('/payments', 'TransactionsController@all');
    $this->get('/payments/failed', 'TransactionsController@failed');
    $this->patch('/payments/{payment}', 'TransactionsController@update');
    $this->delete('/payments/{payment}', 'TransactionsController@destroy');

    $this->post('/search/{setting}', 'GlobalSettingsController@search');
    $this->delete('/search/{setting}', 'GlobalSettingsController@destroy');
    $this->patch('/search/{setting}', 'GlobalSettingsController@update');

    $this->patch('/settings/switch/{setting}', 'GlobalSettingsController@changeState');
    $this->patch('/settings/{setting}', 'GlobalSettingsController@changeValue');

    $this->get('/countries/visits', 'CountriesController@visits');
});

Route::post('/tickets/new')->middleware('ajax');

Route::post('/interkassa/payment', 'PurchasesController@interkassa');

Route::get('/construction', function () {
    return view('construction');
})->middleware('only-construction');

Route::get('/test', 'HomeController@test');