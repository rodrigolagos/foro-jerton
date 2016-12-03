<?php
	include_once("conexion.php");
	session_start();
	$id_usuario_logueado = $_SESSION['id'];
	$cargo = $_SESSION['cargo'];
	$logged_in = $_SESSION['logged_in'];
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

		$mensajes_query = $mysqli->query("SELECT * FROM MENSAJES WHERE id_recibe=".$id_usuario_logueado."");
		$mensajes = $mensajes_query->fetch_assoc();

		$actividades_query = $mysqli->query("SELECT * FROM ACTIVIDADES WHERE usuario_id=".$id_usuario_logueado."");
		$actividades = $actividades_query->fetch_assoc();

		$mensajes_query1 = $mysqli->query("SELECT * FROM MENSAJES WHERE id_recibe=".$id_usuario_logueado." ORDER BY fecha_envio DESC");
		
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
					<li class="list-group-item">
						<span class="badge"><?php echo $actividades['mensajes_noleidos']; ?></span>
						Bandeja de entrada
					</li>
				</ul>
			</div>
			<div class="col-md-9">
				<?php
					if($mensajes_query->num_rows > 0){

						echo '<div class="panel panel-default">
								<div class="panel-body">
									<table class="table table-hover">
										<thead>
											<tr id="cabecera-mensajes">
												<th class="col-xs-2 col-md-6">Asunto</th>
												<th class="col-md-3">Remitente</th>
												<th class="col-xs-4 col-md-3">Fecha</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<ul class="list-group">';
						while($fila = $mensajes_query1->fetch_assoc()){
							$usuario_query = $mysqli->query("SELECT * FROM USUARIOS WHERE id=".$fila['id_envia']."");
							$usuario = $usuario_query->fetch_assoc();
							
							if($fila['estado']==1){
								echo 	'<a href="ver-mensaje.php?id='.$fila['id'].'" class="list-group-item">
											<div class="row">
												<div class="col-md-6">'.$fila['asunto'].'</div>
												<div style="text-align: center;" class="col-md-3">'.$usuario['nickname'].'</div>
												<div style="text-align: center;" class="col-md-3">'.$fila['fecha_envio'].'</div>
											</div>
										</a>';
							}else{
								echo 	'<a href="ver-mensaje.php?id='.$fila['id'].'" class="active list-group-item item-mensaje" id-mensaje="'.$fila['id'].'">
											<div class="row">
												<div class="col-md-6">'.$fila['asunto'].'</div>
												<div style="text-align: center;" class="col-md-3">'.$usuario['nickname'].'</div>
												<div style="text-align: center;" class="col-md-3">'.$fila['fecha_envio'].'</div>
											</div>
										</a>';
							}
						}
						echo 		'</ul>
								</div>
							</div>';
					}else{
						echo '<h4 style="text-align:center;">No tienes mensajes en la bandeja de entrada<h4>';
					}
				?>
			</div>
		</div>

	</div>




	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/validator.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script>
    $('body').on("click", ".item-mensaje", function (){
		var mensaje = $(this).attr('id-mensaje');
		$.ajax({
			type: "POST",
			url: "leer-mensaje.php",
			data: "mensaje="+mensaje,
			dataType:"html",
			success: function(data) 
			{
				
			}
		});
	});
    </script>

</body>
</html>