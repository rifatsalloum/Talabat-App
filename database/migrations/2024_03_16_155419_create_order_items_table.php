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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("shop_item_id");
            $table->unsignedBigInteger("shop_item_attribute_id")->nullable();
            $table->float("price");
            $table->integer("number");
            $table->string("notes")->nullable();
            $table->foreign("order_id")->references("id")->on("orders")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("shop_item_id")->references("id")->on("shop_items")->onUpdate("cascade");
            $table->foreign("shop_item_attribute_id")->references("id")->on("shop_item_attributes")->onUpdate("cascade");
            $table->unique(["order_id","shop_item_id","shop_item_attribute_id"]);
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
        Schema::dropIfExists('order_items');
    }
};
