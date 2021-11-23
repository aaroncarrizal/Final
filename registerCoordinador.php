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
    <title>Registro Coordinador | UPSLP</title>
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
                        <li><a href="searchEvent.php?enLinea=true">Eventos en línea</a></li>
                        <li><a href="searchEvent.php?enLinea=false">Eventos presenciales</a></li>
                        <li><a class='dropdown-trigger btn' href="#" data-target='dropdown1' id="drop"><i class="right material-icons">account_circle</i>
                                <?php
                                if (isset($_COOKIE['email']) && isset($_COOKIE['nombre'])) {
                                    $email = $_COOKIE['email'];
                                    $nombre = $_COOKIE['nombre'];
                                    setcookie('email', $email, time() + 300); //5 mins
                                    setcookie('nombre', $nombre, time() + 300);
                                    echo strtok($_COOKIE['nombre'], " ");
                                }
                                ?></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!--sidenav-->
        <ul class="sidenav grey lighten-2" id="mobile-menu">
            <li><a href="searchEvent.php?enLinea=true">Eventos en línea</a></li>
            <<li><a href="searchEvent.php?enLinea=false">Eventos presenciales</a></li>
            <li><a href="createEvent.php">Crear un evento</a></li>
            <li><a href="searchEvent.php">Buscar un evento</a></li>
            <?php
            if (isset($_COOKIE['email']) && isset($_COOKIE['nombre'])) {
                $nombre = strtok($_COOKIE['nombre'], " ");
                echo "<li><a href=\"logout.php\">Cerrar sesión de {$nombre}</a></li>
                        <li><a href=\"registerFiscales.php\">Registrar datos fiscales</a></li>";
            } else {
                echo "<li><a href=\"login.html\">Iniciar sesión</a></li>";
            }
            ?>
        </ul>
        <!--dropdown-->
        <ul id='dropdown1' class='dropdown-content'>
            <?php
            if (isset($_COOKIE['email']) && isset($_COOKIE['nombre'])) {
                echo "<li><a href=\"logout.php\" class=\"blue-text text-darken-4\">Cerrar sesión</a></li>
                <li><a href=\"registerFiscales.php\" class=\"blue-text text-darken-4\">Registrar datos fiscales</a></li>";
            } else {
                echo "<li><a href=\"login.html\" class=\"blue-text text-darken-4\">Iniciar sesión</a></li>";
            }
            ?>
            <li><a href="searchEvent.php" class="blue-text text-darken-4">Buscar evento</a></li>
            <li><a href="createEvent.php" class="blue-text text-darken-4">Crear evento</a></li>
        </ul>
    </header>
    <section class="container section scrollspy">
        <div class="row">
            <div class="col s12 m12 l12">
                <?php
                if (isset($_COOKIE['email'])) {   //hay sesión iniciada?
                    $interno = false;
                    $coordinador = false;
                    require("config.php");
                    $email = $_COOKIE['email'];
                    $conexion = mysqli_connect($host, $dbUser, $dbPass, $database) or die("Error en la conexion: " . mysqli_connect_error());
                    if ($conexion) {
                        mysqli_select_db($conexion, $database) or  die("Problemas en la selec. de BDs");
                        $query = "SELECT * FROM usuarios WHERE email = '$email' AND interno = true;";
                        if ($registros = mysqli_query($conexion, $query)) {
                            $totalReg = mysqli_num_rows($registros);
                            if ($totalReg == 1) {
                                $interno = true;
                            } else {
                            }
                        }
                        mysqli_close($conexion);
                    }
                    if (!$interno) {
                        echo "<script>$('#form').hide()</script>";
                        echo"
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'index.php';
                                }, 2000);
                            </script>
                            ";
                        echo "
                            <div class=\"col s12 m6 l6 offset-m3 offset-l3\">
                                <div class=\"card\">
                                    <div class=\"card-content center\">
                                        <p class=\"flow-text\">Para poder registrarte como coordinador necesitas tener una cuenta interna UPSLP</p>
                                        <i class=\"large material-icons\">sentiment_very_dissatisfied</i><br><br>
                                        <div class=\"preloader-wrapper big active\">
                                            <div class=\"spinner-layer spinner-blue-only\">
                                                <div class=\"circle-clipper left\">
                                                    <div class=\"circle\"></div>
                                                </div>
                                                <div class=\"gap-patch\">
                                                    <div class=\"circle\"></div>
                                                </div>
                                                <div class=\"circle-clipper right\">
                                                    <div class=\"circle\"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                            die();
                    } else {
                        //echo "interno";
                        $conexion = mysqli_connect($host, $dbUser, $dbPass, $database) or die("Error en la conexion: " . mysqli_connect_error());
                        if ($conexion) {
                            mysqli_select_db($conexion, $database) or  die("Problemas en la selec. de BDs");
                            $query = "SELECT * FROM coordinadores WHERE usuario = '{$email}';";
                            if ($registros = mysqli_query($conexion, $query)) {
                                $totalReg = mysqli_num_rows($registros);
                                if ($totalReg == 1) {
                                    $coordinador = true;
                                }
                            }
                        }
                        if (!$coordinador) { //Mostrar form de registro
                            //echo "<script>\$(document).ready(function() {\$('#form').show();});</script>";
                        } else { //es interno y coordinador
                            echo "<script>$('#form').hide()</script>";
                            echo"
                                <script>
                                    setTimeout(function(){
                                        window.location.href = 'index.php';
                                    }, 2000);
                                </script>
                                ";
                            echo "
                                <div class=\"col s12 m6 l6 offset-m3 offset-l3\">
                                    <div class=\"card\">
                                        <div class=\"card-content center\">
                                            <p class=\"flow-text\">Ya estas registrado como coordinador</p>
                                            <i class=\"large material-icons\">sentiment_very_dissatisfied</i><br><br>
                                            <div class=\"preloader-wrapper big active\">
                                                <div class=\"spinner-layer spinner-blue-only\">
                                                    <div class=\"circle-clipper left\">
                                                        <div class=\"circle\"></div>
                                                    </div>
                                                    <div class=\"gap-patch\">
                                                        <div class=\"circle\"></div>
                                                    </div>
                                                    <div class=\"circle-clipper right\">
                                                        <div class=\"circle\"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                        }
                    }
                }
                ?>
            </div>
        </div>
        <div class="row" id="form">
            <div class="col s12 m6 l6 offset-m3 offset-l3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center" style="margin-top: 2vw;"><i class="large material-icons">admin_panel_settings</i>
                            <h3 style="margin-top: 0;">Registrarse como coordinador</h3>
                        </span>
                        <!--form-->
                        <form action="registerCoordinador2.php" method="POST">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">email</i>
                                    <input type="email" id="email" name="email" required>
                                    <label for="email">Correo electrónico de contacto</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">phone</i>
                                    <input type="tel" id="phone" name="phone" required>
                                    <label for="phone">Télefono de contacto</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 center">
                                    <button class="btn waves-effect  blue darken-4" type="submit" name="action">
                                        Registrarse<i class="material-icons right">admin_panel_settings</i>
                                    </button>
                                </div>
                            </div>
                        </form>
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
            $('#form').show();
        });
    </script>
    <script>

    </script>
</body>

</html>