<?php 
	include_once("conexion.php");

	$id_envia = $_POST['id-envia'];
	$id_recibe = $_POST['id-recibe'];
	$asunto = $_POST['asunto'];
	$contenido = $_POST['contenido'];

	$destinatario_query = $mysqli->query("SELECT * FROM USUARIOS WHERE nickname='$id_recibe'");
	$destinatario = $destinatario_query->fetch_assoc();
	$id_destinatario = $destinatario['id'];

	$resultado = $mysqli->query("INSERT INTO MENSAJES (asunto,contenido,id_envia,id_recibe) VALUES('$asunto','$contenido','$id_envia','$id_destinatario')");
	if($resultado){
		echo "OK";
	}
?>