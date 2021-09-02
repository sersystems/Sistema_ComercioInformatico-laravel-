<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CotizacionDolarController extends Controller
{
    public function index()
    {
        $cotizacion_minima = '57.00';
        $cotizacion_actual = '0.00';
        $cotizacion_agregada = '1.00';
        try {
            $respuesta = json_decode(file_get_contents('http://ws.geeklab.com.ar/dolar/get-dolar-json.php'), true); 
            $cotizacion_actual = $respuesta['libre'];
        } finally{
            $dolar = ($cotizacion_actual > $cotizacion_minima) ? number_format($cotizacion_actual + $cotizacion_agregada, 2, '.', ',') : number_format($cotizacion_minima + $cotizacion_agregada, 2, '.', ',');
            return response()->json($dolar);
        }
    }
}