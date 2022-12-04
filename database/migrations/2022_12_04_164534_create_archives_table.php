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
        Schema::create('archives', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->ulid('document_id')->nullable(false);
            $table->foreign('document_id')
                    ->references('id')
                    ->on('documents')
                    ->onDelete('cascade');

            $table->string('type_archive');
            $table->string('path');
            $table->string('name_now');
            $table->string('name_previous');

            $table->ulid('process_id')->nullable(false);
            $table->foreign('process_id')
                    ->references('id')
                    ->on('processes')
                    ->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archives');
    }
};
