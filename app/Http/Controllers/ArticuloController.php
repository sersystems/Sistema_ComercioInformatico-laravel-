<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Rubro;
use Illuminate\Http\Request;
use Illuminate\Http\Ima;

class ArticuloController extends Controller
{
    public function index()
    {
        return view('articulo');
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
                ->estado($request->get('estado'))
                ->count()) / $limite;
            return response()->json(ceil($count));
        }else {
            $data = Articulo::selectRaw('articulo.*, rubro.denominacion AS rubro_denominacion')
                ->join('rubro', 'articulo.rubro_id', '=', 'rubro.id')
                ->id($request->get('id'))
                ->denominacion($request->get('denominacion'))
                ->denominacionRubro($request->get('denominacion_rubro'))
                ->estado($request->get('estado'))
                ->orderBy('articulo.tipo', 'ASC')
                ->orderBy('articulo.marca', 'ASC')
                ->orderBy('articulo.modelo', 'ASC')
                ->offset($limite * ($request->get('pagina') - 1))
                ->limit($limite)
                ->get();
            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json( ['procesado' => false, 'message' => $validacion->errors()->all()] );

        $obj = new Articulo();
        $obj->tipo = strtoupper($request->tipo);
        $obj->marca = strtoupper($request->marca);
        $obj->modelo = strtoupper($request->modelo);
        $obj->descripcion = $request->descripcion;
        $obj->rubro_id = strtoupper($request->rubro_id);
        $obj->codigo_barras = $request->codigo_barras;
        $obj->garantia = $request->garantia;
        $obj->unidad = strtoupper($request->unidad);
        $obj->stock = $request->stock;
        $obj->stock_minimo = $request->stock_minimo;
        $obj->stock_maximo = $request->stock_maximo;
        $obj->usd_costo_bruto = $request->usd_costo_bruto;
        $obj->iva_alicuota = $request->iva_alicuota;
        $obj->usd_iva_base = $request->usd_iva_base;
        $obj->usd_costo_neto = $request->usd_costo_neto;
        $obj->utilidad = $request->utilidad;
        $obj->usd_margen = $request->usd_margen;
        $obj->usd_precio = $request->usd_precio;
        $obj->estado = strtoupper($request->estado);      
        $obj->save();
        return response()->json(['id' => $obj->id, 'procesado' => true, 'message' => 'El registro #'.$obj->id.' se creó correctamente.']);
    }

    public function show($id)
    {
        $data = Articulo::selectRaw('articulo.*, rubro.denominacion AS rubro_denominacion')
                ->join('rubro', 'articulo.rubro_id', '=', 'rubro.id')
                ->id($id)
                ->get();
        $data = (count($data) > 0) ? $data[0]: array();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validacion = \Validator::make($request->all(), $this->validarReglas());
        if ($validacion->fails()) return response()->json(['procesado' => false, 'message' => $validacion->errors()->all()]);
       
        $obj = Articulo::findOrFail($request->id);
        $obj->tipo = strtoupper($request->tipo);
        $obj->marca = strtoupper($request->marca);
        $obj->modelo = strtoupper($request->modelo);
        $obj->descripcion = $request->descripcion;
        $obj->rubro_id = strtoupper($request->rubro_id);
        $obj->codigo_barras = $request->codigo_barras;
        $obj->garantia = $request->garantia;
        $obj->unidad = strtoupper($request->unidad);
        $obj->stock = $request->stock;
        $obj->stock_minimo = $request->stock_minimo;
        $obj->stock_maximo = $request->stock_maximo;
        $obj->usd_costo_bruto = $request->usd_costo_bruto;
        $obj->iva_alicuota = $request->iva_alicuota;
        $obj->usd_iva_base = $request->usd_iva_base;
        $obj->usd_costo_neto = $request->usd_costo_neto;
        $obj->utilidad = $request->utilidad;
        $obj->usd_margen = $request->usd_margen;
        $obj->usd_precio = $request->usd_precio;
        $obj->estado = strtoupper($request->estado);      
        $obj->save();
        return response()->json(['id' => $obj->id, 'procesado' => true, 'message' => 'El registro #'.$obj->id.' se editó correctamente.']);
    }

    public function upload(Request $request)
    {
        if ($request->id && $request->hasFile('imagen')) {
            // ========= Validación de Imagen ======== //
            if ($request->file('imagen')->getSize() > 4194304) return response()->json(['message'=> 'Error: La imagen No debe superar los 4MB.']);
            if (!in_array($request->file('imagen')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['message'=> 'Error: La imagen debe ser JPG, JPGE o PNG.']);
            // ======== Preparación de Imagen ======== //
            $archivo_img = $request->file('imagen'); //Paso 1: Almacena la imagen en una variable PHP 
            $destino_img = public_path('img/articulos/'); //Paso 2: Define la ruta de destino
            $nombre_nueva_img = 'art'.$request->id.'_'.time().'.'.$archivo_img->getClientOriginalExtension(); //Paso 3: Determina el nombre y extensión de la imagen
            $obj = Articulo::findOrFail($request->id); //Paso 4: Busca en la Base de Datos el registro correspondiente al ID 
            if (file_exists($destino_img.$obj->imagen_nombre)) if ($obj->imagen_nombre != 'art_default.jpg') unlink($destino_img.$obj->imagen_nombre);  //Paso 5: Elimina una imagen anteriormente subida
            $archivo_img->move($destino_img, 'tmp_'.$nombre_nueva_img); //Paso 6: Mueve la imagen al destino
            // ========= Edición Fotográfica ========= //
            $lienzo_img = imagecreatetruecolor(1088, 816);
            $upload_img = imagecreatefromjpeg($destino_img.'tmp_'.$nombre_nueva_img);
            imagecopyresampled($lienzo_img, $upload_img, 0, 0, 0, 0, 1088, 816, imagesx($upload_img), imagesy($upload_img));
            $logo_img = imagecreatefrompng($destino_img.'logo_para_foto.png');
            imagecopyresampled($lienzo_img, $logo_img, 234, 348, 0, 0, 620, 120, imagesx($logo_img), imagesy($logo_img));
            imagejpeg($lienzo_img, $destino_img.$nombre_nueva_img, 100);
            imagedestroy($lienzo_img);
            unlink($destino_img.'tmp_'.$nombre_nueva_img);
            // ========= Registro del Nombre ========= //
            $obj->imagen_nombre = $nombre_nueva_img;
            $obj->save();
            return response()->json(); //Importante: Respuesta de confirmación
        }
    }

    public function destroy($id)
    {
        $obj = Articulo::findOrFail($id);
        $destino_img = public_path('img/articulos/').$obj->imagen_nombre;
        if (file_exists($destino_img)) if ($obj->imagen_nombre != 'art_default.jpg') unlink($destino_img); //Elimina la correspondiente imagen
        $obj->delete();
        return response()->json(array('message' => 'El registro #'.$id.' se eliminó correctamente.'));
    }
    
    function validarReglas(){
        return [
            'tipo' => 'required|max:30',
            'marca' => 'required|max:13',
            'modelo' => 'max:13',
            'descripcion' => 'max:255',
            'garantia' => 'required',
            'stock' => 'required|max:5',
            'stock_minimo' => 'required|max:5',
            'stock_maximo' => 'required|max:5',
            'usd_costo_bruto' => 'required|max:10',
            'iva_alicuota' => 'required',
            'usd_iva_base' => 'required|max:10',
            'usd_costo_neto' => 'required|max:10',
            'utilidad' => 'required|max:7',
            'usd_margen' => 'required|max:10',
            'usd_precio' => 'required|max:10'
        ];
    }
}