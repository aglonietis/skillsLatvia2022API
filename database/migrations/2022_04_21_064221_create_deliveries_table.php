<?php

use App\Constants\DeliveryTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('source_address','512');
            $table->string('delivery_address','512');
            $table->string('phone_number');
            $table->string('email');
            $table->integer('size_depth');
            $table->integer('size_width');
            $table->integer('size_height');
            $table->integer('weight');
            $table->enum('status',[DeliveryTypes::ACCEPTED,DeliveryTypes::IN_SORT_CENTER,DeliveryTypes::ON_ROAD,DeliveryTypes::DELIVERED]);
            $table->string('uuid');
            $table->string('tracking_uuid')->index();
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
        Schema::dropIfExists('deliveries');
    }
}
