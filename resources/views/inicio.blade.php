@extends('plantilla')
@section('content')

	<div class="row pt-1">
		<div class="col-12" id="idAcceso">
			<div class="container" style="background-color: #9FC94D; border-radius: 15px 15px 0px 0px;">
				<div class="row py-3">
					<div class="col-12 col-md-7 col-lg-8">
						<h3 class="text-center tituloAcceso">ACESSO AL SISTEMA</h3>
						@if(Auth::guest()) <h5 class="text-center" style="font-size: 1rem; font-family: 'Lobster', cursive; color: #343A40;">Catálogo diferenciado para clientes registrados como revendedores informáticos, técnicos informáticos o técnicos electrónicos</h5> @endif
						@if(!Auth::guest()) <h5 class="text-center" style="font-size: 1.3rem; font-family: 'Lobster', cursive; color: #343A40;">Bienvenido {{ ucwords(strtolower(auth()->user()->denominacion)) }}</h5> @endif
					</div>
					<div class="col-12 col-md-5 col-lg-4">
						<form action="{{ route('login') }}" method="POST">
							@csrf
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend2">E-mail</span></div>
								<input type="email" class="tabFocus form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" required autocomplete="email">
							</div>
							<div class="input-group input-group-sm mb-1">
								<div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend2">Contraseña</span></div>
								<input type="password" class="tabFocus form-control form-control-sm @error('password') is-invalid @enderror" id="password" name="password" required>
								<div class="input-group-append"><span class="input-group-text" id="inputGroupAppend2"><input type="checkbox" data-toggle="tooltip" data-placement="left" title="Recordarme" name="remember" id="remember" checked></span></div>
							</div>
							@if(Auth::guest()) <input type="submit" class="btn btn-dark btn-sm btn-block" value="Acceder"> @endif
							@if(!Auth::guest()) <a class="btn btn-dark btn-sm btn-block" href="{{ route('logout') }}">Salir</a> @endif
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12" id="idVenta">
			<div class="col-12" style="background-image: url('img/ventas.jpg'); background-size: cover;">
				<div class="card-body text-center">
					<br><h3 class="tituloBandera">TODO COMPUTACION</h3><br><br><br>
					<h4 class="subTituloBandera">Computadoras - Notebooks - Tablets</h4>
					<h4 class="subTituloBandera">Accesorios - Insumos - Repuestos</h4>
				</div>
			</div>
		</div>
		<div class="col-12" id="idServicioTecnico">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="img/service_pc.jpg" class="d-block w-100" alt="servicio1">
						<div class="carousel-caption">
							<h2 class="tituloCarrusel">SERVICIO TECNICO ESPECIALIZADO</h2>
						</div>
					</div>
					<div class="carousel-item">
						<img src="img/service_ps2.jpg" class="d-block w-100" alt="servicio2">
						<div class="carousel-caption">
							<h2 class="tituloCarrusel">REPARACIONES EN 24HS/72HS</h2>
						</div>
					</div>
					<div class="carousel-item">
						<img src="img/service_tablet.jpg" class="d-block w-100" alt="servicio3">
						<div class="carousel-caption">
							<h2 class="tituloCarrusel">CONSEGUIMOS TODOS LOS REPUESTOS</h2>
						</div>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Anterior</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Siguiente</span>
				</a>
			</div>
		</div>
		<div class="col-12" id="idCatalogo">
			<div class="col-12" style="background-image: url('img/catalogo.jpg'); background-size: cover;">
				<div class="card-body text-center">
					<a href="{{ route('catalogo_articulos.index') }}"><h5 class="subTituloBandera2">Nuestro catálogo cuenta con stock real<br>Precios actualizados</h5></a>
				</div>
			</div>
		</div>
		<div class="col-12" id="idMercadoPago">
			<a href="https://www.mercadopago.com.ar/promociones/?gclid=Cj0KCQjwuLPnBRDjARIsACDzGL3TX6f_Q0yH-1zNRWFyhHhO5FGMBuVmmKMYF5ypMsRQqaBde_chY8waAt6cEALw_wcB" target=»_blank»><img src="img/mercado_pago.jpg" class="img-fluid" alt="..."></a>
		</div>
		<div class="col-12" id="idPiePagina">
			<div class="container" style="background-color: #9FC94D; border-radius: 0px 0px 15px 15px;">
				<div class="text-center"><a href="#" class="text-white">Desarrollado por Sergio Regalado Alessi</a></div>
				<div class="text-center"><small>&#169;2019 Todos los Derechos Reservados</small></div>
			</div>
		</div>
	</div>

	<style>
		.tituloAcceso {
			color: #343A40;
			font-weight: bolder;
			text-shadow: 1px 1px 15px white;
		}
		.tituloBandera {
			color: yellow;
			font-size: 5.5vw;
			font-weight: bolder;
			text-shadow: 3px 3px 5px black;
		}
		.subTituloBandera {
			color: yellow;
			font-size: 3.5vw;
			font-weight: bolder;
			text-shadow: 3px 3px 5px black;
		}
		.subTituloBandera2 {
			color: red;
			margin-top: 5vw;
			font-size: 3vw;
			font-weight: bolder;
			text-shadow: 3px 5px 5px black;
		}
		.tituloCarrusel {
			color: white;
			font-size: 5vw;
			font-weight: bolder;
			text-shadow: 3px 3px 5px black;
		}
	</style>

@endsection