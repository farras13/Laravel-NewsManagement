<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            $success['is_admin'] = $user->is_admin;

            return ApiFormatter::createApi(200, 'Success Login', $success);
        }
        else{
            return ApiFormatter::createApi(401, 'Failed Login');
        }
    }

    // register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {

            return ApiFormatter::createApi(401, 'Error', $validator->errors());
        }

        $input = $request->all();
        $input['is_admin'] = empty($input['is_admin']) ? 0 : 1;
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;
        $success['is_admin'] = $user->is_admin;
        return ApiFormatter::createApi(200, 'Success Register', $success);
    }
}
