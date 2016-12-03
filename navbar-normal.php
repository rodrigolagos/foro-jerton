<nav class="navbar navbar-default navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Jertón</a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <?php if(basename($_SERVER['PHP_SELF'])=='registrarse.php'){
                    echo '<li class="active"><a href="registrarse.php"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
                        <li><a href="iniciar-sesion.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>';
                    }else{
                        if(basename($_SERVER['PHP_SELF'])=='iniciar-sesion.php'){
                            echo '<li><a href="registrarse.php"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
                                <li class="active"><a href="iniciar-sesion.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>';
                        }else{
                            echo '<li><a href="registrarse.php"><span class="glyphicon glyphicon-user"></span> Registrarse</a></li>
                                 <li><a href="iniciar-sesion.php"><span class="glyphicon glyphicon-log-in"></span> Iniciar Sesión</a></li>';
                        }
                    } ?>
            </ul>
        </div>
    </div>
</nav>