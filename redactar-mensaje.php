<?php
	include_once("conexion.php");
	session_start();
	$id_usuario_logueado = $_SESSION['id'];
	$cargo = $_SESSION['cargo'];
	$logged_in = $_SESSION['logged_in'];
	if(!$logged_in){
		header("Location: index.php");
	}
	if($_GET['destinatario']==null){
		$id_envia = null;
	}
	else{
		$id_envia = $_GET['destinatario'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Jertón: Héroes de CraftWar</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.vertical-tabs.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php 
		include_once('header.php');

		$actividades_query = $mysqli->query("SELECT * FROM ACTIVIDADES WHERE usuario_id=".$id_usuario_logueado."");
		$actividades = $actividades_query->fetch_assoc();


		
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<ol class="breadcrumb">
			 	<li><a href="index.php">Home</a></li>
			  	<li>Mensajes</li>
			</ol>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<a href="redactar-mensaje.php"><button class="btn btn-primary btn-redactar">Redactar</button></a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<ul class="list-group">
					<a href="mensajes.php" class="list-group-item">
						<span class="badge"><?php echo $actividades['mensajes_noleidos']; ?></span>
						Bandeja de entrada
					</a>
				</ul>
			</div>
			<div class="col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4 style="margin-top:10px;" class="page-header">Redactar mensaje</h4>
						<form id="form-redactar-mensaje" class="form form-horizontal" role="form">
							<div id="form-destinatario" class="form-group has-feedback">
							    <label class="control-label col-md-2" for="destinatario">Destinatario</label>
							    <div class="col-md-10">
							    	<?php
							    	if($id_envia==null){
							    		echo '<input class="form-control" id="destinatario" placeholder="Destinatario" required>';
							    	}else{
							    		$usuarios_query = $mysqli->query("SELECT * FROM USUARIOS WHERE id=".$id_envia."");
							    		$usuario = $usuarios_query->fetch_assoc();
							    		echo '<input class="form-control" id="destinatario" value="'.$usuario['nickname'].'" required>';
							    	}
							    	?>
						    		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									<span id="span-contenido" class="help-block with-errors"></span>
							    </div>
							</div>
							<div id="form-asunto" class="form-group has-feedback">
							    <label class="control-label col-md-2" for="asunto">Asunto</label>
							    <div class="col-md-10">
						    		<input class="form-control" id="asunto" placeholder="Asunto" required>
						    		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									<span id="span-contenido" class="help-block with-errors"></span>
							    </div>
							</div>
							<div id="form-comentario" class="form-group has-feedback">
							    <label class="control-label col-md-2" for="contenido-mensaje">Mensaje</label>
							    <div class="col-md-10">
						    		<textarea class="form-control" rows="5" id="contenido-mensaje" placeholder="Escribe el mensaje..." data-minlength="2" data-minlength-error="El largo del comentario debe ser de al menos 2 caracteres" required></textarea>
						    		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									<span id="span-contenido" class="help-block with-errors"></span>
							    </div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-md-2" for="crear"></label>
								<div class="col-md-10">
									<button type="submit" id="enviar-mensaje" class="btn btn-primary">Enviar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>




	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/validator.min.js"></script>
    <script>

    $('#form-redactar-mensaje').validator({
    	delay: 250,
    	disable: false,
    });

    $('#form-redactar-mensaje').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   	e.preventDefault();
	 	   	<?php print 	"var id_envia = '$id_usuario_logueado';"; 
	 	   	?>
	 	   	var id_recibe = $("#destinatario").val();
	 	   	var asunto = $("#asunto").val();
	 	   	var contenido = $("#contenido-mensaje").val();

	 	   	$.ajax({
				type: "POST",
				url: "enviar-mensaje.php",
				data: "id-envia="+id_envia+"&id-recibe="+id_recibe+"&asunto="+asunto+"&contenido="+contenido,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						alert("Se ha enviado el mensaje satisfactoriamente");
						window.location.replace('mensajes.php');
					}else{
						alert("Error");
					}
				}
			});
	  	}
	})

    </script>

</body>
</html>