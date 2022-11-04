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
        Schema::create('contact_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('contact_id')->index();
            $table->foreign('contact_id')
                ->on('contacts')
                ->references('id')
                ->cascadeOnDelete();
            $table->uuid('sales_id')->index();
            $table->foreign('sales_id')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete();
            $table->date('date_contacted');
            $table->text('description');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('contact_transactions');
    }
};
