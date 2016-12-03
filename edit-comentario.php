<?php 
	include_once("conexion.php");

	$comentario = $_POST['comentario'];
	$contenido = $_POST['contenido'];

	$resultado = $mysqli->query("UPDATE COMENTARIOS SET contenido='$contenido' WHERE id='$comentario'");

	if($resultado){
		echo "OK";
	}
?>