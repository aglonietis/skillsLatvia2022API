<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryCourierUpdateRequest;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\DeliveryResource;
use Illuminate\Http\Response;

class CourierController extends Controller
{
    /**
     * @OA\Get(
     * path="/deliveries/trackers/{tracker}",
     * summary="Find a delivery by tracking uuid",
     * description="Find a delivery by tracking uuid",
     * operationId="CourierDeliveryFindByTracker",
     * tags={"Courier"},
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
     *    response=200,
     *    description="Data",
     *    @OA\JsonContent( 
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/DeliveryResource"),
     *      }
     *    ) 
     *  )
     * )
     *
     * @param string $tracker
     *
     * @return JsonResponse
     */
    public function show(string $tracker)
    {
        $delivery = Delivery::query()->where('tracking_uuid', '=', $tracker)->first();

        if (empty($delivery)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new DeliveryResource($delivery));
    }

    /**
     * @OA\Put(
     * path="/deliveries/trackers/{tracker}",
     * summary="Update delivery status by tracking uuid",
     * description="Find delivery by tracking uuid and update delivery status",
     * operationId="CourierDeliveryStatusUpdate",
     * tags={"Courier"},
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
     * @OA\RequestBody(
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             ref="#/components/schemas/DeliveryCourierUpdateRequest",
     *         )
     *     )
     * ),
     * @OA\Response(
     *    response=200,
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
     * @param DeliveryCourierUpdateRequest $request
     * @param string $tracker
     *
     * @return JsonResponse
     */
    public function update(DeliveryCourierUpdateRequest $request, string $tracker)
    {
        $delivery = Delivery::query()->where('tracking_uuid', '=', $tracker)->first();

        if (empty($delivery)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        $delivery->status = $request->get('status');

        $delivery->save();

        return response()->json(new DeliveryResource($delivery->refresh()), Response::HTTP_OK);
    }
}
