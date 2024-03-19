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
        Schema::create('shop_item_attributes', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("shop_item_id");
            $table->unsignedBigInteger("value_id");
            $table->float("plus_price")->default(0);
            $table->foreign("shop_item_id")->references("id")->on("shop_items")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("value_id")->references("id")->on("values")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(["shop_item_id","value_id"]);
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
        Schema::dropIfExists('shop_item_attributes');
    }
};
