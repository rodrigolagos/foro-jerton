<?php 
	include_once("conexion.php");

	$mensaje = $_POST['mensaje'];

	$resultado = $mysqli->query("UPDATE MENSAJES SET estado=1 WHERE id=$mensaje");

	if($resultado){
		echo "OK";
	}
?>