<?php include_once("conexion.php"); 
	session_start();
	$cargo = $_SESSION['cargo'];
?>

<div class="container">
	  		<table class="table table-hover">
		      	<thead>
			        <tr id="cabecera-categorias">
			          	<th class="col-xs-2 col-md-5"></th>
			          	<th class="col-md-2">Temas</th>
			          	<th class="col-md-2">Respuestas</th>
			          	<th class="col-xs-4 col-md-3">Último tema comentado</th>
			        </tr>
		      	</thead>
		      	<tbody>
		      	</tbody>
		    </table>

			<?php 
	  			$todas_categorias = $mysqli->query("SELECT * FROM CATEGORIAS");

	  			while ($fila = $todas_categorias->fetch_assoc()) {
	  				$cant_temas = $mysqli->query("SELECT count(*) FROM TEMAS WHERE categoria_id=".$fila['id']."");
	  				$temas_cantidad = $cant_temas->fetch_array();

	  				$cant_comentarios = $mysqli->query("SELECT count(*) FROM COMENTARIOS,TEMAS,CATEGORIAS WHERE COMENTARIOS.tema_id=TEMAS.id AND TEMAS.categoria_id=CATEGORIAS.id AND CATEGORIAS.id=".$fila['id']."");
					$comentarios_cantidad = $cant_comentarios->fetch_array();

					$resultado = $mysqli->query("SELECT COMENTARIOS.usuario_id,COMENTARIOS.tema_id, COMENTARIOS.fecha_creacion FROM COMENTARIOS,TEMAS,CATEGORIAS WHERE COMENTARIOS.fecha_creacion=(SELECT max(fecha_creacion) from COMENTARIOS, TEMAS, CATEGORIAS WHERE COMENTARIOS.tema_id=TEMAS.id AND TEMAS.categoria_id=CATEGORIAS.id AND CATEGORIAS.id=".$fila['id']." ) AND COMENTARIOS.tema_id=TEMAS.id AND TEMAS.categoria_id=CATEGORIAS.id AND CATEGORIAS.id=".$fila['id']."");
					if($resultado->num_rows >0){
						$resultado_procesado = $resultado->fetch_array();
						$id_usuario = $resultado_procesado[0];
						$id_tema = $resultado_procesado[1];
						$fecha_ultima = $resultado_procesado[2];

						$tema_titulo = $mysqli->query("SELECT titulo FROM TEMAS WHERE id=".$id_tema."");
						if($tema_titulo->num_rows >0){
							$titulo = $tema_titulo->fetch_array();
						}
						
						$usuario_nickname = $mysqli->query("SELECT nickname FROM USUARIOS WHERE id=".$id_usuario."");
						if($usuario_nickname->num_rows >0){
							$nickname = $usuario_nickname->fetch_array();
						}

						$ultimo_comentario = '<div class="col-md-3"><a href="tema.php?id='.$id_tema.'">'.mb_strimwidth($titulo[0], 0, 16, "...").'</a> por <a href="perfil.php?id='.$id_usuario.'">'.$nickname[0].'</a> <br>en '.$fecha_ultima.'</div>';

					}else{
						$ultimo_comentario = '<div class="col-md-3">No hay comentarios.</div>';
					}

					if($cargo=='Administrador'){
						$boton = '<button class="btn btn-xs btn-danger btn-eliminar-cat pull-right" data-toggle="modal" data-target="#myModal" cat='.$fila["id"].'>Eliminar</button>';
					}else{
						$boton = '';
					}



					echo 	'<div class="panel panel-default panel-categoria">
								<div class="panel-heading">
							  		<h3 class="panel-title pull-left"><a href="categoria.php?id='.$fila["id"].'">'.$fila["titulo"].'</a></h3>
							        '.$boton.'
							        <div class="clearfix"></div>
							  	</div>
							 	<div class="panel-body">
							 		<div class="row">
							 			<div class="col-md-5">
							 				'.$fila["descripcion"].'
							 			</div>
							 			<div class="col-md-2">'.$temas_cantidad[0].'</div>
							 			<div class="col-md-2">'.$comentarios_cantidad[0].'</div>
							 			'.$ultimo_comentario.'
							 		</div>
							 	</div>
							 </div>';
				}
	  		?>
</div>