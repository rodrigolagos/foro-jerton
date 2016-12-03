<?php
    include_once("conexion.php");
    session_start();
    $id = $_SESSION['id'];
    $nombre = $_SESSION['nombre'];
    $cargo = $_SESSION['cargo'];
    $nickname = $_SESSION['nickname'];
?>

<nav class="navbar navbar-default navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Jertón</a>
    </div>
    <div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="mensajes.php"><span class="glyphicon glyphicon-envelope"></span></a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user"></span> 
                    <strong><?php echo $nickname; ?></strong>
                    <span style="font-size:10px" class="glyphicon glyphicon-chevron-down"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <div class="navbar-login">
                            <div class="row">
                                <div class="col-xs-4">
                                    <?php
                                    $usuario_query = $mysqli->query("SELECT * FROM USUARIOS WHERE id=".$id."");
                                    $usuario = $usuario_query->fetch_assoc();
                                    if($usuario['url_avatar']!=null){
                                        echo '<img src="'.$usuario['url_avatar'].'" alt="" width="100%">';
                                    }else{
                                        echo    '<p class="text-center">
                                                    <span class="glyphicon glyphicon-user icon-size"></span>
                                                </p>';;
                                    }
                                    ?>
                                </div>
                                <div class="col-xs-8">
                                    <p id="empleado" id-empleado="<?php echo $id; ?>" class="text-left"><strong><?php echo $nombre; ?></strong></p>
                                    <p class="text-left small"><strong>Cargo:</strong> <?php echo $cargo; ?></p>
                                    <p class="text-left">
                                        <a href="perfil.php?id=<?php echo $id; ?>" class="btn btn-primary btn-block btn-sm">Ver Perfil</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="navbar-login navbar-login-session">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p>
                                        <a href="logout.php" class="btn btn-danger btn-block">Cerrar Sesion</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
  </div>
</nav>