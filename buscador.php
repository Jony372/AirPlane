
<?php
  include "php/conexion.php";

  if (isset($_SESSION['usuario']['id'])) {
    if ($_SESSION['usuario']['tipo'] == "Aeropuerto") {
      header("Location: indexAeropuerto.php");
    }else if ($_SESSION['usuario']['tipo'] == "Aerolinea") {
      header("Location: indexAerolinea.php");
    }
  }else{
    header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="images/airplane_logo.png">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <title>Airplane</title>
    
</head>
<body>

    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #16425b; height: 10vh;">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="images/airplane_logo.png" style="height: 10vh;" alt=""></a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li>
              <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
            </li>
            <?php 
              if ($_SESSION['usuario']['tipo'] == "Administrador") {
                ?>
                <li>
                  <a class="nav-link active" aria-current="page" href="indexAeropuerto.php">Aeropuerto</a>
                </li>
                <li>
                  <a class="nav-link active" aria-current="page" href="indexAerolinea.php">Aerolienea</a>
                </li>
                <?php
              }
            ?>
          </ul>
          <ul class="navbar-nav d-flex" role="search">
            <li class="nav-item">
              <button class="nav-link active" aria-current="page">Perfil</button>
            </li>
            <li class="nav-item">
              <form action="php/cerrar.php" method="post">
                <button class="nav-link active" name="cerrar" aria-current="page" href="">Cerrar sesion</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container py-4 mt-3">
        <div class="row justify-content-center text-center">

          <?php
            $vuelos = $conn->query("SELECT vuelo.id as vID, compañia_vuelo.nombre AS cvn, fecha_salida, hora_salida, tiempo, precioA, precioM, precioN, lugar.ciudad as city, lugar.pais as cntry, lg2.ciudad as c2, lg2.pais as p2 FROM vuelo INNER JOIN compañia_vuelo ON id_compania = compañia_vuelo.ID INNER JOIN aeropuerto ON id_aeropuerto = aeropuerto.ID INNER JOIN lugar ON aeropuerto.id_lugar = lugar.ID INNER JOIN aeropuerto as arp2 ON arp2.id = id_aeropuerto_destino INNER JOIN lugar as lg2 ON lg2.ID = arp2.id_lugar WHERE aeropuerto.id_lugar = '".$_SESSION['vuelo']['origen']."' AND arp2.id_lugar = '".$_SESSION['vuelo']['destino']."' AND fecha_salida = '".$_SESSION['vuelo']['fecha']."' AND vuelo.estado = 'EN ESPERA'");
            foreach ($vuelos as $vuelo){
          ?>
          <div class="container boleto" style="cursor: pointer;" idHora="<?=$vuelo['hora_salida']?>"  idVuelo="<?=$vuelo['vID']?>" pa="<?=$vuelo['precioA']?>" pm="<?=$vuelo['precioM']?>" pn="<?=$vuelo['precioN']?>">
            <h5><?=$vuelo['cvn']?></h5>
            <p style="width: 100%;"><?=$vuelo['city']?>-<?=$vuelo['cntry']?> -------------<?=$vuelo['tiempo']?>------------- <?=$vuelo['c2']?>-<?=$vuelo['p2']?></p>
            <p><?=$vuelo['fecha_salida']?>   <?=$vuelo['hora_salida']?></p>
            <div class="row justify-content-between mx-auto">
              <div class="col-1"><p>Adulto:</p> <p> $<?=$vuelo['precioA']?></p></div>
              <div class="col-1"><p>Menor:</p> <p> $<?=$vuelo['precioM']?></p></div>
              <div class="col-1"><p>Niño:</p> <p> $<?=$vuelo['precioN']?></p></div>
            </div>
            <hr>
          </div>
          <?php
            }
          ?>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script src="js/page/boletos.js"></script>

    
    <!-- Bootstrap -->
</body>
</html>