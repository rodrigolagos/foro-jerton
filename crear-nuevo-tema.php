<?php 
	include_once("conexion.php");

	$titulo = $_POST['titulo'];
	$tipo = $_POST['tipo'];
	$contenido = $_POST['contenido'];
	$id_usuario = $_POST['id-usuario'];
	$id_categoria = $_POST['id-categoria'];

	$resultado = $mysqli->query("INSERT INTO Temas (titulo,contenido,tipo,usuario_id,categoria_id) VALUES('$titulo','$contenido',$tipo,'$id_usuario','$id_categoria')");
	$id_tema_creado = $mysqli->insert_id;
	if($resultado){
		echo "OK,".$id_tema_creado;
	}
?>