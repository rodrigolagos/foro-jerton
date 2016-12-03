<?php
	include_once("conexion.php");
	session_start();
	$cargo = $_SESSION['cargo'];
	$id_usuario = $_SESSION['id'];
	if($_GET['categoria']==null){
		header("Location: index.php");
	}
	else{
		$id_categoria = $_GET['categoria'];
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
	<?php 
	include_once("header.php");

	$resultado = $mysqli->query("SELECT * FROM CATEGORIAS WHERE id=".$id_categoria."");
	$categoria = $resultado->fetch_assoc();

	?>

	<div class="container">
		<ol class="breadcrumb">
		 	<li><a href="index.php">Home</a></li>
		  	<li><a href="categoria.php?id=<?php echo $id_categoria; ?>"><?php echo $categoria['titulo']; ?></a></li>
		  	<li class="active">Crear Tema</li>
		</ol>
	</div>

	<?php
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if($_SESSION['logged_in']==false){
			echo 	'<div class="container">
						<h3 style="text-align: center;">Para poder crear un tema debes estar registrado.</h3>
						<h5 style="text-align: center;"><a class="btn btn-link" href="iniciar-sesion.php?ref='.$actual_link.'">Inicia sesión</a> o <a class="btn btn-link" href="registrarse.php">Resgistrate</a></h5>
					</div>';
		}else{
			include_once("formulario-crear-tema.php");
		}

	?>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script type="text/javascript">

    $('#form-crear-tema').validator({
    	delay: 250,
    	disable: false,
    	errors:{
    		match:'Los datos no coinciden',
    	}
    });

    
    $(".form").on("keyup", "#titulo", function(){
    	if($('#titulo').val().length==45){
    		$("#span-titulo").html("Debe tener menos de 45 caracteres");
    	}else{
    		$("#span-titulo").html("");
    	}
	});
    
    $('#form-crear-tema').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   	e.preventDefault();
	 	   	var titulo = $('#titulo').val();
	 	   	if ($('#tipo').is(":checked")){
				var tipo = 0;
			}else{
				var tipo = 1;
			}
	 	   	var contenido = $('#contenido').val();
	 	   	<?php print 	"var id_usuario = '$id_usuario';
							var id_categoria = '$id_categoria';"; 
	 	   	?>

	 	   	$.ajax({
				type: "POST",
				url: "crear-nuevo-tema.php",
				data: "titulo="+titulo+"&tipo="+tipo+"&contenido="+contenido+"&id-usuario="+id_usuario+"&id-categoria="+id_categoria,
				dataType:"html",
				success: function(data) 
				{
					var datos = data.split(',');

					if(datos[0]=="OK"){
						alert("Se ha creado el nuevo tema satisfactoriamente");
						//Aquí falta redireccionar al tema recien creado, no al index *************ARREGLAR
						//*********
						//**************
						//*************ARREGLAR********************************
						window.location.replace('tema.php?id='+datos[1]);
						//Aquí falta redireccionar al tema recien creado, no al index *************ARREGLAR
						//*********
						//**************
						//*************ARREGLAR********************************
					}
				}
			});
	 	   
	  	}
	})

    </script>



</body>
</html>