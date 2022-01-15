<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('b_id')->index();
            $table->integer('u_id')->index();
            $table->tinyInteger('status');
            $table->dateTime('book_rented_on')->nullable();
            $table->dateTime('book_returned_on')->nullable();
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
        Schema::dropIfExists('books_transactions');
    }
}
