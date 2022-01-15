<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegister;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(UserRegister $request)
    {
        $user = new User();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->password = bcrypt($request->password);
        $user->city = $request->city;

        $user->save();

        return response()->api(true, 'User registered successfully', null);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->api(false,$validator->messages(),null);
        }

        //Request is validated
        //Create token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->api(false, 'Login credentials are invalid.', null);
            }
        } catch (JWTException $e) {
            return response()->api(false, 'Could not create token.', null);
        }

        //Token created, return with success response and jwt token
        return response()->api(true, 'Login successfully',$token);
    }
}
