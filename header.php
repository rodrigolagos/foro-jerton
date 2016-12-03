<?php 
	session_start();
?>

<header>
	<?php 
	if($_SESSION['logged_in']){
		include_once('navbar-loggedin.php');
	}else{
		include_once('navbar-normal.php');
	}
	?>
</header>