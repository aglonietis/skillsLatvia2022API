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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $userId = (int)$request->user()->id;

        return DeliveryListResource::collection(
            Delivery::query()->orderBy('status', 'asc')
                ->where('customer_id', '=', $userId)
                ->paginate(config('skills.pagination.per_page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientDeliveryStoreRequest $request
     * @return JsonResponse
     */
    public function store(ClientDeliveryStoreRequest $request)
    {
        $userId = (int)$request->user()->id;

        $delivery = new Delivery();

        $delivery->fill($request->validated());
        $delivery->customer_id = $userId;
        $delivery->status = DeliveryTypes::ACCEPTED;
        $delivery->uuid = "LV-" . Str::uuid(); // Could add substr from the source address
        $delivery->tracking_uuid = Str::random(config('skills.delivery.tracker_length'));
        $delivery->save();

        return response()->json(new DeliveryResource($delivery), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $tracker
     * @return JsonResponse
     */
    public function showByTracker(Request $request,string $tracker)
    {
        $userId = (int)$request->user()->id;

        $delivery = Delivery::query()->where('tracking_uuid', '=', $tracker)
            ->where('customer_id', '=', $userId)->first();

        if (empty($delivery)) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new DeliveryResource($delivery));
    }
}
