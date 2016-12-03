<?php 
	include_once("conexion.php");

	$tema = $_POST['tema'];

	$eliminar_tema = $mysqli->query("DELETE FROM TEMAS WHERE id=".$tema."");
	if($eliminar_tema){
		echo "OK";
	}
?>