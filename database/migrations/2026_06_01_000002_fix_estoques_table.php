<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estoques', function (Blueprint $table) {
            // Renomear colunas para snake_case
            $table->renameColumn('Nome', 'localizacao');
            $table->renameColumn('Quantidade', 'quantidade');
            $table->renameColumn('Valor', 'valor');
        });
    }

    public function down(): void
    {
        Schema::table('estoques', function (Blueprint $table) {
            $table->renameColumn('localizacao', 'Nome');
            $table->renameColumn('quantidade', 'Quantidade');
            $table->renameColumn('valor', 'Valor');
        });
    }
};
