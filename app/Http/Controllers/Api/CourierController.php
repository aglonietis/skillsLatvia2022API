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
     * Display the specified resource.
     *
     * @param string $tracker
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
     * Update the specified resource in storage.
     *
     * @param DeliveryCourierUpdateRequest $request
     * @param string $tracker
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
