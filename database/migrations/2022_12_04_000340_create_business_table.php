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
        Schema::create('business', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('business_name');
            $table->integer('phone');
            $table->integer('nit');
            $table->string('address');
            $table->string('department');
            $table->string('city');
            $table->string('type_person');
            $table->string('city_register');
            $table->string('email');
            $table->date('expiration_date');
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
        Schema::dropIfExists('business');
    }
};
