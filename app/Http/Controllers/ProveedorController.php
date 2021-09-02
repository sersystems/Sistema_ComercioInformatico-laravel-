<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('proveedor');
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (Proveedor::select('')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->estado($request->get('estado'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Proveedor::selectRaw('proveedor.*')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->estado($request->get('estado'))
                ->orderBy('proveedor.denominacion', 'ASC')
                ->offset($limite * ($request->get('pagina') - 1))
                ->limit($limite)
                ->get();
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas(null));
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
           
        $obj = new Proveedor();
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->cuit = $request->cuit;
        $obj->iva = strtoupper($request->iva);
        $obj->domicilio = strtoupper($request->domicilio);
        $obj->provincia = strtoupper($request->provincia);
        $obj->distrito = strtoupper($request->distrito);
        $obj->cp = $request->cp;
        $obj->telefono = $request->telefono;
        $obj->celular1 = $request->celular1;
        $obj->celular2 = $request->celular2;
        $obj->email = strtolower($request->email);
        $obj->saldo = $request->saldo;
        $obj->estado = strtoupper($request->estado);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se creó correctamente.']);
    }

    public function show($id)
    {
        $data = Proveedor::selectRaw('proveedor.*')
            ->id($id)
            ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas($request->id));
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
           
        $obj = Proveedor::findOrFail($request->id);
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->cuit = $request->cuit;
        $obj->iva = strtoupper($request->iva);
        $obj->domicilio = strtoupper($request->domicilio);
        $obj->provincia = strtoupper($request->provincia);
        $obj->distrito = strtoupper($request->distrito);
        $obj->cp = $request->cp;
        $obj->telefono = $request->telefono;
        $obj->celular1 = $request->celular1;
        $obj->celular2 = $request->celular2;
        $obj->email = strtolower($request->email);
        $obj->saldo = $request->saldo;
        $obj->estado = strtoupper($request->estado);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se editó correctamente.']);
    }

    public function destroy($id)
    {
        $obj = Proveedor::findOrFail($id);
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }

    function validarReglas($id){
        return [
            'denominacion' => (($id != null) ? 'required|max:30|unique:rubro,denominacion,'.$id : 'required|max:35|unique:rubro'),
            'cuit' => 'required|max:11',
            'iva' => 'required',
            'domicilio' => 'required|max:50',
            'provincia' => 'required|max:20',
            'distrito' => 'required|max:20',
            'cp' => 'max:5',
            'telefono' => 'max:13',
            'celular1' => 'max:13',
            'celular2' => 'max:13',
            'email' => 'max:50',
            'saldo' => 'required|max:10'
        ];
    }
}