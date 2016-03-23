<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Stripe\Stripe;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $redirectTo = 'home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        //Intialize the Stripe singleton
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY_SECRET'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'state' => 'required',
            'line1' => 'required',
            'city'=> 'required',
            'postal_code' => 'required',
            'dob' => 'required',
            'ssn_last_4' => 'required',

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
    $account = \Stripe\Account::create(
      array(
        "country" => "US",
        "managed" => true,
        'legal_entity' => [
          'first_name' => $data['first_name'],
          'last_name' => $data['last_name'],
          'line1' => $data['line1'],
          'city' => $data['city'],
          'state' => $data['state'],
          'postal_code' => $data['postal_code'],
          'dob' => $data['dob'],
          'ssn_last_4' => $data['ssn_last_4']
          ],
        'external_account' =>[
          'object'=>'bank_account',
          'account_number' => $data['account_number'],
          'routing_number' => $data['routing_number'],
          'country' => 'US',
          'currency' => 'USD',
          ]));
        return User::create([
            'name' => $data['first_name']. ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'stripe_public_key' => $account->keys->public,
            'stripe_private_key' => $account->keys->private
        ]);
    }
}
