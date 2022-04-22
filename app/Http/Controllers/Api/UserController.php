<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(
         User::query()->paginate(config('skills.pagination.per_page'))
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        $user = new User();

        $user->fill($request->validated());
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return response()->json(new UserResource($user),Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request,User $user)
    {
        $user->fill($request->validated());

        if($request->has('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        return response()->json(new UserResource($user->refresh()),Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
