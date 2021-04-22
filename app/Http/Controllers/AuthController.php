<?php

namespace App\Http\Controllers;

use App\Services\Constant;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        //validate incoming request
//        $this->validate($request, [
//            'email' => 'required|string',
//            'password' => 'required|string',
//        ]);
        $credentials = $request->only(['username', 'password']);
        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signIn(Request $request)
    {
//        $this->validate($request, [
//            'username' => 'required|string',
//            'email' => 'required|email|unique:users',
//            'msisdn' => 'required|unique:users',
//            'password' => 'required|confirmed',
//        ]);
        try {
            $input = $request->all();
            $input['password'] = app('hash')->make($input['password']);
            $input['permission_id'] = 1;
            $input['is_expert'] = Constant::EXPERT_DEFAULT;
            $input['register_type'] = Constant::REGISTER_TYPE_DEFAULT;
            $input['partner_id'] = Constant::PARTNER_DEFAULT;
            $user = $this->userService->createAccount($input);
            return response()->json(['user' => $user, 'message' => 'created'], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function sendOtp(Request $request) {

    }

    public function changePassword(Request $request) {
        $msisdn = $request->msisdn;
        $password = app('hash')->make($request->newPassword);
        return $password;
        try{
            $this->userService->updatePassword($msisdn, $password);
            return response()->json(['message' => "success", 'statusCode' => 200]);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['message' => 'update password failed!', 'statusCode' => 409]);
        }
    }

    public function getUserProfile(Request $request) {
        $userId = $request->userId;
        try{
            $user = $this->userService->getUserById($userId);
            return response()->json(['statusCode' => 200, 'data' => $user]);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['statusCode' => 1, 'message' => 'error' ]);
        }
    }

    public function updateUserProfile(Request $request) {

    }

    public function getListUser() {
        try{
            $users = $this->userService->getListUser();
            return response()->json(['users' => $users, 'message' => 'success'], 200);
        }catch (\Exception $e){
            return response()->json(['message' => 'Response User Failed', 409]);
        }
    }
}