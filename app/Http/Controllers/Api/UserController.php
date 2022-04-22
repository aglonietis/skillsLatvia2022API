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
     * @OA\Get(
     * path="/users",
     * summary="Displays user list",
     * description="Displays user list",
     * operationId="UserList",
     * tags={"User"},
     * @OA\RequestBody(
     *    description="Page number",
     *    @OA\JsonContent(
     *       @OA\Property(property="page", type="integer", example="1"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Data",
     *    @OA\JsonContent( 
     *             @OA\Property( 
     *                 property = "data", 
     *                 type="array", 
     *                      @OA\Items( 
     *                           ref="#/components/schemas/UserResource" 
     *                      ) 
     *            ) 
     *    ) 
     *
     *  )
     * )
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
     * @OA\Post(
     * path="/users",
     * summary="Create a new user",
     * description="Create a new user",
     * operationId="UserStore",
     * tags={"User"},
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             ref="#/components/schemas/UserStoreRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/UserResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param UserStoreRequest $request
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
     * @OA\Get(
     * path="/users/{id}",
     * summary="Displays user by id",
     * description="Displays user by id",
     * operationId="UserShow",
     * tags={"User"},
     * @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="Object ID",
     *        @OA\Schema(
     *           type="string"
     *        ),
     *        required=true,
     *        example="3"
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Data",
     *    @OA\JsonContent( 
     *      allOf={
     *          @OA\Schema(ref="#/components/schemas/UserResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    /**
     * @OA\Post(
     * path="/users/{id}",
     * summary="Update an existing user",
     * description="Update an existing user",
     * operationId="UserUpdate",
     * tags={"User"},
     * @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="Object ID",
     *        @OA\Schema(
     *           type="string"
     *        ),
     *        required=true,
     *        example="3"
     * ),
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             ref="#/components/schemas/UserUpdateRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/UserResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param UserUpdateRequest $request
     * @param User $user
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
     * @OA\Delete(
     * path="/users/{id}",
     * summary="Delete user by id",
     * description="Delete user by id",
     * operationId="UserDelete",
     * tags={"User"},
     * @OA\Parameter(
     *        name="id",
     *        in="path",
     *        description="Object ID",
     *        @OA\Schema(
     *           type="string"
     *        ),
     *        required=true,
     *        example="3"
     * ),
     * @OA\Response(
     *    response=204,
     *    description="Data",
     *    @OA\JsonContent( 
     *      allOf={
     *          @OA\Schema(ref="#/components/schemas/NullResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     * @param User $user
     * @return AnonymousResourceCollection
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
