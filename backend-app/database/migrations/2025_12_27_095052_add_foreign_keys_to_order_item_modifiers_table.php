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
        Schema::table('order_item_modifiers', function (Blueprint $table) {
            $table->foreign(['order_item_id'], 'order_item_modifiers_ibfk_1')->references(['id'])->on('order_items')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['modifier_id'], 'order_item_modifiers_ibfk_2')->references(['id'])->on('modifiers')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_item_modifiers', function (Blueprint $table) {
            $table->dropForeign('order_item_modifiers_ibfk_1');
            $table->dropForeign('order_item_modifiers_ibfk_2');
        });
    }
};
