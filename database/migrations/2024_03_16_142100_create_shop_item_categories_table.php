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
        Schema::create('shop_item_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string("name")->unique();
            $table->unsignedBigInteger("item_category_id");
            $table->foreign("item_category_id")->references("id")->on("item_categories");
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
        Schema::dropIfExists('shop_item_categories');
    }
};
