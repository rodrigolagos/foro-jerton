<?php
	include_once("conexion.php");
	session_start();
	$cargo = $_SESSION['cargo'];
	$id_usuario = $_SESSION['id'];
	if($_GET['id']==null){
		header("Location: index.php");
	}
	else{
		$id_tema = $_GET['id'];
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

	$tema_query = $mysqli->query("SELECT * FROM TEMAS WHERE id=".$id_tema."");
	$tema = $tema_query->fetch_assoc();

	$id_categoria = $tema['categoria_id'];
	$categoria_query = $mysqli->query("SELECT * FROM CATEGORIAS WHERE id=".$id_categoria."");
	$categoria = $categoria_query->fetch_assoc();

	?>

	<div class="container">
		<ol class="breadcrumb">
		 	<li><a href="index.php">Home</a></li>
		 	<li><a href="categoria.php?id=<?php echo $categoria['id']; ?>"><?php echo $categoria['titulo']; ?></a></li>
		  	<li><a href="tema.php?id=<?php echo $tema['id']; ?>"><?php echo $tema['titulo']; ?></a></li>
		  	<li class="active">Editar tema</li>
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
			include_once("formulario-editar-tema.php");
		}

	?>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/validator.min.js"></script>
    <script type="text/javascript">

    $('#form-editar-tema').validator({
    	delay: 250,
    	disable: false,
    });
    
    $('#form-editar-tema').validator().on('submit', function (e) {
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
							var id_categoria = '$id_categoria';
							var id_tema = $id_tema;"; 
	 	   	?>

	 	   	$.ajax({
				type: "POST",
				url: "edit-tema.php",
				data: "titulo="+titulo+"&tipo="+tipo+"&contenido="+contenido+"&id-tema="+id_tema,
				dataType:"html",
				success: function(data) 
				{
					if(data=="OK"){
						alert("Se ha editado el nuevo tema satisfactoriamente");
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