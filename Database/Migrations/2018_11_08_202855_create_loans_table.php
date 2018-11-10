<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('name')->nullable();
            $table->string('telephone')->nullable();

            $table->boolean('returned')->default(false);

            $table->timestamp('date');

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
        Schema::dropIfExists('loans');
    }
}
