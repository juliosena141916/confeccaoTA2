<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('item_pedidos', 'produto_id')) {
                $table->foreignId('produto_id')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        // Não faz nada no rollback
    }
};
