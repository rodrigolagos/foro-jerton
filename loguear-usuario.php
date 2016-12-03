<?php 
	
	session_start();
	include_once("conexion.php");

	$usuario = $_POST['usuario'];
	$password = $_POST['password'];

	$resultado = $mysqli->query("SELECT * FROM Usuarios,TIPOS_URUARIOS WHERE USUARIOS.nickname = '$usuario' AND USUARIOS.password ='$password' AND TIPOS_URUARIOS.id=USUARIOS.tipo_id");

	if($resultado->num_rows > 0){
		while($fila = $resultado->fetch_array()){
			$_SESSION['logged_in'] = true;
			$_SESSION['id'] = $fila[0];
			$_SESSION['nickname'] = $fila[1];
			$_SESSION['nombre'] = $fila[2];
			$_SESSION['cargo'] = $fila[10];
		}
		echo "OK";
	}

?>