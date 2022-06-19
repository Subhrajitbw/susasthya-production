<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    //use AuthenticateUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function update(Request $request, $patient_id)
    {
        $rules = [
            'name'            =>  'required',
            
            'email'                 =>  'required|email|unique:users',
            'phone_number'          =>  'required'
            
        ];

        $messages = [
            'name.required'   =>  'Your first name is required.',
            'email.required'        =>  'Your emails address is required.',
            'email.unique'          =>  'That email address is already in use.',
            'phone_number.required'          =>  'Phone Umber is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails())
        {
            return response()->json(array('errors' => $validator->errors()->toArray()));
        }else{
            $user = User::where('patient_id', $patient_id)->firstOrFail();

            if($user->name !== $request->input('name'))
            {
                $user->name = $request->input('name');
            }
            
            if($user->email !== $request->input('email'))
            {
                $user->email = $request->input('email');
            }
            if($user->phone_number !== $request->input('phone_number'))
            {
                $user->phone_number = $request->input('phone_number');
            }
            $user->save();

            return response("Updated Successfully", 201);
        }
    }

    public function changePassword(Request $request, $patient_id)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = User::where('patient_id', $patient_id)->firstOrFail();

        if (!Hash::check($request->current_password, $user->password)) {
            return response('Current password does not match!', 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response('Password successfully changed!', 201);
    }

}
