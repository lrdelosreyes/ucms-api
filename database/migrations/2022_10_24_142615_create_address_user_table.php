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
        Schema::create('address_contact', function (Blueprint $table) {
            $table->uuid('contact_id')->index();
            $table->foreign('contact_id')
                ->on('contacts')
                ->references('id')
                ->cascadeOnDelete();
            $table->uuid('address_id')->index();
            $table->foreign('address_id')
                ->on('addresses')
                ->references('id')
                ->cascadeOnDelete();
            $table->primary(['address_id', 'contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_user');
    }
};
