<?php
	include_once("conexion.php");
	session_start();
	$cargo = $_SESSION['cargo'];
	if($_GET['id']==null){
		header("Location: index.php");
	}
	else{
		$id_categoria = $_GET['id'];
		$existe_categoria = $mysqli->query("SELECT * FROM CATEGORIAS WHERE id=".$id_categoria."");
		if(!$existe_categoria->num_rows > 0){
			header("Location: index.php");
		}
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
	$titulo = $resultado->fetch_assoc();

	?>

	<div class="container">
		<ol class="breadcrumb">
		 	<li><a href="index.php">Home</a></li>
		  	<li class="active"><?php echo $titulo['titulo']; ?></li>
		</ol>

		<div class="page-header titulo-categoria">
			<h3><?php echo $titulo['titulo']; ?></h3>
		</div>

		<a href="crear-tema.php?categoria=<?php echo $id_categoria; ?>"><button id="nuevo-tema" type="button" class="btn btn-primary">Nuevo Tema</button></a>
	</div>

	<?php 
		if($_SESSION['logged_in']==false){
			include_once("panel-temas-publicos.php");
		}else{
			include_once("panel-temas-total.php");
		}
	?>

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

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script>
		$('body').on("click", ".btn-eliminar-tema", function (){
			<?php
				print "var id_categoria = $id_categoria;";
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
	</script>



</body>
</html>