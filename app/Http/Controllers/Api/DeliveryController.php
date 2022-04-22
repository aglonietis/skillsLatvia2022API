<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryUpdateRequest;
use App\Http\Resources\StatusResource;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\DeliveryListResource;
use App\Http\Resources\DeliveryResource;
use App\Http\Requests\DeliveryStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Constants\DeliveryTypes;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    /**
     * @OA\Get(
     * path="/deliveries",
     * summary="Displays delivery list",
     * description="Displays delivery list",
     * operationId="DeliveryList",
     * tags={"Delivery"},
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
     *                           ref="#/components/schemas/DeliveryListResource" 
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
        return DeliveryListResource::collection(
            Delivery::query()->orderBy('status', 'asc')->paginate(config('skills.pagination.per_page'))
        );
    }


    /**
     * @OA\Post(
     * path="/deliveries",
     * summary="Create a new Delivery",
     * description="Create a new Delivery",
     * operationId="DeliveryStore",
     * tags={"Delivery"},
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             ref="#/components/schemas/DeliveryStoreRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/DeliveryResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param DeliveryStoreRequest $request
     * @return JsonResponse
     */
    public function store(DeliveryStoreRequest $request)
    {
        $delivery = new Delivery();

        $delivery->fill($request->validated());
        $delivery->status = DeliveryTypes::ACCEPTED;
        $delivery->uuid = "LV-" . Str::uuid(); // Could add substr from the source address
        $delivery->tracking_uuid = Str::random(config('skills.delivery.tracker_length'));
        $delivery->save();

        return response()->json(new DeliveryResource($delivery), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     * path="/deliveries/{id}",
     * summary="Displays Delivery by id",
     * description="Displays Delivery by id",
     * operationId="DeliveryShow",
     * tags={"Delivery"},
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
     *          @OA\Schema(ref="#/components/schemas/DeliveryResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     * @param Delivery $delivery
     * @return JsonResponse
     */
    public function show(Delivery $delivery)
    {
        return response()->json(new DeliveryResource($delivery),Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     * path="/deliveries/{id}",
     * summary="Update an existing Delivery",
     * description="Update an existing Delivery",
     * operationId="DeliveryUpdate",
     * tags={"Delivery"},
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
     *             ref="#/components/schemas/DeliveryUpdateRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/DeliveryResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param DeliveryUpdateRequest $request
     * @param Delivery $delivery
     * @return JsonResponse
     */
    public function update(DeliveryUpdateRequest $request, Delivery $delivery)
    {
        $delivery->fill($request->validated());

        $delivery->save();

        return response()->json(new DeliveryResource($delivery->refresh()), Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     * path="/deliveries/{id}",
     * summary="Delete Delivery by id",
     * description="Delete Delivery by id",
     * operationId="DeliveryDelete",
     * tags={"Delivery"},
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
     * @param Delivery $delivery
     * @return JsonResponse
     */
    public function destroy(Delivery $delivery)
    {
        $delivery->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     * path="/deliveries/trackers/{tracker}/statuses",
     * summary="Find delivery status history by tracking uuid",
     * description="Find delivery status history by tracking uuid",
     * operationId="PublicDeliveryFindByTrackerStatuses",
     * tags={"Public"},
     * @OA\Parameter(
     *        name="tracker",
     *        in="path",
     *        description="Delivery Tracking uuid",
     *        @OA\Schema(
     *           type="string"
     *        ),
     *        required=true,
     *        example="2421j4j128"
     * ),
     * @OA\Response(
     *    response=201,
     *    description="Data",
     *    @OA\JsonContent( 
     *      type="array",
     *           @OA\Items(ref="#/components/schemas/StatusResource")
     *    ) 
     *  )
     * )
     *
     * @param string $tracker
     * @return JsonResponse
     */
    public function statusIndex(string $tracker)
    {
        $delivery = Delivery::query()->where('tracking_uuid', '=', $tracker)->first();

        if (empty($delivery)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        return response()->json(StatusResource::collection($delivery->statuses));
    }
}
