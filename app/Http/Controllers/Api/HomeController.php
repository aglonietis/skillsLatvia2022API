<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return JsonResponse
     */
    public function home()
    {
        return response()->json(["API" => config("app.name")]);
    }
}
