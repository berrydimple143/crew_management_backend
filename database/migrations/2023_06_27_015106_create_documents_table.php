<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('document_name');
            $table->string('document_number');
            $table->string('filename')->nullable()->default('');
            $table->timestamp('issue_date')->useCurrent();
            $table->timestamp('expiry_date')->useCurrent();
            $table->unsignedBigInteger('crew_id');
            $table->foreign('crew_id')->references('id')->on('crews');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('documents');
    }
}
