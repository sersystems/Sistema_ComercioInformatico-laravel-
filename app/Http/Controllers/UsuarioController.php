<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuario');
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (User::select('')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = User::selectRaw('users.*')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->orderBy('users.denominacion', 'ASC')
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
           
        $obj = new User();
        $obj->sesion = $request->sesion;
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->email = strtolower($request->email);
        $obj->password = bcrypt($request->password);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se creó correctamente.']);
    }

    public function show($id)
    {
        $data = User::selectRaw('users.*')
            ->id($id)
            ->get();
        $data = (count($data) > 0) ? $data[0] : array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas($request->id));
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
        
        $obj = User::findOrFail($request->id);
        $obj->sesion = $request->sesion;
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->email = strtolower($request->email);
        if($request->password != '_secreto') $obj->password = bcrypt($request->password);
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se editó correctamente.']);
    }

    public function destroy($id)
    {
        $obj = User::findOrFail($id);
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }

    function validarReglas($id){
        return [
            'sesion' => 'required',
            'denominacion' => 'required|max:36',
            'email' => (($id != null) ? 'required|email|max:50|unique:users,email,'.$id : 'required|max:50|unique:users'),
            'password' => 'required|min:8|max:12'
        ];
    }
}