<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string("name");
            $table->string("address");
            $table->string("phone");
            $table->string("email");
            $table->string("image");
            $table->float("basket_price")->default(0);
            $table->float("delivery_price");
            $table->integer("delivery_time");
            $table->integer("delivery_discount")->default(0);
            $table->float("avg_rate")->nullable();
            $table->unsignedBigInteger("country_id");
            $table->unsignedBigInteger("cuisine_id")->nullable();
            $table->unsignedBigInteger("offer_id")->nullable();
            $table->foreign("country_id")->references("id")->on("countries");
            $table->foreign("cuisine_id")->references("id")->on("cuisines");
            $table->foreign("offer_id")->references("id")->on("offers")->onDelete("set null")->onUpdate("cascade");
            $table->unique(["name","country_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
