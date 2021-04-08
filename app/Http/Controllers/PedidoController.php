<?php

namespace App\Http\Controllers;

use App\Carta;
use App\Pedido;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Method from Pedido and Info User
     */
    public function enviar(Request $request) {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:118',
            'telefono' => 'required|string|max:28',
            'direccion' => 'required|string|max:190'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 404);
        }

        try {

            DB::beginTransaction();

            $pedido = Pedido::create([
                "tienda_id" => $request->tienda_id,
                "nombre" => $request->nombre,
                "telefono" => $request->telefono,
                "direccion" => $request->direccion
            ]);

            foreach($request->productos as $p) {
                Carta::create([
                    "pedido_id" => $pedido->id,
                    "cantidad" => (int) $p['xcantidad'],
                    "precio" => 0,
                    "producto_id" => (int) $p['xid'],
                ]);
            }
            DB::commit();

            $mensaje = "Pedido enviado con éxito....";
            return response()->json(compact('mensaje'),201);

        } catch (Exception $e) {
            DB::rollback();
            throw $e;

            $mensaje = "Ocurrio un error....";
            return response()->json(compact('mensaje'),400);
        }
    }
}
