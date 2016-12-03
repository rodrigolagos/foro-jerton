<?php 
	include_once("conexion.php");

	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$nickname = $_POST['nickname'];
	$pass = $_POST['password'];
	$fecha_nac = $_POST['fecha-nac'];
	$sexo = $_POST['sexo'];
	$url_avatar = $_POST['url-avatar'];
	$tipo = $_POST['tipo-usuario'];

	if($tipo==undefined){
		$resultado = $mysqli->query("UPDATE Usuarios SET nombre='$nombre',password='$pass',sexo=$sexo,fecha_nacimiento='$fecha_nac',url_avatar='$url_avatar' WHERE id=$id");
	}else{
		$resultado = $mysqli->query("UPDATE Usuarios SET nombre='$nombre',password='$pass',sexo=$sexo,fecha_nacimiento='$fecha_nac',url_avatar='$url_avatar',tipo_id=$tipo WHERE id=$id");
	}

	
	if($resultado){
		echo "OK";
		session_start();
		if($id==$_SESSION['id']){
			$_SESSION['nombre']=$nombre;
			if($tipo!=undefined){
				if($tipo==0){
					$_SESSION['cargo']='Administrador';
				}else if($tipo==1){
					$_SESSION['cargo']='Moderador';
				}else{
					$_SESSION['cargo']='Usuario';
				}
			}
		}
	}
?>