@extends('plantilla')
@section('content')
	
	<div class="row pt-1">
		<div class="col-12">
			<div class="container" style="background-color: #9FC94D; border-radius: 15px 15px 0px 0px;">
				<h4 class="text-center text-white p-1">Nosotros</h4>
			</div>
		</div>	
		<div class="col-12">
			<div>
				<img src="img/nosotros.jpg" alt="SerSystems" class="img-fluid float-left imagen">
				<p class="text-justify mb-4"><b>POR QUÉ ELEGIRNOS:</b><br> Porque nos avala una trayectoria de 10 años en el mercado de San Juan. Siempre damos soluciones rápidas y eficientes a nuestros clientes. Somos un equipo especializado en lo que hacemos y ofrecemos precios altamente competitivos.</p>
				<p class="text-justify mb-4"><b>POLÍTICA DE LA EMPRESA:</b><br> Nuestra Política de trabajo es asegurar el abastecimiento de las necesidades de nuestros clientes proveyéndoles productos adecuados. Comprometiéndonos a una mejora continua de nuestro sistema de control de calidad promoviendo las acciones necesarias dentro de nuestra organización para lograr los objetivos. Nuestra responsabilidad es destacar la especialización en los productos que comercializamos.</p>
				<p class="text-justify mb-2"><b>MISIÓN DE LA EMPRESA:</b><br> Nuestra Misión es asesorar al cliente brindándole los conocimientos técnicos necesarios para que pueda elegir libremente aquel producto que satisfaga sus necesidades.</p>
			</div>
		</div>
		<div class="col-12">
			<div class="container" style="background-color: #9FC94D; border-radius: 0px 0px 15px 15px;">
				<div class="text-center"><a href="#" class="text-white">Desarrollado por Sergio Regalado Alessi</a></div>
				<div class="text-center"><small>&#169;2019 Todos los Derechos Reservados</small></div>
			</div>
		</div>
	</div>

	<style>
		@media (max-width: 576px) {
			.imagen {
				width: 45%;
				margin-top: 0.4rem; 
				margin-right: 1rem;
				border-radius: 5px;
			}
		}
		@media (min-width: 577px) {
			.imagen {
				width: 40%;
				margin-top: 0.4rem; 
				margin-right: 1rem;
				border-radius: 5px;
			}
		 }
	</style>

@endsection

@section('script')
<script>
</script>
@endsection