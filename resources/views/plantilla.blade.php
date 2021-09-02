<!DOCTYPE html>
<html lang="es-AR">
<head>
  <title>SerSystems - San Juan</title>
  <meta charset="UTF-8"/>
  <meta name="description" content="Venta de productos de computación e insumos informático. Ofrecemos una atención personalizada con asesoramiento especializado. Disponemos de un servicio técnico propio que brinda soluciones eficientes."/>
  <meta name="keywords" content="accesorio,computacion,insumo,informatica,servicio,soporte,tecnico,asesoramiento,computadora,notebook,netbook,tablet,consola,ps2,sersystems,www.sersystems.tech"/>
  <meta name="author" content="Sergio Regalado Alessi"/>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index,follow"/>
  
  <link rel="alternate" hreflang="es-AR" href="http://sersystems.tech/"/>
  <link rel="canonical" href="http://sersystems.tech<?php echo $_SERVER['PHP_SELF']?>"/>
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <link href="https://fonts.googleapis.com/css?family=Acme|Lobster&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
 
  <div class="row">
    <img src="img/encabezado_xs.jpg" alt="" class="col-12 d-block d-sm-none">
    <img src="img/encabezado_sm.jpg" alt="" class="col-12 d-none d-sm-block d-md-none">
    <img src="img/encabezado_lg.jpg" alt="" class="col-12 d-none d-md-block d-lg-block d-xl-none">
    <img src="img/encabezado_xl.jpg" alt="" class="col-12 d-none d-xl-block">
  </div>

  <div class="bg-info text-center"><span class="font-italic text-white" id="idEstadoProceso"></span></div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
          <li class="nav-item {{ Route::is('inicio.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('inicio.index') }}">Inicio</a></li>
          <li class="nav-item {{ Route::is('catalogo_articulos.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('catalogo_articulos.index') }}">Catálogo</a></li>
          <li class="nav-item {{ Route::is('nosotros.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('nosotros.index') }}">Nosotros</a></li>
          <li class="nav-item {{ Route::is('contacto.index') ? 'active' : '' }}"><a class="nav-link" href="{{ route('contacto.index') }}">Contacto</a></li>
          @if(!Auth::guest() && Auth::user()->sesion == 'ADMIN')
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle {{ Route::is('articulos.index') || Route::is('clientes.index') || Route::is('proveedores.index') || Route::is('rubros.index') || Route::is('ventas.index') ? 'active' : '' }}" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administración</a>
              <div class="dropdown-menu" style="background-color: #f8f9fa; border-width:0;">
                <a class="nav-link" style="{{ Route::is('articulos.index') ? 'color: black' : 'color: gray' }}" href="{{ route('articulos.index') }}">Artículos</a>
                <a class="nav-link" style="{{ Route::is('clientes.index') ? 'color: black' : 'color: gray' }}" href="{{ route('clientes.index') }}">Clientes</a>
                <a class="nav-link" style="{{ Route::is('proveedores.index') ? 'color: black' : 'color: gray' }}" href="{{ route('proveedores.index') }}">Proveedores</a>
                <a class="nav-link" style="{{ Route::is('rubros.index') ? 'color: black' : 'color: gray' }}" href="{{ route('rubros.index') }}">Rubros</a>
                <a class="nav-link" style="{{ Route::is('usuarios.index') ? 'color: black' : 'color: gray' }}" href="{{ route('usuarios.index') }}">Usuarios</a>
                <div class="dropdown-divider"></div>
                <a class="nav-link" style="{{ Route::is('ventas.index') ? 'color: black' : 'color: gray' }}" href="{{ route('ventas.index') }}">Ventas</a>
                <div class="dropdown-divider"></div>
                <a class="nav-link" style="{{ Route::is('mensajes.index') ? 'color: black' : 'color: gray' }}" href="{{ route('mensajes.index') }}">Mensajes</a>
              </div>
          </li>
          @endif
        </ul>
    </div>
    @if(!Auth::guest()) <a class="nav-link text-secondary font-italic" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>{{ ucwords(strtolower(auth()->user()->denominacion)) }}</a> @endif
  </nav>

  <h1 class="tituloPagina text-center mt-1">@yield('title')</h1>
  <div class="container">@yield('content')</div>

  <!-- Modal: Msj de Confirmación -->
  @extends('plantillaMsjConfirm') 
   
  <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script> $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } }); </script>
  <script src="{{ asset('js/paginacion.js') }}" defer></script> 
  @yield('script')
  
  <style>
    .tituloPagina {
      font-weight: bolder;
      font-size: 4vw;
      text-shadow: 1px 1px 15px white;
    }
  </style>

</body>
</html>