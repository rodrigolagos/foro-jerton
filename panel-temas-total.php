<?php include_once("conexion.php"); 
	session_start();
	$cargo = $_SESSION['cargo'];
?>

<div class="container">

	<?php 
		$todos_temas = $mysqli->query("SELECT * FROM TEMAS WHERE categoria_id=".$id_categoria."");

		if($todos_temas->num_rows > 0){
			if($cargo=="Administrador"){
				echo 	'<table class="table table-hover">
					      	<thead>
						        <tr id="cabecera-temas">
						          	<th class="col-xs-2 col-md-6">Asunto</th>
						          	<th class="col-md-3">Autor</th>
						          	<th class="col-xs-4 col-md-2">Respuestas</th>
						          	<th class="col-xs-4 col-md-1"></th>
						        </tr>
					      	</thead>
					      	<tbody>
					      	</tbody>
					    </table>';
			}else{
				echo 	'<table class="table table-hover">
					      	<thead>
						        <tr id="cabecera-temas">
						          	<th class="col-xs-2 col-md-7">Asunto</th>
						          	<th class="col-md-3">Autor</th>
						          	<th class="col-xs-4 col-md-2">Respuestas</th>
						        </tr>
					      	</thead>
					      	<tbody>
					      	</tbody>
					    </table>';
			}
		}
		else{
			echo '<div class="container">
					<h3 style="text-align:center;">No hay temas en esta categoria</h3>
				</div>';
		}

		while ($fila = $todos_temas->fetch_assoc()) {
			$cant_respuestas = $mysqli->query("SELECT count(*) FROM COMENTARIOS WHERE tema_id=".$fila['id']."");
			$respuestas_cantidad = $cant_respuestas->fetch_array();

			$usuario_nickname = $mysqli->query("SELECT nickname FROM USUARIOS WHERE id=".$fila['usuario_id']."");
			$nickname = $usuario_nickname->fetch_array();
			
		
			if($cargo=="Administrador"){
				echo 	'<div class="panel panel-default panel-categoria">
							<div class="panel-body">
							  	<div class="row">
						 			<div class="col-md-6"><a href="tema.php?id='.$fila["id"].'">'.$fila["titulo"].'</a></div>
						 			<div style="text-align: center;" class="col-md-3"><a href="perfil.php?id='.$fila["usuario_id"].'">'.$nickname[0].'</a></div>
						 			<div style="text-align: center;" class="col-md-2">'.$respuestas_cantidad[0].'</div>
						 			<div style="text-align: center;" class="col-md-1"><button class="btn btn-xs btn-danger btn-eliminar-tema" data-toggle="modal" data-target="#myModal" tema="'.$fila['id'].'">ELIMINAR</button></div>
						 		</div>
						 	</div>
						</div>';
			}else{
				echo 	'<div class="panel panel-default panel-categoria">
							<div class="panel-body">
							  	<div class="row">
						 			<div class="col-md-7"><a href="tema.php?id='.$fila["id"].'">'.$fila["titulo"].'</a></div>
						 			<div style="text-align: center;" class="col-md-3"><a href="perfil.php?id='.$fila["usuario_id"].'">'.$nickname[0].'</a></div>
						 			<div style="text-align: center;" class="col-md-2">'.$respuestas_cantidad[0].'</div>
						 		</div>
						 	</div>
						</div>';
			}
		}

		if($todos_temas->num_rows > 0){
					echo 	'<a href="crear-tema.php?categoria='.$id_categoria.'"><button id="nuevo-tema" type="button" class="btn btn-primary">Nuevo Tema</button></a>';
				}
	?>
</div>