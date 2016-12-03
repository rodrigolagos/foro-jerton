<?php 
	session_start();
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
		if($_SESSION['logged_in']==false){
			include_once("panel-publico.php");
		}else{
			include_once("panel-total.php");
		}

	?>

	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title" id="myModalLabel">¿Seguro que deseas eliminar la categoría?</h4>
				</div>
				<div class="modal-body">
					Al eliminar la categoría se eliminarán todos los temas y comentarios asociados a ésta.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-danger btn-ok-eliminar-cat">Eliminar</button>
				</div>
			</div>
		</div>
	</div>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script>
		$('body').on("click", ".btn-eliminar-cat", function (){
			var categoria = $(this).attr('cat');
			$(".btn-ok-eliminar-cat").unbind().click(function(){
				$.ajax({
					type: "POST",
					url: "eliminar-categoria.php",
					data: "categoria="+categoria,
					dataType:"html",
					success: function(data) 
					{
					 	if(data=="OK"){
					 		alert("categoria eliminada correctamente");
					 		window.location.replace("index.php");
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