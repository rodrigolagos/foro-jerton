<?php 
	include_once("conexion.php");

	$nombre = $_POST['nombre'];
	$nickname = $_POST['nickname'];
	$pass = $_POST['password'];
	$fecha_nac = $_POST['fecha-nac'];
	$sexo = $_POST['sexo'];
	$url_avatar = $_POST['url-avatar'];

	$resultado = $mysqli->query("INSERT INTO Usuarios (nickname,nombre,password,sexo,fecha_nacimiento,url_avatar,tipo_id) VALUES('$nickname','$nombre','$pass','$sexo','$fecha_nac','$url_avatar',2)");
	if($resultado){
		echo "OK";
	}
?>