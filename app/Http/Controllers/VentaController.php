<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        return view('venta');
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (Venta::select('')
                ->join('cliente', 'venta.cliente_id', '=', 'cliente.id')
                ->id($request->get('id'))
                ->cuitCliente($request->get('cuit_cliente'))
                ->denominacionCliente($request->get('denominacion_cliente'))
                ->estado($request->get('estado'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Venta::selectRaw('venta.*, cliente.id, CONCAT(cliente.apellido, " ", cliente.nombre) AS cliente_denominacion, cliente.cuit AS cliente_cuit, cliente.iva AS cliente_iva, cliente.saldo AS cliente_saldo, cliente.list_precio AS cliente_list_precio')
                ->join('cliente', 'venta.cliente_id', '=', 'cliente.id')
                ->id($request->get('id'))
                ->cuitCliente($request->get('cuit_cliente'))
                ->denominacionCliente($request->get('denominacion_cliente'))
                ->estado($request->get('estado'))
                ->orderBy('venta.cbte_fecha', 'DESC')
                ->orderBy('cliente.apellido', 'ASC')
                ->orderBy('cliente.nombre', 'ASC')
                ->offset($limite * ($request->get('pagina') - 1))
                ->limit($limite)
                ->get();
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json(['message'=>$validacion->errors()->all()]);

        $obj = new Venta();
        $obj->estado = strtoupper($request->estado);
        $obj->cbte_tipo = strtoupper($request->cbte_tipo);
        $obj->cbte_tpv = $request->cbte_tpv;
        $obj->cbte_nro = $request->cbte_nro;
        $obj->cbte_fecha = $request->cbte_fecha;
        $obj->cliente_id = $request->cliente_id;
        $obj->ar_subtotal = $request->ar_subtotal;
        $obj->ar_descuento_taza = $request->ar_descuento_taza;
        $obj->ar_descuento_monto = $request->ar_descuento_monto;
        $obj->ar_iva105 = $request->ar_iva105;
        $obj->ar_iva210 = $request->ar_iva210;
        $obj->ar_iva270 = $request->ar_iva270;
        $obj->ar_total = $request->ar_total;
        $obj->ar_costo = $request->ar_costo;
        $obj->ar_margen = $request->ar_margen;
        $obj->save();
        return response()->json(array('message' => 'El registro #'.$obj->id.' se creó correctamente.'));
    }

    public function show($id)
    {
        $data = Venta::selectRaw('venta.*, cliente.id, CONCAT(cliente.apellido, " ", cliente.nombre) AS cliente_denominacion, cliente.cuit AS cliente_cuit, cliente.iva AS cliente_iva, cliente.saldo AS cliente_saldo, cliente.list_precio AS cliente_list_precio')
            ->join('cliente', 'venta.cliente_id', '=', 'cliente.id')
            ->id($id)
            ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json(['message'=>$validacion->errors()->all()]);

        $obj = Venta::findOrFail($request->id);
        $obj->estado = strtoupper($request->estado);
        $obj->cbte_tipo = strtoupper($request->cbte_tipo);
        $obj->cbte_tpv = $request->cbte_tpv;
        $obj->cbte_nro = $request->cbte_nro;
        $obj->cbte_fecha = $request->cbte_fecha;
        $obj->cliente_id = $request->cliente_id;
        $obj->ar_subtotal = $request->ar_subtotal;
        $obj->ar_descuento_taza = $request->ar_descuento_taza;
        $obj->ar_descuento_monto = $request->ar_descuento_monto;
        $obj->ar_iva105 = $request->ar_iva105;
        $obj->ar_iva210 = $request->ar_iva210;
        $obj->ar_iva270 = $request->ar_iva270;
        $obj->ar_total = $request->ar_total;
        $obj->ar_costo = $request->ar_costo;
        $obj->ar_margen = $request->ar_margen;
        $obj->save();
        return response()->json(array('message' => 'El registro #'.$obj->id.' se editó correctamente.'));
    }

    public function destroy($id)
    {
        $obj = Venta::findOrFail($id);
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }
    
    function validarReglas(){
        return [
            'cbte_tipo' => 'required|max:5',
            'cbte_tpv' => 'required|max:5',
            'cbte_fecha' => 'required|date',
            'cliente_id' => 'required',
            'ar_subtotal' => 'required|max:10',
            'ar_descuento_taza' => 'required|max:7',
            'ar_descuento_monto' => 'required|max:10',
            'ar_iva105' => 'required|max:10',
            'ar_iva210' => 'required|max:10',
            'ar_iva270' => 'required|max:10',
            'ar_total' => 'required|max:10',
            'ar_costo' => 'required|max:10',
            'ar_margen' => 'required|max:10'
        ];
    }
}