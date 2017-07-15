<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('sourceDate');
            $table->integer('nbrPage')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('document_id')->unsigned();
            $table->date('date_scan')->nullable();
            $table->boolean('scanned')->default(false);
            $table->string('user_scan')->nullable();
            $table->date('date_import')->nullable();
            $table->boolean('imported')->default(false);
            $table->string('user_import')->nullable();
            $table->date('date_clipping')->nullable();
            $table->boolean('clipped')->default(false);
            $table->string('user_clipping')->nullable();
            $table->date('date_export')->nullable();
            $table->boolean('exported')->default(false);
            $table->string('user_export')->nullable();
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
        Schema::dropIfExists('receptions');
    }
}
