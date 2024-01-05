<?php
  include "../php/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/airplane_logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Airplane</title>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #16425b; height: 10vh;">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"><img src="../images/airplane_logo.png" style="height: 10vh;" alt=""></a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../indexAeropuerto.php">Inicio</a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="vuelos.php">Vuelos</a>
            </li>
            <li>
              <a class="nav-link active seleccionado" aria-current="page" href="aviones.php">Aviones</a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="aerolineas.php">Aerolineas</a>
            </li>
          </ul>
          <ul class="navbar-nav d-flex" role="search">
            <li class="nav-item">
              <button class="nav-link active" aria-current="page">Perfil</button>
            </li>
            <li class="nav-item">
              <form action="../php/cerrar.php" method="post">
                <button class="nav-link active" name="cerrar" aria-current="page" href="">Cerrar sesion</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="vTop">
      <h1>Aviones</h1>
    </div>

    <br>
    
    <div class="container py-4 mt-3">
        <div class="row justify-content-center text-center">
            <table class="table table-sm" id="vuelos">
                <thead>
                    <th>SN</th>
                    <th>Capacidad</th>
                    <th>Aerolinea</th>
                    <th style="width: 15%">Disponibilidad</th>
                </thead>
                <tbody>
                  <?php
                    $aviones = $conn->query("SELECT SN, Capacidad, Nombre, disponible FROM avion INNER JOIN compañia_vuelo ON id_comp_vuelo = compañia_vuelo.ID WHERE id_comp_vuelo IN(SELECT compañia_vuelo.ID FROM compañia_vuelo INNER JOIN aerop_comp ON id_comp = compañia_vuelo.ID WHERE id_aerop = '".$_SESSION['usuario']['id_aeropuerto']."') AND avion.estado = 1");
                    foreach ($aviones as $avion){
                  ?>
                  <tr>
                    <td><?= $avion['SN']?></td>
                    <td><?=$avion['Capacidad']?></td>
                    <td><?=$avion['Nombre']?></td>
                    <?php
                    $dis = "RED";
                    if ($avion['disponible'] = 1) {
                        $dis = "GREEN";
                    }
                    ?>
                    <td style="background-color: <?= $dis?>"></td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function(e) {
      $('#vuelos').DataTable();
    });
    </script>
</body>
</html>