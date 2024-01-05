<?php
  include "php/conexion.php";

  if (isset($_SESSION['usuario']['id'])) {
    if ($_SESSION['usuario']['tipo'] == "Usuario") {
      header("Location: index.php");
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
            <li class="nav-item">
              <a class="nav-link active seleccionado" aria-current="page" href="">Inicio</a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="aeropuerto/vuelos.php">Vuelos</a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="aeropuerto/aviones.php">Aviones</a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="aeropuerto/aerolineas.php">Aerolineas</a>
            </li>
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

</body>
</html>