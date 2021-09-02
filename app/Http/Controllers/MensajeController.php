<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->getRequestUri() == '/mensajes') return view('mensaje');
        else return view('contacto');      
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (Mensaje::select('')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->estado($request->get('estado'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Mensaje::selectRaw('mensaje.*')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->estado($request->get('estado'))
                ->orderBy('mensaje.denominacion', 'ASC')
                ->offset($limite * ($request->get('pagina') - 1))
                ->limit($limite)
                ->get();
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas(null), $this->prescribirValidacion());
        if ($validacion->fails()) return response()->json( ['procesado' => false, 'message' => $validacion->errors()->all()] );
           
        $obj = new Mensaje();
        $obj->denominacion = strtoupper($request->denominacion);
        $obj->celular = $request->celular;
        $obj->email = strtolower($request->email);
        $obj->consulta = $request->consulta;
        $obj->respuesta = '';
        $obj->estado = 'S/RESPONDER';
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'Su consulta se ha enviado correctamente, responderemos a la brevedad. Gracias por contactarnos.']);
    }

    public function show($id)
    {
        $data = Mensaje::selectRaw('mensaje.*')
            ->id($id)
            ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas($request->id));
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
        
        $obj = Mensaje::findOrFail($request->id);
        $obj->celular = $request->celular;
        $obj->email = strtolower($request->email);
        $obj->respuesta = $request->respuesta;
        $obj->estado = 'RESPONDIDO';
        $obj->save();
        return response()->json(['procesado' => true, 'message' => 'El registro #'.$obj->id.' se respondió correctamente.']);
    }

    public function destroy($id)
    {
        $obj = Mensaje::findOrFail($id);
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }

    public function captcha() { 
        return Captcha_src();
    }

    function validarReglas($id){
        return [
            'denominacion' => 'required|max:35',
            'celular' => 'required|max:13',
            'email' => 'required|email|max:50',
            'consulta' => 'required|max:250',
            'captcha' => (($id != null) ? 'required' : 'required|captcha')
        ];
    }

    function prescribirValidacion(){
        return [
            'captcha.captcha' => 'Código captcha erroneo',
        ];
    }
}