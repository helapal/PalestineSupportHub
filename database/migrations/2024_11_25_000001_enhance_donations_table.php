<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            // Convert recurring to enum for weekly scheduling
            $table->string('recurring_frequency')->default('none'); // none, weekly
            $table->timestamp('next_payment_date')->nullable();
            $table->timestamp('last_payment_date')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'recurring_frequency',
                'next_payment_date',
                'last_payment_date',
                'is_active'
            ]);
        });
    }
};
