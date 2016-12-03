<?php 
	include_once("conexion.php");

	$nickname = $_POST['nickname'];
	
	$resultado = $mysqli->query("SELECT * FROM Usuarios WHERE nickname = '".$nickname."'");

	if($resultado->num_rows > 0){
		echo "OK";
	}
?>