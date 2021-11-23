<?php
if(isset($_COOKIE['admin'])){
    $email = $_COOKIE['email'];
    $nombre = $_COOKIE['nombre'];
    setcookie('email', $email, time() + 600); //10 mins
    setcookie('nombre', $nombre, time() + 600);
    setcookie('admin', true, time() + 600);
    require('../config.php');
    require('../fpdf/fpdf.php');
    $conexion = mysqli_connect($host, $dbUser, $dbPass, $database) or die("Error en la conexion: " . mysqli_connect_error());
    if($conexion){
        mysqli_select_db($conexion, $database) or  die("Problemas en la selec. de BDs");
        $id = $_GET['idEvento'];
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->Image('../img/logoog.png',15,15,35,15,'PNG','');
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->Cell(200, 35, 'Asistencia de evento', 0, 1, 'C', 0);
        //$pdf->Cell(30, 10, "", 0, 1, 'C', 0);
        //$pdf->Cell(30, 10, "", 0, 1, 'C', 0);
        $pdf->SetFont('Arial', 'I', 16);
        $query = "SELECT * FROM eventos WHERE id = {$id};";
        $registros = mysqli_query($conexion, $query);
        while ($row = $registros->fetch_assoc()) {
            $pdf->Cell(0,10,"{$row['nombre']}",0,0,'C',0);
        }
        $query = "SELECT * FROM usuarios INNER JOIN asistentes ON usuarios.email = asistentes.usuario AND asistentes.evento = {$id};";
        $registros = mysqli_query($conexion, $query);
        $y = 60;
        $pdf->SetX(100);
        $pdf->SetY($y);
        $pdf->Cell(90, 10,"Usuario", 1, 0, 'C', 0);
        $pdf->Cell(100, 10,"Nombre", 1, 0, 'C', 0);
        $y = $y + 10;
        $pdf->SetY($y);
        while ($row = $registros->fetch_assoc()) {
            $pdf->Cell(90, 10, $row['email'], 1, 0, 'L', 0);
            $pdf->Cell(100, 10, utf8_decode($row['nombre']), 1, 0, 'L', 0);
            $y = $y + 10;
            $pdf->SetY($y);
        }
        mysqli_close($conexion);
    }    
    $pdf->Output();
}else{
    echo "
                <script>
                setTimeout(function(){
                window.location.href = 'loginAdmin.php';
                }, 2000);
                </script>
                            ";
}
?>