<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="shortcut icon" href="https://www.upslp.edu.mx/upslp/wp-content/themes/icemagtheme/images/demo/favico.ico" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://kit.fontawesome.com/8c04a359e6.js" crossorigin="anonymous"></script>
    <title>Registrarse | UPSLP</title>
    <style>
        .section {
            padding-top: 4vw;
            padding-bottom: 4vw;
        }

        .video-container {
            margin-bottom: 5%;
        }

        .secondary-content {
            color: #2196f3;
        }

        #nav-log {
            line-height: 65px;
        }

        #drop {
            background-color: transparent;
            box-shadow: none;
        }

        /* label focus color */
        .input-field input:focus+label {
            color: #0d47a1 !important;
        }

        /* label underline focus color */
        .row .input-field input:focus {
            border-bottom: 1px solid #0d47a1 !important;
            box-shadow: 0 1px 0 0 #0d47a1 !important
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <header>
        <div class="navbar-fixed">
            <nav class="nav-wrapper blue darken-4">
                <div class="container">
                    <a href="index.php" class="brand-logo"><img class="responsive-img" src="img/logo.png" style="margin-top: 10%;" id="logonav"></a>
                    <a href="#" class="sidenav-trigger" data-target="mobile-menu">
                        <i class="material-icons">menu</i>
                    </a>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="#">Eventos en línea</a></li>
                        <li><a href="#">Eventos presenciales</a></li>
                        <li><a class='dropdown-trigger btn' href="#" data-target='dropdown1' id="drop"><i class="right material-icons">account_circle</i>
                                <?php
                                if (isset($_COOKIE['email']) && isset($_COOKIE['nombre'])) {
                                    echo strtok($_COOKIE['nombre'], " ");
                                }
                                ?></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!--sidenav-->
        <ul class="sidenav grey lighten-2" id="mobile-menu">
            <li><a href="#">Eventos en línea</a></li>
            <li><a href="#">Eventos presenciales</a></li>
            <li><a href="#">Crear un evento</a></li>
            <li><a href="#">Buscar un evento</a></li>
            <?php
            if(isset($_COOKIE['email']) &&isset($_COOKIE['nombre'])){
                    $nombre = strtok($_COOKIE['nombre'], " ");
                    echo "<li><a href=\"logout.php\">Cerrar sesión de {$nombre}</a></li>";
                }else{
                    echo "<li><a href=\"login.html\">Iniciar sesión</a></li>";
                }
            ?>
        </ul>
        <!--dropdown-->
        <ul id='dropdown1' class='dropdown-content'>
            <?php
            if (isset($_COOKIE['email']) && isset($_COOKIE['nombre'])) {
                echo "<li><a href=\"logout.php\" class=\"blue-text text-darken-4\">Cerrar sesión</a></li>";
            } else {
                echo "<li><a href=\"login.html\" class=\"blue-text text-darken-4\">Iniciar sesión</a></li>";
            }
            ?>
            <li><a href="#" class="blue-text text-darken-4">Buscar evento</a></li>
            <li><a href="createEvent.php" class="blue-text text-darken-4">Crear evento</a></li>
        </ul>
    </header>
    <section class="container section scrollspy">
        <div class="row">
            <div class="col s12 m6 l6 offset-m3 offset-l3">
                <div class="card">
                    <div class="card-content">
                        <?php
                            require("config.php");
                            //print_r($_POST);
                            //print_r($_COOKIE);
                            $conexion = mysqli_connect($host, $dbUser, $dbPass, $database) or die("Error en la conexion: " . mysqli_connect_error());
                            if ($conexion) {
                                $query = "";
                                if(isset($_COOKIE['email'])){
                                    $mensaje = "Bienvenido, {$_COOKIE['nombre']}";
                                }if (isset($_POST['email']) && $_POST['email'] != "" && isset($_POST['pass']) && $_POST['pass'] != "" && isset($_POST['nombre']) && $_POST['nombre'] != ""){
                                    $pass = md5($_POST['pass']);
                                    if(isset($_POST['especial'])){  //si es especial no interno
                                        $query = "INSERT INTO usuarios (email,pass,nombre,admin,interno,especial,matricula,carrera) VALUES ('{$_POST['email']}','{$pass}','{$_POST['nombre']}',0,0,1,'','');";
                                        if(isset($_POST['interno'])){//especial interno
                                            $query = "INSERT INTO usuarios (email,pass,nombre,admin,interno,especial,matricula,carrera) VALUES ('{$_POST['email']}','{$pass}','{$_POST['nombre']}',0,1,1,{$_POST['matricula']},'{$_POST['carrera']}');";
                                        }
                                    }else{  //si no es especial no interno
                                        $query = "INSERT INTO usuarios (email,pass,nombre,admin,interno,especial,matricula,carrera) VALUES ('{$_POST['email']}','{$pass}','{$_POST['nombre']}',0,0,0,'','');";
                                        if(isset($_POST['interno'])){//no especial interno
                                            $query = "INSERT INTO usuarios (email,pass,nombre,admin,interno,especial,matricula,carrera) VALUES ('{$_POST['email']}','{$pass}','{$_POST['nombre']}',0,1,0,{$_POST['matricula']},'{$_POST['carrera']}');";
                                        }
                                    }
                                }
                                mysqli_select_db($conexion, $database) or  die("Problemas en la selec. de BDs<br><br><br><br><br><br>");
                                if(mysqli_query($conexion, $query)){
                                    echo "<h3 class= \"center\">Usuario registrado con éxito<br></h3>";
                                    echo "<p class = \"flow-text\"
                                            <ul>
                                                <li>e-mail: {$_POST['email']}</li>
                                                <li>nombre: {$_POST['nombre']}</li>
                                                <li>contraseña: {$_POST['pass']}</li>
                                            </ul>
                                            </p><br><br><br><br><br>";
                                    setcookie('email', "{$_POST['email']}", time() + 300); //inicia sesión 
                                    setcookie('nombre', "{$_POST['nombre']}", time() + 300);
                                }else{
                                    echo "<h3 class= \"center\">El usuario no fue registrado<br></h3>";
                                    setcookie('email', "{$_POST['email']}", time() - 300); //elimina la cookie 
                                    setcookie('nombre', "{$_POST['nombre']}", time() - 300);
                                }
                                mysqli_close($conexion);
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer -->
    <footer class="page-footer orange darken-2">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h4 class="white-text">Contacto</h4>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="https://www.facebook.com/upslp/" target="_blank"><i class="fab fa-facebook"></i> Universidad Politécnica de San Luis
                                Potosí</a></li>
                        <li><a class="grey-text text-lighten-3" href="https://www.instagram.com/upslp_oficial/" target="_blank"><i class="fab fa-instagram"></i> @upslp_oficial</a></li>
                        <li><a class="grey-text text-lighten-3" href="https://www.youtube.com/c/UPSLPoficial2001" target="_blank"><i class="fab fa-youtube"></i> UPSLP</a></li>
                        <li><a class="grey-text text-lighten-3" href="https://t.me/upslp_oficial" target="_blank"><i class="fab fa-telegram"></i> @UPSLP Oficial</a></li>
                        <li><a class="grey-text text-lighten-3" href="https://api.whatsapp.com/send?phone=5214441887939&text=Hola%2C%20le%20estoy%20contactando%20desde%20la%20p%C3%A1gina%20UPSLP" target="_blank"><i class="fab fa-whatsapp"></i> +52 1 444 188 7939</a></li>
                        <li><a class="grey-text text-lighten-3" href="https://goo.gl/maps/ybYGfU1ePAaJC1Qu7" target="_blank"><i class="fas fa-map-marker-alt"></i> Urbano Villalón #500, Col. La Ladrillera, San Luis Potosí, S.L.P. México, C.P. 78363</a></li>
                    </ul>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h4>Soporte</h4>
                    <ul>
                        <h6>
                            <li><a class="grey-text text-lighten-3" href="faq.html">Preguntas frecuentes</a></li>
                            <li><a class="grey-text text-lighten-3" href="help.html">Solucitud de ayuda</a></li>
                            <li><a class="grey-text text-lighten-3" href="loginAdmin.html">Sitio administrador</a></li>
                        </h6>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright orange darken-3">
            <div class="container center-align"><a class="white-text" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">Universidad Politécnica de San Luis Potosí &copy; 2021</a></div>
        </div>
    </footer>

    <!-- Compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.sidenav').sidenav();
            $('.materialboxed').materialbox();
            $('.tabs').tabs();
            $('.tooltipped').tooltip();
            $('.scrollspy').scrollSpy();
            $(".dropdown-trigger").dropdown();

        });
    </script>
    <script>

    </script>
</body>

</html>