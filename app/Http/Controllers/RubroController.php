<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{   
    public function index()
    {
        return view('rubro');
    }
    
    public function desplegable()
    {
        $data = Rubro::selectRaw('rubro.*')
            ->orderBy('rubro.denominacion', 'ASC')
            ->get();
        return response()->json($data);
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (Rubro::select('')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Rubro::selectRaw('rubro.*')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->orderBy('rubro.denominacion', 'ASC')
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
           
        $obj = new Rubro();
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se creó correctamente.']);
    }

    public function show($id)
    {
        $data = Rubro::selectRaw('rubro.*')
            ->id($id)
            ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas($request->id));
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
           
        $obj = Rubro::findOrFail($request->id);
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se editó correctamente.']);
    }

    public function destroy($id)
    {
        $obj = Rubro::findOrFail($id);
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }

    function validarReglas($id){
        return ['denominacion' => (($id != null) ? 'required|max:30|unique:rubro,denominacion,'.$id : 'required|max:30|unique:rubro') ];
    }
}

