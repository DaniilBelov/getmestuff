<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\SendVerificationEmail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'ref' => 'sometimes|exists:users,ref_link',
            'terms' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => str_random(30),
            'ref_link' => str_random(5),
            'ref_id' => $data['ref'] ?? null,
            'locale' => app()->getLocale()
        ]);
    }

    public function confirmEmail($token) {
        User::whereToken($token)->firstOrFail()->confirmEmail();

        flash('You are now confirmed. Please login.');

        return redirect('login');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        dispatch(new SendVerificationEmail($user, app()->getLocale()));

        if (app()->getLocale() == 'en') flash('Please confirm your email');
        else flash('Пожалуйста подтвердите ваш email');

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function showRegistrationForm()
    {
        return view('auth.authenticate', [
            'form' => 'Sign Up',
        ]);
    }

    public function showRegistrationFormWithRef($ref)
    {
        return view('auth.authenticate', [
            'form' => 'Sign Up',
            'ref' => $ref
        ]);
    }
}
