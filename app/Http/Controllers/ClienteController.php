<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{  
    public function index()
    {
        return view('cliente');
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (Cliente::select('')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->estado($request->get('estado'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Cliente::selectRaw('cliente.*')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->estado($request->get('estado'))
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
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
           
        $obj = new Cliente();
        $obj->apellido = strtoupper($request->apellido);
        $obj->nombre = strtoupper($request->nombre);
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
        $obj->lista_precio = $request->lista_precio;
        $obj->saldo = $request->saldo;
        $obj->estado = strtoupper($request->estado);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se creó correctamente.']);
    }

    public function show($id)
    {
        $data = Cliente::selectRaw('cliente.*')
            ->id($id)
            ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
           
        $obj = Cliente::findOrFail($request->id);
        $obj->apellido = strtoupper($request->apellido);
        $obj->nombre = strtoupper($request->nombre);
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
        $obj->lista_precio = $request->lista_precio;
        $obj->saldo = $request->saldo;
        $obj->estado = strtoupper($request->estado);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se editó correctamente.']);
    }

    public function destroy($id)
    {
        $obj = Cliente::findOrFail($id);
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }

    function validarReglas(){
        return [
            'apellido' => 'required|max:15',
            'nombre' => 'required|max:20',
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
            'lista_precio' => 'required',
            'saldo' => 'required|max:10'
        ];
    }
}