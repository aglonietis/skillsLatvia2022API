<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientDeliveryStoreRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *   @OA\Server(
 *      url="/api/v1"
 *   ),
 *   @OA\Info(
 *      title="Skills Latvia 2022 API",
 *      version="1.0.0",
 *   ),
 * )
 *
 *  @OA\SecurityScheme( 
 *     securityScheme="bearerAuth", 
 *     type="http", 
 *     scheme="bearer" 
 *  )
 *
 *  @OA\Schema( 
 *      schema="ListMetaResource", 
 *      @OA\Property(property="current_page", type="integer", example="1"), 
 *      @OA\Property(property="from", type="integer", example="1"), 
 *      @OA\Property(property="last_page", type="integer", example="49"), 
 *      @OA\Property(property="path", type="integer", example="https://<website>/api/v1/customers"), 
 *      @OA\Property(property="per_page", type="integer", example="10"), 
 *      @OA\Property(property="to", type="integer", example="10"), 
 *      @OA\Property(property="total", type="integer", example="484") 
 * )
 *
 * @OA\Schema( 
 *      schema="NullResource", 
 * )
 *
 * 
 *  ) 
 *
 * Store a newly created resource in storage.
 *
 * @param ClientDeliveryStoreRequest $request
 * @return JsonResponse
 */



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
