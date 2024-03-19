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
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("shop_id");
            $table->unsignedBigInteger("shop_item_id");
            $table->unsignedBigInteger("shop_item_attribute_id")->nullable();
            $table->integer("number");
            $table->float("price");
            $table->string("notes")->nullable();
            $table->foreign("shop_item_id")->references("id")->on("shop_items");
            $table->foreign("shop_item_attribute_id")->references("id")->on("shop_item_attributes");
            $table->foreign("shop_id")->references("id")->on("shops");
            $table->unique(["shop_item_id","shop_item_attribute_id"]);
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
        Schema::dropIfExists('baskets');
    }
};
