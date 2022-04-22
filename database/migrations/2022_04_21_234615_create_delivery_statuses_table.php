<?php

use App\Constants\DeliveryTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_id')->index();
            $table->enum('status',[DeliveryTypes::ACCEPTED,DeliveryTypes::IN_SORT_CENTER,DeliveryTypes::ON_ROAD,DeliveryTypes::DELIVERED]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_statuses');
    }
}
