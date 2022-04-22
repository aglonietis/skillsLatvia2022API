<?php

use App\Constants\RoleTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\SortingCenterController;
use App\Http\Controllers\Api\CourierController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// What is error on random page? By default it is not JSON
// Validation error page? by default not json
Route::prefix("/v1")->group(function () {
    Route::get("/", [HomeController::class, "home"]);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::middleware(['ability:' . RoleTypes::ADMIN])->group(function () {

            Route::prefix("/users")->group(function () {
                Route::post("/", [UserController::class, "store"]);
                Route::get("/", [UserController::class, "index"]);

                Route::prefix("/{user}")->group(function () {
                    Route::get("/", [UserController::class, "show"]);
                    Route::delete("/", [UserController::class, "destroy"]);
                    Route::put("/", [UserController::class, "update"]);
                });
            });

            Route::prefix("/deliveries")->group(function () {
                Route::post("/", [DeliveryController::class, "store"]);
                Route::get("/", [DeliveryController::class, "index"]);


                Route::prefix("/{delivery}")->group(function () {
                    Route::get("/", [DeliveryController::class, "show"]);
                    Route::delete("/", [DeliveryController::class, "destroy"]);
                    Route::put("/", [DeliveryController::class, "update"]);

                });
            });

            Route::prefix("/sorting-centers")->group(function () {
                Route::post("/", [SortingCenterController::class, "store"]);
                Route::get("/", [SortingCenterController::class, "index"]);

                Route::prefix("/{center}")->group(function () {
                    Route::get("/", [SortingCenterController::class, "show"]);
                    Route::delete("/", [SortingCenterController::class, "destroy"]);
                    Route::put("/", [SortingCenterController::class, "update"]);
                });
            });
        });

        Route::middleware(['ability:' . RoleTypes::ADMIN . "," . RoleTypes::COURIER])->group(function () {

            Route::prefix("/deliveries")->group(function () {
                Route::prefix("/trackers/{tracker}")->group(function () {
                    Route::get('/', [CourierController::class, 'show']);
                    Route::put('/', [CourierController::class, 'update']); // mistake in task to get by unique number
                });
            });
        });

        Route::middleware(['ability:' . RoleTypes::ADMIN . "," . RoleTypes::CLIENT])->group(function () {
            Route::prefix("/clients/self/deliveries")->group(function() {
                Route::get("/",[ClientController::class,"index"]);
                Route::post("/",[ClientController::class,"store"]);
                Route::prefix("/trackers/{tracker}")->group(function () {
                    Route::get('/', [ClientController::class, 'showByTracker']);
                });
            });
        });

    });

    Route::prefix("/clients")->group(function () {

        Route::post("/", [AuthController::class, "register"]);
        Route::post("/login", [AuthController::class, "login"]);
    });

    Route::prefix("/deliveries/trackers/{tracker}/statuses")->group(function () {
        Route::get('/', [DeliveryController::class, 'statusIndex']);
    });
});
