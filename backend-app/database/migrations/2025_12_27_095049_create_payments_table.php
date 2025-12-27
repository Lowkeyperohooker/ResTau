<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->index('order_id');
            $table->string('payment_method', 50);
            $table->decimal('amount_paid', 10);
            $table->string('reference_code', 100)->nullable();
            $table->timestamp('payment_time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
