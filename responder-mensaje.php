<?php 
	include_once("conexion.php");

	$id_envia = $_POST['id-envia'];
	$id_recibe = $_POST['id-recibe'];
	$asunto = $_POST['asunto'];
	$contenido = $_POST['contenido'];

	$resultado = $mysqli->query("INSERT INTO MENSAJES (asunto,contenido,id_envia,id_recibe) VALUES('$asunto','$contenido','$id_envia','$id_recibe')");
	if($resultado){
		echo "OK";
	}
?>