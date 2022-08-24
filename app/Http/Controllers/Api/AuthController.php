<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    const LARAVEL8_PASSPORT_AUTH = 'Laravel Password Grant Client';

    /**
     * Register user ("password_confirmation" request param is required)
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function register (Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 400);
        }

        $request['password']=Hash::make($request['password']);
        /** @var User $user */
        $user = User::create($request->toArray());

        return response($this->getToken($user), 200);
    }

    /**
     * Login action (email/password are required)
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function login (Request $request)
    {
        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response($this->getToken($user), 200);
            } else {
                $response = "Password missmatch";
                return response($response, 401);
            }

        } else {
            $response = 'User does not exist';
            return response($response, 422);
        }

    }

    private function getToken(User $user)
    {
        $token = $user->createToken(self::LARAVEL8_PASSPORT_AUTH)->accessToken;

        return ['token' => $token];
    }

    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);

    }

    public function userInfo()
    {
        $user = auth()->user();
        $response = ['user' => $user];
        return response($response, 200);
    }
}
