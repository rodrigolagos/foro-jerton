<?php 
	include_once("conexion.php");

	$comentario = $_POST['comentario'];
	$id_usuario = $_POST['id-usuario'];
	$id_tema = $_POST['id-tema'];

	$resultado = $mysqli->query("INSERT INTO Comentarios (contenido,usuario_id,tema_id) VALUES('$comentario','$id_usuario','$id_tema')");
	if($resultado){
		echo "OK";
	}
?>