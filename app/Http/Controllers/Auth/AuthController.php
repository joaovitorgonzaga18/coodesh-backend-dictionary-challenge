<?php

namespace App\Http\Controllers\Auth;

use App\Domain\User\UserDataValidator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {    
    public function signIn(Request $request): JsonResponse {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|max:100',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->buildBadRequestResponse('Invalid Credentials');
        }

        $token = $user->createToken('auth_token');

        return $this->buildSuccessResponse([
            'success' => true,
            'message' => 'Logged in',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    public function signUp(Request $request): JsonResponse {

        try {            
            
            $validator = new UserDataValidator();

            $uuid = Str::uuid();
            
            $validator->validateId($uuid);
            $validator->validateName($request->name);
            $validator->validateEmail($request->email);
            $validator->validatePassword($request->password);

            $user = User::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->save();
            $token = JWTAuth::fromUser($user);

            return $this->buildSuccessResponse([
                'id' => $user->uuid,
                'name' => $user->name,
                'token' => $token,
            ]);

        } catch(Exception $e) {
            return $this->buildBadRequestResponse($e->getMessage());
        }
    }

    /* public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return $this->buildSuccessResponse(['success' => true, 'message' => 'Logged out']);
    } */
}
