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
        Schema::table('item_modifier_links', function (Blueprint $table) {
            $table->foreign(['menu_item_id'], 'item_modifier_links_ibfk_1')->references(['id'])->on('menu_items')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['modifier_group_id'], 'item_modifier_links_ibfk_2')->references(['id'])->on('modifier_groups')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_modifier_links', function (Blueprint $table) {
            $table->dropForeign('item_modifier_links_ibfk_1');
            $table->dropForeign('item_modifier_links_ibfk_2');
        });
    }
};
