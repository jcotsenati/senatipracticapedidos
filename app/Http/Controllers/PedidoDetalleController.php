<?php

namespace App\Http\Controllers;

use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Models\Pedido;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\UniqueConstraintViolationException;

class PedidoDetalleController extends Controller
{
    public function index(Request $request,$pedidoID)
    {
        $pedidosDetalles = PedidoDetalle::where("PedidoID",$pedidoID)->get();
        $pedido = Pedido::findOrFail($pedidoID);
        //dd($pedidosDetalles->toJson());
        return view('pedidosdetalles.index', compact('pedidosDetalles','pedido'));
    }
    public function create(Request $request,$pedidoID)
    {
        $productos=Producto::all();
        return view('pedidosdetalles.create',compact('productos','pedidoID'));
    }
    public function store(Request $request,$pedidoID,$productoID)
    {
        
        DB::beginTransaction();

        try{

            $cantidad=1;
            $producto = Producto::findOrFail($productoID);
            $pedido = Pedido::findOrFail($pedidoID);
            $pedido->Total=$pedido->Total+($producto->Precio*$cantidad);
            $pedido->save();

            PedidoDetalle::create([
                'PedidoID'=>$pedidoID,
                'ProductoID'=>$productoID,
                'Cantidad'=>$cantidad,
                'PrecioUnitario'=>$producto->Precio,
            ]);

            DB::commit();
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_success', 'Operacion Satisfactoria !!!');

        }catch(UniqueConstraintViolationException $e){
            DB::rollback();
            
            $msj = strpos($e->getMessage(), "detalles_pedido_pedidoid_productoid_unique");
            if ($msj !== false) {
                
                return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_error',"El Producto ".$producto->Nombre." ya fue ingresado...");
            }
            
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_error','No se puede agregar el Producto. Intente Nuevamente');
        
        }catch(\Exception $e){

            DB::rollback();
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_error','No se puede agregar el Producto. Intente Nuevamente');
        }
    }

    public function edit(Request $request,$pedidoID,$detalleID)
    {
        $pedidoDetalle = PedidoDetalle::findOrFail($detalleID);
        return view('pedidosdetalles.edit', compact('pedidoDetalle','pedidoID'));
    }

    public function update(Request $request,$pedidoID,$detalleID)
    {
        DB::beginTransaction();

        try{
            $cantidad= $request->cantidad;
            $precio_unitario=$request->precio_unitario;
            
            $pedidoDetalle = PedidoDetalle::findOrFail($detalleID);
            $totalAnterior=$pedidoDetalle->Cantidad*$pedidoDetalle->PrecioUnitario;

            $pedidoDetalle->update([
                'Cantidad' => $cantidad,
                'PrecioUnitario' => $precio_unitario,
            ]);

            $pedido = Pedido::findOrFail($pedidoID);
            $pedido->Total-=$totalAnterior;
            $pedido->Total+=$cantidad*$precio_unitario;

            $pedido->save();

            DB::commit();
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_success', 'Operacion Satisfactoria !!!');
        
        }catch(\Exception $e){
            
            DB::rollback();
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_error','No se puede actualizar el Producto. Intente Nuevamente');
        }

    }
    public function destroy($detalleID){

        DB::beginTransaction();

        try{

            $pedidoDetalle = PedidoDetalle::findOrFail($detalleID);
            $totalAnterior=$pedidoDetalle->Cantidad*$pedidoDetalle->PrecioUnitario;
            $pedidoID=$pedidoDetalle->PedidoID;
            $pedidoDetalle->delete();

            $pedido = Pedido::findOrFail($pedidoID);
            $pedido->Total-=$totalAnterior;
            $pedido->save();

            DB::commit();
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_success', 'Eliminacion satisfactoria !!!');

        }catch(\Exception $e){

            DB::rollback();
            return redirect()->route('pedidosdetalles.index',[$pedidoID])->with('msn_error','No se puede eliminar el Registro !!!');
        }
    }
}
