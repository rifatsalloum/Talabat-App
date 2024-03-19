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
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("shop_id");
            $table->unsignedBigInteger("item_id");
            $table->integer("quantity");
            $table->float("price");
            $table->float("avg_rate")->nullable();
            $table->boolean("trending");
            $table->unsignedBigInteger("shop_item_category_id");
            $table->unsignedBigInteger("offer_id")->nullable();
            $table->foreign("shop_id")->references("id")->on("shops")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("item_id")->references("id")->on("items")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("shop_item_category_id")->references("id")->on("shop_item_categories")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("offer_id")->references("id")->on("offers")->onDelete("set null")->onUpdate("cascade");
            $table->unique(["shop_id","item_id"]);
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
        Schema::dropIfExists('shop_items');
    }
};
