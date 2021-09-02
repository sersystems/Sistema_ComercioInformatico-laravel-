<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Rubro;
use Illuminate\Http\Request;
use Illuminate\Http\Ima;
use Illuminate\Support\Facades\Auth;

class CatalogoArticuloController extends Controller
{
    public function index()
    {
        return view('catalogoArticulo');
    }
    
    public function list(Request $request)
    {
        $limite = 20;
        if($request->get('count')){
            $count = (Articulo::select('')
                ->join('rubro', 'articulo.rubro_id', '=', 'rubro.id')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->denominacionRubro($request->get('denominacion_rubro'))
                ->stock($request->get('stock'))
                ->estado($request->get('estado'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Articulo::selectRaw('articulo.*, rubro.denominacion AS rubro_denominacion')
                ->join('rubro', 'articulo.rubro_id', '=', 'rubro.id')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->denominacionRubro($request->get('denominacion_rubro'))
                ->stock($request->get('stock'))
                ->estado($request->get('estado'))
                ->orderBy('articulo.tipo', 'ASC')
                ->orderBy('articulo.marca', 'ASC')
                ->orderBy('articulo.modelo', 'ASC')
                ->offset($limite * ($request->get('pagina') - 1))
                ->limit($limite)
                ->get();
            $sesion = (Auth::check()) ? auth()->user()->sesion : 'INVITADO';
            return response()->json(['data' => $data, 'sesion' => $sesion]);
        }
    }

    public function show($id)
    {
        $data = Articulo::selectRaw('articulo.*, rubro.denominacion AS rubro_denominacion')
                ->join('rubro', 'articulo.rubro_id', '=', 'rubro.id')
                ->id($id)
                ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        $sesion = (Auth::check()) ? auth()->user()->sesion : 'INVITADO';
        return response()->json(['data' => $data, 'sesion' => $sesion]);
    }
}