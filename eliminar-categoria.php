<?php 
	include_once("conexion.php");

	$categoria = $_POST['categoria'];

	$eliminar_cat = $mysqli->query("DELETE FROM CATEGORIAS WHERE id=".$categoria."");
	if($eliminar_cat){
		echo "OK";
	}
?>