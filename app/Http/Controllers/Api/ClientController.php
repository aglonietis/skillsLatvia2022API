<?php

namespace App\Http\Controllers\Api;

use App\Constants\DeliveryTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientDeliveryStoreRequest;
use App\Http\Resources\DeliveryListResource;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * @OA\Get(
     * path="/clients/self/deliveries",
     * security={{"bearerAuth":{}}},
     * summary="Display list of deliveries for a client",
     * description="Display delivery list for a client",
     * operationId="ClientDeliveriesList",
     * tags={"Client"},
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
     *
     * )
     *
     *
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $userId = (int)$request->user()->id;

        return DeliveryListResource::collection(
            Delivery::query()->orderBy('status', 'asc')
                ->where('user_id', '=', $userId)
                ->paginate(config('skills.pagination.per_page'))
        );
    }

    /**
     * @OA\Post(
     * path="/clients/self/deliveries",
     * security={{"bearerAuth":{}}},
     * summary="Create a new delivery for a client",
     * description="Create a new delivery for a client",
     * operationId="ClientDeliveryCreate",
     * tags={"Client"},
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             ref="#/components/schemas/ClientDeliveryStoreRequest",
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
     * @param ClientDeliveryStoreRequest $request
     * @return JsonResponse
     */
    public function store(ClientDeliveryStoreRequest $request)
    {
        $userId = (int)$request->user()->id;

        $delivery = new Delivery();

        $delivery->fill($request->validated());
        $delivery->user_id = $userId;
        $delivery->status = DeliveryTypes::ACCEPTED;
        $delivery->uuid = "LV-" . Str::uuid(); // Could add substr from the source address
        $delivery->tracking_uuid = Str::random(config('skills.delivery.tracker_length'));
        $delivery->save();

        return response()->json(new DeliveryResource($delivery), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     * path="/clients/self/deliveries/trackers/{tracker}",
     * security={{"bearerAuth":{}}},
     * summary="Find a delivery by tracking uuid",
     * description="Find a delivery by tracking uuid",
     * operationId="ClientDeliveryFindByTracker",
     * tags={"Client"},
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
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/DeliveryResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     *
     * @param Request $request
     * @param string $tracker
     * @return JsonResponse
     */
    public function showByTracker(Request $request, string $tracker)
    {
        $userId = (int)$request->user()->id;

        $delivery = Delivery::query()->where('tracking_uuid', '=', $tracker)
            ->where('user_id', '=', $userId)->first();

        if (empty($delivery)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new DeliveryResource($delivery));
    }
}
