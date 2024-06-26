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
        DB::table('clientes')->insert([
            'Nombre'=>'Jorge Cotrado',
            'Direccion' => 'Calle Arica 100',
            'Telefono' => '999759800',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clientes')->insert([
            'Nombre'=>'Juan Mendez',
            'Direccion' => 'Calle Melgar 130',
            'Telefono' => '934759801',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clientes')->insert([
            'Nombre'=>'Dina Boluarte',
            'Direccion' => 'Av Union 130',
            'Telefono' => '914759801',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
