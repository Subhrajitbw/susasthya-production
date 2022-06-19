<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Doctor;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DoctorRegisterController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
    protected function validator(Request $request)
    {
        
     $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email', 'max:255'],
            'phone_number' => ['required', 'string', 'min: 10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->errors()->toArray()));
        } 
        else
        // $counts =  Doctor::count();
        // $count = $counts+1000;
        // $year = date("Y");
        // $patient_id = $count.$year;
        $user = new Doctor();
        $user->name = $request->input('name');
        $user->location = $request->input('location');
        $user->specialization = $request->input('specialization');
        $user->department = $request->input('department');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->password = Hash::make($request->input('password'));
        //$user->patient_id = $patient_id;
        $user->role_id="3";
        $user->save();
            return response($user, 201);
           
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        
    }
}

