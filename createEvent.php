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
    </style>
</head>

<body>
<?php ob_start(); ?>
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
                echo "<li><a href=\"logout.php\">Cerrar sesión de {$nombre}</a></li>";
            } else {
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
            <li><a href="searchEvent.php" class="blue-text text-darken-4">Buscar evento</a></li>
            <li><a href="createEvent.php" class="blue-text text-darken-4">Crear evento</a></li>
        </ul>
    </header>
    <section class="container section scrollspy">
        <div class="row">
            <div class="col s12 m12 l12">
                <?php
                if (isset($_COOKIE['email'])) {   //hay sesión iniciada?
                    $email = $_COOKIE['email'];
                    $nombre = $_COOKIE['nombre'];
                    setcookie('email', $email, time() + 600); //10 mins
                    setcookie('nombre', $nombre, time() + 600);
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
                            }
                        }
                        mysqli_close($conexion);
                    }
                    if (!$interno) {
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
                                    <p class=\"flow-text\">Para poder crear un evento necesitas tener una cuenta interna UPSLP</p>
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
                    }
                    if (!$coordinador) { //Redirigir a registro coordinador
                        echo"
                        <script>
                            setTimeout(function(){
                                window.location.href = 'registerCoordinador.php';
                            }, 2000);
                        </script>
                        ";
                        echo "
                        <div class=\"col s12 m6 l6 offset-m3 offset-l3\">
                            <div class=\"card\">
                                <div class=\"card-content center\">
                                    <p class=\"flow-text\">Para poder crear un evento necesitas estar registrado como coordinador</p>
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
                } else {
                    echo"
                    <script>
                        setTimeout(function(){
                            window.location.href = 'login.html';
                        }, 2000);
                    </script>
                    ";
                    echo "
                    <div class=\"col s12 m6 l6 offset-m3 offset-l3\">
                        <div class=\"card\">
                            <div class=\"card-content center\">
                                <p class=\"flow-text\">Para poder crear un evento necesitas iniciar sesión</p>
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
                }
                ?>
            </div>
        </div>
        <div class="row" id="form" style="display: <?php echo $coordinador ? 'block' : 'none' ?>;">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-image">
                            <img src="img/upslpDark.jpg">
                            <span class="card-title">
                                <h1>Registro de evento</h1>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="createEvent2.php" method="POST">
            <h3>Datos generales</h3>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">event_note</i>
                    <input type="text" id="nombre" name="nombre" required>
                    <label for="nombre">Nombre del evento</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">info</i>
                    <textarea id="info" class="materialize-textarea" name="info" required></textarea>
                    <label for="info">Descripción del evento</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">place</i>
                    <select class="icons" id="lugar" name="lugar" required>
                        <option value="" disabled selected>Selecciona el lugar</option>
                        <?php
                        $conexion = mysqli_connect($host, $dbUser, $dbPass, $database) or die("Error en la conexion: " . mysqli_connect_error());
                        if ($conexion) {
                            mysqli_select_db($conexion, $database) or  die("Problemas en la selec. de BDs");
                            $query = "SELECT * FROM lugares;";
                            if ($registros = mysqli_query($conexion, $query)) {
                                while ($row = $registros->fetch_assoc()) {
                                    $nombreLugar = $row['nombre'];
                                    $img = $row['img'];
                                    $id = $row['id'];
                                    echo "<option value=\"{$id}\" data-icon=\"{$img}\">{$nombreLugar}</option>\n";
                                }
                            }
                            mysqli_close($conexion);
                        } else echo "no jala";
                        ?>
                    </select>
                    <label for="lugar">Lugar del evento</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">star</i>
                    <select class="icons" id="tipoEvento" name="tipoEvento" required>
                        <option value="" disabled selected>Selecciona el tipo de evento</option>
                        <option value="Conferencia">Conferencia</option>
                        <option value="Evento deportivo">Evento deportivo</option>
                        <option value="Evento en línea">Evento en línea</option>
                        <option value="Feria">Feria</option>
                        <option value="Foro">Foro</option>
                        <option value="Masterclass">Masterclass</option>
                    </select>
                    <label for="tipoEvento">Tipo de evento</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">attach_money</i>
                    <input type="number" id="costo" name="costo" required>
                    <label for="costo">Costo del evento</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">people</i>
                    <input type="number" id="cupo" name="cupo" required>
                    <label for="cupo">Cupo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">link</i>
                    <input type="url" id="link" name="link">
                    <label for="link">Liga del evento (Facebook, Zoom, Teams, etc.)</label>
                </div>
            </div>
            <h3>Fechas de evento</h3>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">light_mode</i>
                    <input type="text" class="datepicker" name="inicioEv" id="inicioEv">
                    <label for="inicioEv">Día de inico del evento</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">schedule</i>
                    <input type="text" class="timepicker" name="horaInicioEv" id="horaInicioEv">
                    <label for="horaInicioEv">Hora de inico del evento</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">dark_mode</i>
                    <input type="text" class="datepicker" name="finEv" id="finEv">
                    <label for="finEv">Día de fin del evento</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">schedule</i>
                    <input type="text" class="timepicker" name="horaFinEv" id="horaFinEv">
                    <label for="horaFinEv">Hora de inico del evento</label>
                </div>
            </div>
            <h3>Fechas de registro</h3>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">light_mode</i>
                    <input type="text" class="datepicker" name="inicioReg" id="inicioReg">
                    <label for="inicioReg">Día de inico de registro</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">schedule</i>
                    <input type="text" class="timepicker" name="horaInicioReg" id="horaInicioReg">
                    <label for="horaInicioReg">Hora de inico de registro</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">dark_mode</i>
                    <input type="text" class="datepicker" name="finReg" id="finReg">
                    <label for="finReg">Día de fin de registrol</label>
                </div>
                <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">schedule</i>
                    <input type="text" class="timepicker" name="horaFinReg" id="horaFinReg">
                    <label for="horaFinReg">Hora de fin de registro</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 center">
                    <button class="btn waves-effect  blue darken-4" type="submit" name="action">
                        Crear Evento<i class="material-icons right">event_available</i>
                    </button>
                </div>
            </div>
        </form>
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
            $('.scrollspy').scrollSpy();
            $(".dropdown-trigger").dropdown();
            $('select').formSelect();
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 3 // Creates a dropdown of 3 years to control year
            });
            $('.timepicker').timepicker({
                twelveHour: false
            });
        });
    </script>
</body>

</html>