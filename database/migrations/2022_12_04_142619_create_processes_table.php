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
        Schema::create('processes', function (Blueprint $table) {
            $table->ulid('id')->primary();


            $table->ulid('type_process_id')->nullable(false);
            $table->foreign('type_process_id')
                    ->references('id')
                    ->on('type_processes')
                    ->onDelete('cascade');

            $table->string('state');

            $table->ulid('user_id')->nullable(false);
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->ulid('business_id')->nullable(false);
            $table->foreign('business_id')
                    ->references('id')
                    ->on('business')
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
        Schema::dropIfExists('processes');
    }
};
