<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos'; // Nombre de la tabla en la base de datos
    protected $fillable = ['PedidoId','Total'];
    protected $primaryKey = 'PedidoID';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'ClienteID');
    }
}
