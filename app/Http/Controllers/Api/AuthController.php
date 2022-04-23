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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *  path="/clients",
     *  summary="Register",
     *  description="Register a new Client",
     *  operationId="authRegister",
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Create a new Client",
     *      @OA\JsonContent(
     *          required={"email","password", "name", "surname"},
     *          @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *          @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *          @OA\Property(property="name", type="string", format="password", example="Gibril"),
     *          @OA\Property(property="surname", type="string", format="password", example="Pavlovic"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Succesfully logged in",
     *      @OA\JsonContent(
     *          @OA\Property(property="plainTextToken", type="string", example="5|WhdOuIUQUwiRssfaGbdhfgGQLVF2gyBC0Z3EA7sdbm4vxFS")
     *     )
     *  )
     * )
     *
     * @param ClientStoreRequest $request
     * @return JsonResponse
     */
    public function register(ClientStoreRequest $request)
    {
        $user = new User();

        $user->fill($request->validated());
        // Role should be set to client, because registration is a public endpoint for clients
        $user->role = RoleTypes::CLIENT;
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     * path="/clients/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Succesfully logged in",
     *    @OA\JsonContent(
     *       @OA\Property(property="plainTextToken", type="string", example="5|WhdOuIUQUwiRssfaGbdhfgGQLVF2gyBC0Z3EA7sdbm4vxFS")
     *        )
     *     )
     * )
     *
     * @param ClientLoginRequest $request
     * @return JsonResponse
     */
    public function login(ClientLoginRequest $request)
    {
        $attempt = Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);

        if (!$attempt) {
            return response()->json([], Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken(config('skills.auth.token_name'), [$request->user()->role]);

        return response()->json(new AuthenticationResource($token), Response::HTTP_OK);
    }
}
