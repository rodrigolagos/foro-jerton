<?php 
	include_once("conexion.php");

	$comentario = $_POST['comentario'];

	$eliminar_comentario = $mysqli->query("DELETE FROM COMENTARIOS WHERE id=".$comentario."");
	if($eliminar_comentario){
		echo "OK";
	}
?>