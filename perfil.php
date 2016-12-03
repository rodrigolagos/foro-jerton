<?php
	include_once("conexion.php");
	session_start();
	$id_usuario_logueado = $_SESSION['id'];
	$cargo = $_SESSION['cargo'];
	$logged_in = $_SESSION['logged_in'];
	if($_GET['id']==null){
		header("Location: index.php");
	}
	else{
		$id_usuario = $_GET['id'];
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
		$resultado = $mysqli->query("SELECT * FROM USUARIOS WHERE id=".$id_usuario."");
		$usuario = $resultado->fetch_assoc();

		$tipo_usuario = $mysqli->query("SELECT * FROM TIPOS_URUARIOS WHERE id=".$usuario['tipo_id']."")->fetch_assoc();

		$actividad_query = $mysqli->query("SELECT * FROM ACTIVIDADES WHERE usuario_id=".$id_usuario."");
		$actividad = $actividad_query->fetch_assoc();

		$ultimos_temas_comentados_query = $mysqli->query("SELECT * FROM View_ultimos_comentarios WHERE usuario_id=".$id_usuario." limit 5");
		$ultimos_temas_creados_query = $mysqli->query("SELECT * FROM View_temas_creados WHERE usuario_id=".$id_usuario." limit 5");
		
	?>
	<div class="container">
		<div class="col-md-12">
			<ol class="breadcrumb">
			 	<li><a href="index.php">Home</a></li>
			  	<li>Perfil</li>
			</ol>
		</div>

		<div class="col-xs-3"> <!-- required for floating -->
		    <!-- Nav tabs -->
		    <ul class="nav nav-tabs tabs-left">
				<li class="active"><a href="#datos" data-toggle="tab"><i style="margin-left:5px;margin-right:15px;" class="fa fa-info"></i>Ver Datos</a></li>
				<li><a href="#act-reciente" data-toggle="tab"><i style="margin-right:10px;" class="fa fa-commenting-o"></i> Actividad Reciente</a></li>
				<?php
					if($id_usuario_logueado==$id_usuario || $cargo=='Administrador'){
						echo '<li><a href="#editar" data-toggle="tab"><i style="margin-right:10px;" class="fa fa-pencil"></i> Editar</a></li>';
					}
				?>
		    </ul>
		</div>

		<div class="col-xs-9">
		    <!-- Tab panes -->
		    <div class="tab-content">
				<div class="tab-pane active" id="datos">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-9">
									<div style="margin-bottom:0" class="well">
										<div class="row">
											<div class="col-md-5"><p class="pull-left"><i class="fa fa-user"></i><b> Nombre:</b></p></div>
											<div class="col-md-7"><p><?php echo $usuario['nombre']; ?></p></div>

											<div class="col-md-5"><p class="pull-left"><i class="fa fa-calendar"></i></span><b> Edad:</b></p></div>
											<div class="col-md-7"><p><?php echo date_diff(date_create($usuario['fecha_nacimiento']), date_create('today'))->y; ?></p></div>

											<div class="col-md-5"><p class="pull-left"><i class="fa fa-transgender"></i><b> Sexo:</b></p></div>
											<div class="col-md-7"><p>
												<?php
													if($usuario['sexo']==0){
														echo 'Masculino';
													}else{
														echo 'Femenino';
													}
												?>
											</p></div>
										
											<div class="col-md-5"><p class="pull-left"><i class="fa fa-comments"></i><b> Número de comentarios:</b></p></div>
											<div class="col-md-7"><p><?php echo $actividad['n_comentario']; ?></p></div>
										
											<div class="col-md-5"><p class="pull-left"><i class="fa fa-calendar-check-o"></i><b> Fecha de registro:</b></p></div>
											<div class="col-md-7"><p><?php echo $usuario['fecha_registro']; ?></p></div>

											<div class="col-md-5"><p style="margin-bottom:0" class="pull-left"><i class="fa fa-users"></i><b> Tipo de usuario:</b></p></div>
											<div class="col-md-7"><p style="margin-bottom:0"><?php echo $tipo_usuario['nombre']; ?></p></div>
										</div>
									</div>
								</div>

								<div class="col-md-3">
										<?php
											if($usuario['url_avatar']==null){
												echo '<img src="http://simpleicon.com/wp-content/uploads/user1.png" alt="" class="img-thumbnail">';
											}else{
												echo '<img src="'.$usuario['url_avatar'].'" alt="" class="img-thumbnail">';
											}
										?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="act-reciente">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div style="margin-bottom:0" class="well">
										
										<h4 class="page-header">Ultimos temas comentados</h4>
										<ul class="list-group">
											<?php 
											while($fila=$ultimos_temas_comentados_query->fetch_assoc()){
												echo '<li class="list-group-item"><a href="tema.php?id='.$fila["id"].'">'.$fila["titulo"].'</a></li>';
											}
											?>
										</ul>

										<h4 style="margin-top:40px;" class="page-header">Ultimos temas creados</h4>
										<ul class="list-group">
											<?php 
											while($fila=$ultimos_temas_creados_query->fetch_assoc()){
												echo '<li class="list-group-item"><a href="tema.php?id='.$fila["id"].'">'.$fila["titulo"].'</a></li>';
											}
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					if($id_usuario_logueado==$id_usuario || $cargo=='Administrador'){
						if($cargo=='Administrador'){
							if($usuario['tipo_id']==0){
								$editar_tipo_usuario = 	'<div class="form-group has-feedback">
														    <label class="control-label col-sm-3" for="editar-tipo">Tipo usuario</label>
														    <div class="col-sm-9">
														      	<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-administrador" value="0" checked>
																    	Administrador
																  	</label>
																</div>
																<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-moderador" value="1">
																    	Moderador
																  	</label>
																</div>
																<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-usuario" value="2">
																    	Usuario
																  	</label>
																</div>
														    </div>
														</div>';
							}else if($usuario['tipo_id']==1){
								$editar_tipo_usuario = 	'<div class="form-group has-feedback">
														    <label class="control-label col-sm-3" for="editar-tipo">Tipo usuario</label>
														    <div class="col-sm-9">
														      	<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-administrador" value="0" >
																    	Administrador
																  	</label>
																</div>
																<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-moderador" value="1" checked>
																    	Moderador
																  	</label>
																</div>
																<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-usuario" value="2">
																    	Usuario
																  	</label>
																</div>
														    </div>
														</div>';
							}
							else{
								$editar_tipo_usuario = 	'<div class="form-group has-feedback">
														    <label class="control-label col-sm-3" for="editar-tipo">Tipo usuario</label>
														    <div class="col-sm-9">
														      	<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-administrador" value="0">
																    	Administrador
																  	</label>
																</div>
																<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-moderador" value="1">
																    	Moderador
																  	</label>
																</div>
																<div class="radio-inline">
																  	<label>
																    	<input type="radio" name="opciones-tipo" id="opcion-usuario" value="2" checked>
																    	Usuario
																  	</label>
																</div>
														    </div>
														</div>';
							}
								
						}else{
							$editar_tipo_usuario = '';
						}
						if($usuario['sexo']==0){
							$sexo_usuario = '<div class="form-group">
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
												</div>';
						}else{
							$sexo_usuario = '<div class="form-group">
												    <label class="control-label col-sm-3">Sexo</label>
												    <div class="col-sm-9">
												      	<div class="radio-inline">
														  	<label>
														    	<input type="radio" name="opciones" id="opcion-masculino" value="0">
														    	Masculino
														  	</label>
														</div>
														<div class="radio-inline">
														  	<label>
														    	<input type="radio" name="opciones" id="opcion-femenino" value="1" checked>
														    	Femenino
														  	</label>
														</div>
												    </div>
												</div>';
						}
						echo '<div class="tab-pane" id="editar">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="well">
											<form id="form-editar-perfil" class="form form-horizontal" role="form">
												<div id="nickname-editar" class="form-group has-feedback">
												    <label class="control-label col-sm-3" for="editar-nickname">Nickname</label>
												    <div class="col-sm-9">
												      	<input type="text" class="form-control" id="editar-nickname" value="'.$usuario['nickname'].'" pattern="^\S*$" data-pattern-error="No puede contener espacios" data-minlength="6" maxlength="16" data-minlength-error="El largo debe estar entre 6 y 16 caracteres" disabled>
												      	<span id="span-nickname-glyphicon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
						    							<span id="span-nickname" class="help-block with-errors"></span>
												    </div>
												</div>
												<div id="nombre-editar" class="form-group has-feedback">
												    <label class="control-label col-sm-3" for="editar-nombre">Nombre</label>
												    <div class="col-sm-9">
											    		<input type="text" class="form-control" id="editar-nombre" value="'.$usuario['nombre'].'" data-minlength="0" maxlength="16" required>
											      		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						    							<span id="span-usuario" class="help-block with-errors"></span>
												    </div>
												</div>
												<div id="password-editar" class="form-group has-feedback">
												    <label class="control-label col-sm-3" for="editar-pass">Contraseña</label>
												    <div class="col-sm-9">
												      	<input type="password" class="form-control" id="editar-pass" data-minlength="0" maxlength="16" value="'.$usuario['password'].'" required>
												      	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						    							<span id="span-password" class="help-block with-errors"></span>
												    </div>
												</div>
												<div class="form-group has-feedback">
												    <label class="control-label col-sm-3" for="editar-re-pass">Repetir Contraseña</label>
												    <div class="col-sm-9">
												      	<input type="password" class="form-control" id="editar-re-pass" data-match="#editar-pass" data-match-error="Las contraseñas no coinciden" value="'.$usuario['password'].'" required>
												      	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						    							<span class="help-block with-errors"></span>
												    </div>
												</div>
												<div class="form-group has-feedback">
												    <label class="control-label col-sm-3" for="editar-fecha-nac">Fecha de Nacimiento</label>
												    <div class="col-sm-9">
												    	<div class="input-group input-append date" id="datePicker">
											                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											                <input id="editar-fecha-nac" type="text" class="form-control" name="date" placeholder="AAAA-MM-DD" value="'.$usuario['fecha_nacimiento'].'" required />
										            	</div>
										            	<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
						    							<span class="help-block with-errors"></span>
												    </div>
												</div>
												'.$sexo_usuario.'
												<div class="form-group has-feedback">
												    <label class="control-label col-sm-3" for="editar-url">URL Avatar</label>
												    <div class="col-sm-9">
												      	<input type="text" class="form-control" id="editar-url" value="'.$usuario['url_avatar'].'">
												    </div>
												</div>
												'.$editar_tipo_usuario.'
												<div class="form-group">
													<label class="control-label col-sm-3" for="editar-perfil"></label>
													<div class="col-sm-9">
														<button type="submit" id="editar-perfil" class="btn btn-primary">Editar perfil</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>';
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
    $('#datePicker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: 'today'
    });

    $('#form-editar-perfil').validator({
    	delay: 250,
    	disable: false,
    	errors:{
    		match:'Los datos no coinciden',
    	}
    });

    $('#form-editar-perfil').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   	e.preventDefault();
	 	   	<?php 
	 	   		print "var id =".$id_usuario.";";
	 	   	?>
	 	   	var nickname = $('#editar-nickname').val();
	 	   	var nombre = $('#editar-nombre').val();
	 	   	var password = $('#editar-pass').val();
	 	   	var fecha_nac = $('#editar-fecha-nac').val();
	 	   	var sexo = $('input[name=opciones]:checked', '#form-editar-perfil').val();
	 	   	var url_avatar = $('#editar-url').val();
	 	   	var tipo = $('input[name=opciones-tipo]:checked', '#form-editar-perfil').val();

	 	   	$.ajax({
				type: "POST",
				url: "editar-usuario.php",
				data: "id="+id+"&nickname="+nickname+"&nombre="+nombre+"&password="+password+"&fecha-nac="+fecha_nac+"&sexo="+sexo+"&url-avatar="+url_avatar+"&tipo-usuario="+tipo,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						alert("Se ha editado el perfil satisfactoriamente");
						window.location.replace('perfil.php?id='+id+'');
					}
				}
			});
	 	   
	  	}
	})
    </script>

</body>
</html>