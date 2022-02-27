<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Function To Register New Users
     * 
     * @param Request $request
     * 
     * @return object
     */
    public function register(Request $request): object
    {
        /**
         * Validating Request data
         */
        $this->validate($request, [
            'first_name' => 'required|min:3|max:10|alpha',
            'last_name' => 'required|min:3|max:10|alpha',
            'email' => 'email|unique:users,email',
            'phone_number' => 'required|unique:users,phone_number|numeric|digits:10',
            'gender' => 'required|in:male,female,others',
            'password' => 'required|alpha_num|min:6|max:16|confirmed',
        ]);

        $user = new User;

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email ?? null;
        $user->phone_number = $request->phone_number;
        $user->gender = $request->gender;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'message' => config('api-config.MESSAGES.SUCCESSFULLY_REGISTERED_USER')
        ], 201);
    }

    /**
     * Function To Validate User Creds and to login
     * 
     * 
     * @param Request $request
     * 
     * @return object
     */
    public function login(Request $request): object
    {
        $this->validate($request, [
            'phone_number' => 'required|numeric|digits:10|exists:users,phone_number',
            'password' => 'required',
        ]);

        $token = JWTAuth::attempt([
            'phone_number' => $request->phone_number,
            'password' => $request->password
        ]);

        $message = [
            "token" => $token
        ];

        $statusCode = config('api-config.STATUS_CODE.SUCCESS');

        if (!$token) {
            $message = [
                "error_code" => config('api-config.MESSAGES.INVALID_CREDENTIALS')
            ];

            $statusCode = config('api-config.STATUS_CODE.UNAUTHORIZED');
        }

        return response()->json($message, $statusCode);
    }
}
