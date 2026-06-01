<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estoques', function (Blueprint $table) {
            if (!Schema::hasColumn('estoques', 'quantidade_minima')) {
                $table->integer('quantidade_minima')->nullable()->after('quantidade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('estoques', function (Blueprint $table) {
            if (Schema::hasColumn('estoques', 'quantidade_minima')) {
                $table->dropColumn('quantidade_minima');
            }
        });
    }
};
