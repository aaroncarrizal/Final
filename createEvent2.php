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
    <script src="js/materializedatetimepicker.js"></script>
    <script src="https://kit.fontawesome.com/8c04a359e6.js" crossorigin="anonymous"></script>
    <title>Crear Evento | UPSLP</title>
    <style>
        .section {
            padding-top: 2vw;
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
            box-shadow: 0 1px 0 0 #0d47a1 !important;
        }

        .material-icons.active {
            color: #0d47a1 !important;
        }

        .switch label input[type=checkbox]:checked+.lever:after {
            background-color: #0d47a1 !important;
        }

        .switch label input[type=checkbox]:checked+.lever {
            background-color: #1976d2 !important;
        }

        ul.dropdown-content.select-dropdown li span {
            color: #0d47a1;
            /* no need for !important :) */
        }
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
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
            <div class="col s12 m6 l6 offset-m3 offset-l3">
                <div class="card">
                    <div class="card-content">
                        <?php
                        if (isset($_COOKIE['nombre']) && isset($_COOKIE['email'])) {
                            if (
                                isset($_POST['nombre']) && isset($_POST['info']) && isset($_POST['lugar']) && isset($_POST['tipoEvento']) && isset($_POST['costo']) && isset($_POST['cupo']) && isset($_POST['inicioEv']) && isset($_POST['horaInicioEv']) && isset($_POST['finEv']) && isset($_POST['horaFinEv']) && isset($_POST['inicioReg']) && isset($_POST['horaInicioReg']) && isset($_POST['finReg']) && isset($_POST['horaFinReg']) &&
                                $_POST['nombre'] != '' && $_POST['info'] != '' && $_POST['lugar'] != '' && $_POST['tipoEvento'] != '' && $_POST['costo'] != '' && $_POST['cupo'] != '' && $_POST['inicioEv'] != '' && $_POST['horaInicioEv'] != '' && $_POST['finEv'] != '' && $_POST['horaFinEv'] != '' && $_POST['inicioReg'] != '' && $_POST['horaInicioReg'] != '' && $_POST['finReg'] != '' && $_POST['horaFinReg'] != ''
                            ) {
                                //print_r($_POST);
                                require("config.php");
                                $conexion = mysqli_connect($host, $dbUser, $dbPass, $database) or die("Error en la conexion: " . mysqli_connect_error());
                                mysqli_select_db($conexion, $database) or  die("Problemas en la selec. de BDs");
                                //$link = '';
                                $inicioEv = $_POST['inicioEv'] . ' ' . $_POST['horaInicioEv'] . ':00';
                                $finEv = $_POST['finEv'] . ' ' . $_POST['horaFinEv'] . ':00';
                                $inicioReg = $_POST['inicioReg'] . ' ' . $_POST['horaInicioReg'] . ':00';
                                $finReg = $_POST['finReg'] . ' ' . $_POST['horaFinReg'] . ':00';//yyyy-mm-dd hh:mm:00
                                if (isset($_POST['link'])) {
                                    $link = $_POST['link'];
                                } else $link = '';

                                //checar id coordinador
                                $query = "SELECT * FROM coordinadores WHERE usuario = '{$_COOKIE['email']}';";
                                if ($registros = mysqli_query($conexion, $query)) {
                                    $totalReg = mysqli_num_rows($registros);
                                    if ($totalReg == 1) {
                                        $tupla = mysqli_fetch_array($registros);
                                        $coordinador = $tupla['id'];
                                    }else echo"\nerror coordinador";
                                }

                                $query = "INSERT INTO eventos (nombre,lugar,coordinador,inicioEv,finEv,inicioReg,finReg,cupo,info,costo,tipo,link) 
                                VALUES ('{$_POST['nombre']}',{$_POST['lugar']},{$coordinador},'{$inicioEv}','{$finEv}','{$inicioReg}', '{$finReg}',
                                {$_POST['cupo']},'{$_POST['info']}',{$_POST['costo']}, '{$_POST['tipoEvento']}','{$link}' );";
                                //echo $query;
                                if (mysqli_query($conexion, $query)) {
                                    echo "<h3 class=\"center\">Registrado con éxito</h3>";
                                }else echo "\nerror insert". mysqli_connect_error();
                                mysqli_close($conexion);
                            }
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
                            <li><a class="grey-text text-lighten-3" href="faq.php">Preguntas frecuentes</a></li>
                            <li><a class="grey-text text-lighten-3" href="help.php">Solucitud de ayuda</a></li>
                            <li><a class="grey-text text-lighten-3" href="admin/loginAdmin.html">Sitio administrador</a></li>
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
            $('.scrollspy').scrollSpy();
            $(".dropdown-trigger").dropdown();
            $('select').formSelect();
        });
    </script>
    <script>

    </script>
</body>

</html>