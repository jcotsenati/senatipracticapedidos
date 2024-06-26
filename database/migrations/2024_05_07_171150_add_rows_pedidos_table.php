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
        DB::table('pedidos')->insert([
            'ClienteID'=>1,
            'Total' => 0,
            'FechaPedido' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pedidos')->insert([
            'ClienteID'=>1,
            'Total' => 0,
            'FechaPedido' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pedidos')->insert([
            'ClienteID'=>2,
            'Total' => 0,
            'FechaPedido' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pedidos')->insert([
            'ClienteID'=>3,
            'Total' => 0,
            'FechaPedido' => now(),
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
