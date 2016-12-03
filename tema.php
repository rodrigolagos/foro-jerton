<?php
	include_once("conexion.php");
	session_start();
	$id_usuario = $_SESSION['id'];
	$cargo = $_SESSION['cargo'];
	$logged_in = $_SESSION['logged_in'];
	if($_GET['id']==null){
		header("Location: index.php");
	}
	else{
		$id_tema = $_GET['id'];
	}
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
	<?php 
		include_once('header.php');
		$resultado = $mysqli->query("SELECT * FROM TEMAS WHERE id=".$id_tema."");
		$tema = $resultado->fetch_assoc();

		$autor_tema = $tema['usuario_id'];
		$usuario = $mysqli->query("SELECT * FROM USUARIOS WHERE id=".$autor_tema."")->fetch_assoc();

		$fechayhora= explode(" ",$usuario['fecha_registro']);
		$fecha = $fechayhora[0];

		$tipo_usuario = $mysqli->query("SELECT * FROM TIPOS_URUARIOS WHERE id=".$usuario['tipo_id']."")->fetch_assoc();

		$categoria = $mysqli->query("SELECT * FROM CATEGORIAS WHERE id=".$tema['categoria_id']."")->fetch_assoc();

		$categoria_id_editar = $categoria['id'];

	?>
	<div class="container">
		<ol class="breadcrumb">
		 	<li><a href="index.php">Home</a></li>
		  	<li><a href="categoria.php?id=<?php echo $tema['categoria_id']; ?>"><?php echo $categoria['titulo']; ?></a></li>
		  	<li class="active"><?php echo $tema['titulo']; ?></li>
		</ol>

		<?php
			if($logged_in) {
				echo '<a href="#form-responder"><button class="btn btn-primary comentar-tema">RESPONDER</button></a>';
			}else{
				echo '<button class="btn btn-primary comentar-tema" disabled>RESPONDER</button>
					  <div style="margin-bottom:20px;" class="warning-responder">Debes estar registrado para poder responder.</div>';
			}
		?>

		<div class="panel panel-default panel-tema">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3">
						<div class="well">
							<div class="row">
								<div class="col-md-6">
									<?php
										if($usuario['url_avatar']==null){
											echo '<a href="perfil.php?id='.$usuario["id"].'"><img src="http://simpleicon.com/wp-content/uploads/user1.png" alt="" class="img-thumbnail"></a>';
										}else{
											echo '<a href="perfil.php?id='.$usuario["id"].'"><img src="'.$usuario['url_avatar'].'" alt="" class="img-thumbnail" width="100%"></a>';
										}
									?>
									<a href="redactar-mensaje.php?destinatario=<?php echo $usuario["id"]; ?>"><button style="margin-top:6px;" class="btn btn-xs btn-block btn-primary">Enviar mensaje</button></a>
								</div>
								<div style="padding-left:0;" class="col-md-6">
									<div style="margin:0;" class="datos-autor">
										<div>
											<p style="display:block;margin-bottom:5px;"><a href="perfil.php?id=<?php echo $usuario['id']; ?>"><?php echo $usuario['nickname']; ?></a></p>
										</div>
										<div>
											<p style="display:block;margin-bottom:5px;"><?php echo $tipo_usuario['nombre']; ?></p>
										</div>
										<div>
											<span style="font-size:10px;display:block;">Registro</span>
											<p style="display:block;margin-bottom:5px;"><?php echo $fecha; ?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="contenido-tema" class="col-md-9">
						<div class="row">
							<div class="col-md-9">
								<h3><?php echo $tema['titulo']; ?></h3>
								<p id="fecha"><span class="glyphicon glyphicon-calendar"></span> Creado el <?php echo $tema['fecha']; ?></p>
							</div>
							<div class="col-md-3">
								<?php
									if($tema['usuario_id']==$id_usuario || $cargo == 'Administrador'){
										echo '<button style="margin-left:10px;" class="btn btn-xs btn-danger btn-eliminar-tema pull-right" data-toggle="modal" data-target="#myModal" tema="'.$tema['id'].'">Eliminar</button>
											  <a href="editar-tema.php?id='.$tema['id'].'"><button style="margin-left:10px;" class="btn btn-xs btn-primary pull-right">Editar</button></a>';
									}
								?>
							</div>
						</div>
						<p><?php echo nl2br($tema['contenido']); ?></p>
					</div>
				</div>
			</div>
		</div>
		
		<?php

		$comentarios = $mysqli->query("SELECT * FROM COMENTARIOS WHERE tema_id=".$id_tema."");
		while($fila = $comentarios->fetch_assoc()){

		$usuario_comentario = $mysqli->query("SELECT * FROM USUARIOS WHERE id=".$fila['usuario_id']."")->fetch_assoc();
		$fechayhora_registro_autor= explode(" ",$usuario_comentario['fecha_registro']);
		$fecha_registro_autor = $fechayhora_registro_autor[0];
		$tipo_usuario_comentario = $mysqli->query("SELECT * FROM TIPOS_URUARIOS WHERE id=".$usuario_comentario['tipo_id']."")->fetch_assoc();

		if($usuario_comentario['url_avatar']==null){
			$url_avatar = "http://simpleicon.com/wp-content/uploads/user1.png";
		}else{
			$url_avatar = $usuario_comentario['url_avatar'];
		}

		if($usuario_comentario['id']==$id_usuario || $cargo == 'Administrador'){
			$editar_comentario = '<button style="margin-left:10px;" class="btn btn-xs btn-danger btn-eliminar-comentario pull-right" data-toggle="modal" data-target="#myModal2" coment="'.$fila['id'].'">Eliminar</button>
								<a href="editar-comentario.php?id='.$fila['id'].'"><button style="margin-left:10px;" class="btn btn-xs btn-primary pull-right">Editar</button></a>';
		}else{
			$editar_comentario = '';
		}

		if($fila["fecha_creacion"]!=$fila["fecha_modificacion"]){
			$fecha_edicion = ', editado el '.$fila["fecha_modificacion"];
		}else{
			$fecha_edicion = '';
		}

		echo '<div class="panel panel-default panel-comentario">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3">
						<div class="well">
							<div class="row">
								<div class="col-md-6">
									<a href="perfil.php?id='.$usuario_comentario['id'].'"><img src="'.$url_avatar.'" alt="" class="img-thumbnail" width="100%"></a>
									<a href="redactar-mensaje.php?destinatario='.$usuario_comentario['id'].'"><button style="margin-top:6px;" class="btn btn-xs btn-block btn-primary">Enviar mensaje</button></a>
								</div>
								<div style="padding-left:0;" class="col-md-6">
									<div style="margin:0;" class="datos-autor">
										<div>
											<p style="display:block;margin-bottom:5px;"><a href="perfil.php?id='.$usuario_comentario['id'].'">'.$usuario_comentario["nickname"].'</a></p>
										</div>
										<div>
											<p style="display:block;margin-bottom:5px;">'.$tipo_usuario_comentario["nombre"].'</p>
										</div>
										<div>
											<span style="font-size:10px;display:block;">Registro</span>
											<p style="display:block;margin-bottom:5px;">'.$fecha_registro_autor.'</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="contenido-tema" class="col-md-9">
						<div class="row">
							<div class="col-md-8">
								<p id="fecha"><span class="glyphicon glyphicon-calendar"></span> Creado el '.$fila["fecha_creacion"].''.$fecha_edicion.'</p>
							</div>
							<div class="col-md-4">
								'.$editar_comentario.'
							</div>
						</div>
						<p>'.nl2br($fila["contenido"]).'</p>
					</div>
				</div>
			</div>
		</div>';

		}

		?>
		
		<div class="page-header titulo-responder">
			<h4>Responder</h4>
		</div>
		
		<?php

			if($logged_in){
				echo '<div class="well">
						<form id="form-responder" class="form form-horizontal" role="form">
							<div id="form-comentario" class="form-group has-feedback">
							    <label class="control-label col-sm-1" for="comentario">Comentario</label>
							    <div class="col-sm-11">
						    		<textarea class="form-control" rows="5" id="comentario" placeholder="Escribe el comentario..." data-minlength="2" data-minlength-error="El largo del comentario debe ser de al menos 2 caracteres" required></textarea>
						    		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									<span id="span-contenido" class="help-block with-errors"></span>
							    </div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-1" for="crear"></label>
								<div class="col-sm-11">
									<button type="submit" id="responder" class="btn btn-primary">Responder</button>
								</div>
							</div>
						</form>
					</div>';
			}else{
				echo '<h3 style="text-align: center;">Para poder responder a un tema debes estar registrado.</h3>
					  <h5 style="text-align: center;"><a class="btn btn-link" href="iniciar-sesion.php?ref='.$actual_link.'&id-elem=form-responder">Inicia sesión</a> o <a class="btn btn-link" href="registrarse.php">Resgistrate</a></h5>';
			}
		?>
	</div>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">¿Seguro que deseas eliminar el tema?</h4>
				</div>
				<div class="modal-body">
					Al eliminar el tema se eliminarán todos los comentarios asociados a éste.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-danger btn-ok-eliminar-tema">Eliminar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">¿Seguro que deseas eliminar el comentario?</h4>
				</div>
				<div class="modal-body">
					El comentario será eliminado definitivamente.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-danger btn-ok-eliminar-comentario">Eliminar</button>
				</div>
			</div>
		</div>
	</div>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/validator.min.js"></script>
	<script>

	$(".comentar-tema").click(function(){
		$("#comentario").focus();
	});

	$('#form-responder').validator({
    	delay: 250,
    	disable: false,
    });

	$('#form-responder').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   	e.preventDefault();
	 	   	var comentario = $("#comentario").val();
	 	   	<?php print 	"var id_usuario = '$id_usuario';
							var id_tema = '$id_tema';"; 
	 	   	?>

	 	   	$.ajax({
				type: "POST",
				url: "crear-nuevo-comentario.php",
				data: "comentario="+comentario+"&id-usuario="+id_usuario+"&id-tema="+id_tema,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						alert("Se ha respondido al tema satisfactoriamente");
						window.location.replace('tema.php?id='+id_tema);
					}
				}
			});
	  	}
	})
	
	$('body').on("click", ".btn-eliminar-tema", function (){
		<?php
			print "var id_categoria = $categoria_id_editar;";
		?>
		var tema = $(this).attr('tema');
		$(".btn-ok-eliminar-tema").unbind().click(function(){
			$.ajax({
				type: "POST",
				url: "eliminar-tema.php",
				data: "tema="+tema,
				dataType:"html",
				success: function(data) 
				{
				 	if(data=="OK"){
				 		alert("tema eliminado correctamente");
				 		window.location.replace("categoria.php?id="+id_categoria);
				 	}else{
				 		alert("error");
				 	}
				}
			});
		});
	});

	$('body').on("click", ".btn-eliminar-comentario", function (){
		<?php
			print "var id_tema = $id_tema;";
		?>
		var comentario = $(this).attr('coment');
		$(".btn-ok-eliminar-comentario").unbind().click(function(){
			$.ajax({
				type: "POST",
				url: "eliminar-comentario.php",
				data: "comentario="+comentario,
				dataType:"html",
				success: function(data) 
				{
				 	if(data=="OK"){
				 		alert("comentario eliminado correctamente");
				 		window.location.replace("tema.php?id="+id_tema);
				 	}else{
				 		alert("error");
				 	}
				}
			});
		});
	});
	</script>

</body>
</html>