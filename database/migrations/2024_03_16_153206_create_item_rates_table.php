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
        Schema::create('item_rates', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("shop_item_id");
            $table->unsignedBigInteger("user_id");
            $table->integer("rate");
            $table->string("comment");
            $table->foreign("shop_item_id")->references("id")->on("shop_items")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(["shop_item_id","user_id"]);
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
        Schema::dropIfExists('item_rates');
    }
};
