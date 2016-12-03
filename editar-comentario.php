<?php
	include_once("conexion.php");
	session_start();
	$cargo = $_SESSION['cargo'];
	$id_usuario = $_SESSION['id'];
	if($_GET['id']==null){
		header("Location: index.php");
	}
	else{
		$id_comentario = $_GET['id'];
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

	$comentario_query = $mysqli->query("SELECT * FROM COMENTARIOS WHERE id=".$id_comentario."");
	$comentario = $comentario_query->fetch_assoc();

	$tema_comentario = $comentario['tema_id'];

	$tema_query = $mysqli->query("SELECT * FROM TEMAS WHERE id=".$comentario['tema_id']."");
	$tema = $tema_query->fetch_assoc();

	$categoria_query = $mysqli->query("SELECT * FROM CATEGORIAS WHERE id=".$tema['categoria_id']."");
	$categoria = $categoria_query->fetch_assoc();

	?>

	<div class="container">
		<ol class="breadcrumb">
		 	<li><a href="index.php">Home</a></li>
		 	<li><a href="categoria.php?id=<?php echo $categoria['id']; ?>"><?php echo $categoria['titulo']; ?></a></li>
		  	<li><a href="tema.php?id=<?php echo $tema['id']; ?>"><?php echo $tema['titulo']; ?></a></li>
		  	<li class="active">Editar comentario</li>
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
			include_once("formulario-editar-comentario.php");
		}

	?>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script type="text/javascript">

    $('#form-editar-comentario').validator({
    	delay: 250,
    	disable: false,
    });
    
    $('#form-editar-comentario').validator().on('submit', function (e) {
	  	if (e.isDefaultPrevented()){
	 	} else {
	 	   	e.preventDefault();
	 	   	<?php
				print "var id_tema = $tema_comentario;";
			?>
	 	   	var comentario = $('.btn-editar-comentario').attr('coment');
	 	   	var contenido = $('#contenido').val();

	 	   	$.ajax({
				type: "POST",
				url: "edit-comentario.php",
				data: "contenido="+contenido+"&comentario="+comentario,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						alert("Se ha editado correctamente el comentario.");
						window.location.replace('tema.php?id='+id_tema);
					}else{
						alert(data);
					}
				}
			});
	 	   
	  	}
	})

    </script>



</body>
</html>