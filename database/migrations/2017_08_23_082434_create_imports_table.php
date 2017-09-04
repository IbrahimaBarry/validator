<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('scan_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('imported')->default(false);
            $table->boolean('confirmed')->default(false);
            $table->boolean('affected')->default(false);
            $table->string('admin')->nullable();
            $table->timestamp('date_import')->nullable();
            $table->foreign('scan_id')->references('id')->on('scans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('imports');
    }
}
