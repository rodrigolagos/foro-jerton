<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Jertón: Héroes de CraftWar</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />


	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include_once('header.php') ?>
	<div class="container col-md-offset-3 col-md-6 col-xs-offset-1 col-xs-10" id="formulario-registro">
		<div class="row">
			<div class="panel panel-default">
				<div style="padding: 15px" class="panel-heading">
			    	<h3 class="panel-title">Formulario de Registro</h3>
				</div>
				<div style="padding:20px;" class="panel-body">
			    	<form id="form-registro" class="form form-horizontal" role="form">
						<div id="nickname-registro" class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="registro-nickname">Nickname</label>
						    <div class="col-sm-9">
						      	<input type="text" class="form-control" id="registro-nickname" placeholder="Nombre para loggear (Ejemplo: juanperez007)" pattern="^\S*$" data-pattern-error="No puede contener espacios" data-minlength="6" maxlength="16" data-minlength-error="El largo debe estar entre 6 y 16 caracteres" required>
						      	<span id="span-nickname-glyphicon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span id="span-nickname" class="help-block with-errors"></span>
						    </div>
						</div>
						<div id="nombre-registro" class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="registro-nombre">Nombre</label>
						    <div class="col-sm-9">
					    		<input type="text" class="form-control" id="registro-nombre" placeholder="Nombre para mostrar (Ejemplo: Juan Pérez)" data-minlength="0" maxlength="16" required>
					      		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span id="span-usuario" class="help-block with-errors"></span>
						    </div>
						</div>
						<div id="password-registro" class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="registro-pass">Contraseña</label>
						    <div class="col-sm-9">
						      	<input type="password" class="form-control" id="registro-pass" placeholder="Contraseña" data-minlength="0" maxlength="16" required>
						      	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span id="span-password" class="help-block with-errors"></span>
						    </div>
						</div>
						<div class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="registro-re-pass">Repetir Contraseña</label>
						    <div class="col-sm-9">
						      	<input type="password" class="form-control" id="registro-re-pass" placeholder="Repetir contraseña" data-match="#registro-pass" data-match-error="Las contraseñas no coinciden" required>
						      	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span class="help-block with-errors"></span>
						    </div>
						</div>
						<div class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="registro-fecha-nac">Fecha de Nacimiento</label>
						    <div class="col-sm-9">
						    	<div class="input-group input-append date" id="datePicker">
					                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
					                <input id="registro-fecha-nac" type="text" class="form-control" name="date" placeholder="AAAA-MM-DD" required />
				            	</div>
				            	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    							<span class="help-block with-errors"></span>
						    </div>
						</div>
						<div class="form-group">
						    <label class="control-label col-sm-3">Sexo</label>
						    <div class="col-sm-9">
						      	<div class="radio-inline">
								  	<label>
								    	<input type="radio" name="opciones" id="opcion-masculino" value="0" checked>
								    	Masculino
								  	</label>
								</div>
								<div class="radio-inline">
								  	<label>
								    	<input type="radio" name="opciones" id="opcion-femenino" value="1">
								    	Femenino
								  	</label>
								</div>
						    </div>
						</div>
						<div class="form-group has-feedback">
						    <label class="control-label col-sm-3" for="registro-url">URL Avatar</label>
						    <div class="col-sm-9">
						      	<input type="text" class="form-control" id="registro-url" placeholder="URL Avatar">
						    </div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-3" for="registrar"></label>
							<div class="col-sm-9">
								<button type="submit" id="registrar" class="btn btn-primary">Registrarse</button>
							</div>
						</div>
					</form>
				</div>
				<div class="panel-footer">
					<a href="iniciar-sesion.php">¿Ya tienes una cuenta? Ingresa</a>
				</div>
			</div>
		</div>
    </div>

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">

	$('#datePicker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: 'today'
    });

    $('#form-registro').validator({
    	delay: 250,
    	disable: false,
    	errors:{
    		match:'Los datos no coinciden',
    	}
    });

    //Error si Nombre tiene mas de 16 caracteres
    $(".form").on("keyup", "#nombre-registro input", function(){
    	if($('#nombre-registro input').val().length==16){
    		$("#span-usuario").html("Debe tener menos de 16 caracteres");
    	}else{
    		$("#span-usuario").html("");
    	}
	});

	//Error si Password tiene mas de 16 caracteres
	$(".form").on("keyup", "#password-registro input", function(){
    	if($('#password-registro input').val().length==16){
    		$("#span-password").html("Debe tener menos de 16 caracteres");
    	}else{
    		$("#span-password").html("");
    	}
	});

	//Error si Nickname tiene mas de 16 caracteres
	$(".form").on("keyup", "#nickname-registro input", function(){
    	if($('#nickname-registro input').val().length==16){
    		$("#span-nickname").html("Debe tener menos de 16 caracteres");
    	}else{
    		$("#span-nickname").html("");
    		//Error si el Nickname ya existe
    		if($('#nickname-registro input').val()!="" && $('#nickname-registro input').val().length>5){
    			var nickname = $('#registro-nickname').val();
    			$.ajax({
					type: "POST",
					url: "validar-usuario.php",
					data: "nickname="+nickname,
					dataType:"html",
					success: function(data) 
					{
						if(data=="OK"){
							$("#nickname-registro").removeClass("has-success");
							$("#nickname-registro").addClass("has-error");
							$("#span-nickname").html("Nickname no disponible");
							$('#registrar').prop('disabled',true);
						}else{
							$('#registrar').prop('disabled',false);
						}
					}
				});
    		}else{
    			$("#span-nickname").html("");
    		}
    	}
	});

	$('#form-registro').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   	e.preventDefault();
	 	   	var nickname = $('#registro-nickname').val();
	 	   	var nombre = $('#registro-nombre').val();
	 	   	var password = $('#registro-pass').val();
	 	   	var fecha_nac = $('#registro-fecha-nac').val();
	 	   	var sexo = $('input[name=opciones]:checked', '#formulario-registro').val();
	 	   	var url_avatar = $('#registro-url').val();

	 	   	$.ajax({
				type: "POST",
				url: "registrar-usuario.php",
				data: "nickname="+nickname+"&nombre="+nombre+"&password="+password+"&fecha-nac="+fecha_nac+"&sexo="+sexo+"&url-avatar="+url_avatar,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						alert("Se ha registrado satisfactoriamente");
						window.location.replace('index.php');
					}
				}
			});
	 	   
	  	}
	})
	</script>
</body>
</html>