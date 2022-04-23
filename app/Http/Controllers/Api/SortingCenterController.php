<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SortingCenterUpdateRequest;
use App\Models\SortingCenter;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SortingCenterResource;
use App\Http\Requests\SortingCenterStoreRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SortingCenterController extends Controller
{
    /**
     * @OA\Get(
     * path="/sorting-centers",
     * summary="Displays SortingCenter list",
     * description="Displays SortingCenter list",
     * operationId="SortingCenterList",
     * tags={"SortingCenter"},
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
     *                           ref="#/components/schemas/SortingCenterResource" 
     *                      ) 
     *            ) 
     *    ) 
     *
     *  )
     * )
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(SortingCenterResource::collection(
            SortingCenter::query()->paginate(config('skills.pagination.per_page'))
        ),Response::HTTP_OK);
    }


    /**
     * @OA\Post(
     * path="/sorting-centers",
     * summary="Create a new SortingCenter",
     * description="Create a new SortingCenter",
     * operationId="SortingCenterStore",
     * tags={"SortingCenter"},
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             ref="#/components/schemas/SortingCenterStoreRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/SortingCenterResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param SortingCenterStoreRequest $request
     * @return JsonResponse
     */
    public function store(SortingCenterStoreRequest $request)
    {
        $center = new SortingCenter();

        $center->fill($request->validated());
        $center->save();

        return response()->json(new SortingCenterResource($center),Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     * path="/sorting-centers/{id}",
     * summary="Displays SortingCenter by id",
     * description="Displays SortingCenter by id",
     * operationId="SortingCenterShow",
     * tags={"SortingCenter"},
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
     *          @OA\Schema(ref="#/components/schemas/SortingCenterResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     * @param SortingCenter $center
     * @return JsonResponse
     */
    public function show(SortingCenter $center)
    {
        return response()->json(new SortingCenterResource($center),Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     * path="/sorting-centers/{id}",
     * summary="Update an existing SortingCenter",
     * description="Update an existing SortingCenter",
     * operationId="SortingCenterUpdate",
     * tags={"SortingCenter"},
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
     *             ref="#/components/schemas/SortingCenterUpdateRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/SortingCenterResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param SortingCenterUpdateRequest $request
     * @param SortingCenter $center
     * @return JsonResponse
     */
    public function update(SortingCenterUpdateRequest $request,SortingCenter $center)
    {
        $center->fill($request->validated());

        $center->save();

        return response()->json(new SortingCenterResource($center->refresh()),Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     * path="/sorting-centers/{id}",
     * summary="Delete SortingCenter by id",
     * description="Delete SortingCenter by id",
     * operationId="SortingCenterDelete",
     * tags={"SortingCenter"},
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
     * @param SortingCenter $center
     * @return JsonResponse
     */
    public function destroy(SortingCenter $center)
    {
        $center->delete();

        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
