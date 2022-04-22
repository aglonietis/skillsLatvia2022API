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
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SortingCenterResource::collection(
            SortingCenter::query()->paginate(config('skills.pagination.per_page'))
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  SortingCenterStoreRequest $request
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
     * Display the specified resource.
     *
     * @param  SortingCenter $center
     * @return JsonResponse
     */
    public function show(SortingCenter $center)
    {
        return response()->json(new SortingCenterResource($center));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SortingCenterUpdateRequest  $request
     * @param  SortingCenter  $center
     * @return JsonResponse
     */
    public function update(SortingCenterUpdateRequest $request,SortingCenter $center)
    {
        $center->fill($request->validated());

        $center->save();

        return response()->json(new SortingCenterResource($center->refresh()),Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SortingCenter $center
     * @return JsonResponse
     */
    public function destroy(SortingCenter $center)
    {
        $center->delete();

        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
