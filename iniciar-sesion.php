<?php 
	session_start();
	if($_SESSION['logged_in']){
		header("Location: index.php");
		die();
	}

	if($_GET['ref']==null){
		$redirect = null;
	}else{
		$redirect = $_GET['ref'];
	}

	if($_GET['id-elem']==null){
		$id_elem = null;
	}else{
		$id_elem = $_GET['id-elem'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Jertón: Héroes de CraftWar</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include_once('header.php') ?>
	<div class="container">
		<div class="row">
			<div style="margin:0 auto 0 auto; max-width:350px;" class="panel panel-default">
				<div style="padding: 15px" class="panel-heading">
			    	<h3 class="panel-title">Iniciar Sesión</h3>
				</div>
				<div style="padding:20px;" class="panel-body">
			    	<form id="form-login" data-toggle="validator" class="form" role="form">
					  <div id="usuario" class="form-group has-feedback">
					    <div class="input-group">
					    	<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
					    	<input class="form-control" id="usuario-login" placeholder="Nombre de usuario" required>
					    </div>
					    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    					<span class="help-block with-errors"></span>
					  </div>
					  <div id="contraseña" class="form-group has-feedback">
					    <div class="input-group">
					    	<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
					    	<input type="password" class="form-control" id="password-login" placeholder="Contraseña" required>
					    </div>
					    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    					<span class="help-block with-errors"></span>
					  </div>
					  <div id="mensaje-error"></div>
					  <button type="submit" id="entrar" class="btn btn-lg btn-primary btn-block" ref="<?php echo $redirect; ?>" id-elem="<?php echo $id_elem; ?>">Ingresar</button>
					</form>
				</div>
				<div class="panel-footer">
					<a href="registrarse.php">¿Necesitas una cuenta?</a>
				</div>
			</div>
		</div>
    </div>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script type="text/javascript">

	$('#form-login').validator({
    	delay: 250,
    	disable: false,
    	errors:{
    		match:'Los datos no coinciden'
    	}
    });

    $('#form-login').on('validated.bs.validator', function(){
	    $("#mensaje-error").fadeOut();
	});

	$('#form-login').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   e.preventDefault();
	 	   var usuario = $("#usuario-login").val();
	 	   var password = $("#password-login").val();
	 	   var ref = $("#entrar").attr("ref");
	 	   var id_elem = $("#entrar").attr("id-elem");

	 	   $.ajax({
				type: "POST",
				url: "loguear-usuario.php",
				data: "usuario="+usuario+"&password="+password,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						if(ref==null){
							window.location.replace('index.php');
						}else{
							if(id_elem==""){
								window.location.replace(''+ref+'');
							}else{
								window.location.replace(ref+'#'+id_elem);
							}
						}
					}else{
						$("#mensaje-error").fadeIn();
						$("#usuario").removeClass("has-success").addClass("has-error");
						$("#usuario>span:nth-child(2)").removeClass("glyphicon-ok").addClass("glyphicon-remove");
						$("#contraseña").removeClass("has-success").addClass("has-error");
						$("#contraseña>span:nth-child(2)").removeClass("glyphicon-ok").addClass("glyphicon-remove");
						$("#mensaje-error").addClass("alert alert-danger");
	  					$("#mensaje-error").html("Usuario o contraseña incorrectos");
					}
				}
			});
	  	}
	})

    </script>

</body>
</html>