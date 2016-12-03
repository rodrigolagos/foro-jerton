<?php 
	include_once("conexion.php");

	$titulo = $_POST['titulo'];
	$tipo = $_POST['tipo'];
	$contenido = $_POST['contenido'];
	$id_tema = $_POST['id-tema'];

	$resultado = $mysqli->query("UPDATE TEMAS SET titulo='$titulo',contenido='$contenido',tipo='$tipo' WHERE id=$id_tema");

	if($resultado){
		echo "OK";
	}
?>