<?php

namespace App\Http\Controllers\Api;

use App\Constants\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Resources\AuthenticationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register
     *
     * @param  ClientStoreRequest $request
     * @return JsonResponse
     */
    public function register(ClientStoreRequest $request)
    {
        $user = new User();

        $user->fill($request->validated());
        $user->role = RoleTypes::CLIENT;
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return response()->json(new UserResource($user),Response::HTTP_CREATED);
    }

    /**
     * Login
     *
     * @param  ClientLoginRequest $request
     * @return JsonResponse
     */
    public function login(ClientLoginRequest $request)
    {
        $attempt = Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);

        if(! $attempt) {
            response()->json([],Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken(config('skills.auth.token_name'),[$request->user()->role]);

        return response()->json(new AuthenticationResource($token),Response::HTTP_OK);
    }
}
