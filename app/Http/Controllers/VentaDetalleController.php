<?php

namespace App\Http\Controllers;

use App\Models\VentaDetalle;
use Illuminate\Http\Request;

class VentaDetalleController extends Controller
{
    public function index(Request $request)
    {
        $data = VentaDetalle::selectRaw('venta_detalle.*')
            ->idVenta($request->get('id_venta'))
            ->orderBy('venta_detalle.venta_id', 'ASC')
            ->orderBy('venta_detalle.denominacion', 'ASC')
            ->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json(['message_detalle'=>$validacion->errors()->all()]);

        $obj = new VentaDetalle();
        $obj->venta_id = $request->venta_id;
        $obj->articulo_id = $request->articulo_id;
        $obj->denominacion = $request->denominacion;
        $obj->garantia = $request->garantia;
        $obj->cantidad = $request->cantidad;
        $obj->ar_precio = $request->ar_precio;
        $obj->iva_alicuota = $request->iva_alicuota;
        $obj->ar_base = $request->ar_base;
        $obj->ar_importe = $request->ar_importe;
        $obj->ar_costo = $request->ar_costo;
        $obj->save();
        return response()->json(array('message_detalle' => 'El detalle #'.$obj->id.' se creó correctamente.'));
    }

    public function show($id)
    {
        $obj = VentaDetalle::findOrFail($id);
        return response()->json($obj);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json(['message_detalle'=>$validacion->errors()->all()]);

        $obj = VentaDetalle::findOrFail($request->id);
        $obj->venta_id = $request->venta_id;
        $obj->articulo_id = $request->articulo_id;
        $obj->denominacion = $request->denominacion;
        $obj->garantia = $request->garantia;
        $obj->cantidad = $request->cantidad;
        $obj->ar_precio = $request->ar_precio;
        $obj->iva_alicuota = $request->iva_alicuota;
        $obj->ar_base = $request->ar_base;
        $obj->ar_importe = $request->ar_importe;
        $obj->ar_costo = $request->ar_costo;  
        $obj->save();
        return response()->json(array('message_detalle' => 'El detalle #'.$obj->id.' se editó correctamente.'));
    }

    public function destroy($id)
    {
        $obj = VentaDetalle::findOrFail($id);
        $obj->delete();
        return response()->json(array('message_detalle' => 'El detalle #'.$id.' se eliminó correctamente.'));
    }
    
    function validarReglas(){
        return [
            'venta_id' => 'required',
            'articulo_id' => 'required',
            'denominacion' => 'required|max:53',
            'garantia' => 'required',
            'cantidad' => 'required|max:5',
            'ar_precio' => 'required|max:10',
            'iva_alicuota' => 'required',
            'ar_base' => 'required|max:10',
            'ar_importe' => 'required|max:10',
            'ar_costo' => 'required|max:10'
        ];
    }
}