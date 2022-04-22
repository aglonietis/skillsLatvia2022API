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
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Constants\DeliveryTypes;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param Delivery $delivery
     * @return JsonResponse
     */
    public function show(Delivery $delivery)
    {
        return response()->json(new DeliveryResource($delivery),Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
     * Display the specified resource.
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
