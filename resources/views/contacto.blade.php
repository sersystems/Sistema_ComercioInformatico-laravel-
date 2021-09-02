@extends('plantilla')
@section('content')
	
	<div class="row pt-1">
		<div class="col-12">
			<div class="container" style="background-color: #9FC94D; border-radius: 15px 15px 0px 0px;">
				<h4 class="text-center text-white p-1">Contacto</h4>
			</div>
		</div>
		<div class="col-12 col-md-7 col-lg-6 mb-2">
			<div class="card">
				<div class="card-header">Formulario de Consulta</div>
				<div class="card-body">
					<form id="idFormulario">
						@csrf
						<div class="form-row">
							<div class="form-group col-12">
								<label for="idDenominacion"><small>Denominación *</small></label>
								<input type="text" class="tabFocus form-control form-control-sm" id="idDenominacion">
							</div>
							<div class="form-group col-12 col-md-3">
								<label for="idCelular"><small>Celular *</small></label>
								<input type="number" class="tabFocus form-control form-control-sm" id="idCelular">
							</div>	
							<div class="form-group col-12 col-md-9">
								<label for="idEmail"><small>E-mail *</small></label>
								<input type="email" class="tabFocus form-control form-control-sm" id="idEmail">
							</div>
							<div class="form-group col-12">
								<label for="idConsulta"><small>Consulta *</small></label>
								<textarea rows = "3" cols = "80" class="tabFocus form-control form-control-sm" id="idConsulta"></textarea>
							</div>
						</div>
						<div class="input-group">
							<input type="text" class="tabFocus form-control form-control-sm mr-1" id="idCaptchaTexto">
							<img class="img-fluid" style="border: gray 1px solid;" src="" alt="captcha" id="idCaptchaImagen">
							<a class="btn btn-primary btn-sm" data-dismiss="modal" onclick="guardar()">Enviar Consulta</a>
						</div>
						<small class="font-italic">(*) Campos obligatorios</small>
					</form>
					<p class="text-center"><b id="idEstadoRecepcion"></b></p>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-5 col-lg-6 mb-2">
			<p class="text-justify"><b>DOMICILIO:</b><br> Güemes 614 (o) - B° Capitán Lazo, Rawson, San juan, Argentina.</p>
			<p class="text-left"><b>TELEFONO:</b><br> <i class="fab fa-whatsapp"></i> 2645855750</p>
			<p class="text-left"><b>E-MAIL:</b><br> serdigital@live.com.ar</p>
			<p class="text-left"><b>HORARIOS DE ATENCION:</b><br> Lunes a viernes de 9hs a 12:30hs - 17hs a 20:30hs y sábados 9hs a 13hs.</p>
			<div class="card">
				<div class="text-center">
					<iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d714.646958416211!2d-68.5363938611936!3d-31.56662350816767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e2!4m0!4m5!1s0x96814005e14941a9%3A0x89de86d6744b1aef!2sCalle+Mart%C3%ADn+G%C3%BCemes+614%2C+Villa+Krause%2C+San+Juan!3m2!1d-31.566572999999998!2d-68.5359168!5e0!3m2!1ses-419!2sar!4v1559106893181!5m2!1ses-419!2sar" frameborder="0" style="border:0" allowfullscreen class="col-12"></iframe>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="container" style="background-color: #9FC94D; border-radius: 0px 0px 15px 15px;">
				<div class="text-center"><a href="#" class="text-white">Desarrollado por Sergio Regalado Alessi</a></div>
				<div class="text-center"><small>&#169;2019 Todos los Derechos Reservados</small></div>
			</div>
		</div>
	</div>

@endsection

@section('script')
<script src="{{ asset('js/models/mensaje.js') }}" defer></script>
<script>

	var objMensaje = null;
	function regenerarCaptcha(){
    	try {
			$.ajax({
				async: false,
				method: "GET",
				url: '/contacto_captcha',
				dataType: 'Text',
				success: (data) => { $("#idCaptchaImagen").attr('src', data); },
            	error: (e) => { $("#idEstadoProceso").text('Captcha No cargada'); }
        	});
		} catch (error) { console.log(error) }
	}
	  
	function guardar(captchaSRC){
		this.objMensaje = new Mensaje();
		this.objMensaje.denominacion = $('#idDenominacion').val();
		this.objMensaje.celular = $('#idCelular').val();
		this.objMensaje.email = $('#idEmail').val();
		this.objMensaje.consulta = $('#idConsulta').val();
		this.objMensaje.captcha = $('#idCaptchaTexto').val();
		if (this.guardarMensaje(this.objMensaje) == true) confirmarRecepcion();
		else regenerarCaptcha();
		$('#idEstadoRecepcion').text($('#idEstadoProceso').text());
	}

	function confirmarRecepcion(){
		$('#idFormulario').attr("hidden",true);
		$('#idDenominacion').val('');
		$('#idCelular').val('');
		$('#idEmail').val('');
		$('#idConsulta').val('');
	}

	$('document').ready( function() { $('#idEstadoProceso').attr("hidden", true); regenerarCaptcha(); });
	$(".tabFocus").focus( function() {if (this.tagName == 'INPUT') this.select(); }); //Controlador de selección de texto por medio del "Foco"
	$(".tabFocus").keyup( function(e) { if(e.keyCode == 13) $(".tabFocus").eq( $(".tabFocus").index(this) + 1 ).focus(); }); //Controlador del foco por medio de la tecla "Enter"

</script>
@endsection