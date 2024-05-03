<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginPoint;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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
    protected $redirectTo = '/home';

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
        return Validator::make($data, [
            // 'name' => ['string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:255', 'unique:users'],
            // 'phone' => ['numeric', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            // 'name' => $data['name'],
            'username' => $data['username'],
            // 'phone' => $data['phone'],
            'referral_code' => Str::random(7),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
      
    
        $roleId = Role::where('name', 'user')->first()->id;
        $user->assignRole($roleId);
        
        Wallet::create(['user_id' => $user->id, 'balance' => '0.00', 'currency' => 'USD', 'level' => 'Freemuim']);
        return $user;

    }



   
}
