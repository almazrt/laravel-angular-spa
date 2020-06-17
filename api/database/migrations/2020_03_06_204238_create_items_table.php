<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('category_id')->nullable()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('insta')->nullable();
            $table->string('telegram')->nullable();
            $table->string('vk')->nullable();
            $table->string('fb')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('other_contacts')->nullable();
            $table->smallInteger('status');
            $table->softDeletes();
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
        Schema::drop('items');
    }

}
