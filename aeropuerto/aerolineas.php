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

    <link rel="stylesheet" href="../css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>

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
              <a class="nav-link active" aria-current="page" href="aviones.php">Aviones</a>
            </li>
            <li>
              <a class="nav-link active seleccionado" aria-current="page" href="">Aerolineas</a>
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
      <h1>Aerolineas</h1>
    </div>

    <br>
    <div class="d-flex justify-content-center">
      <div class="form-floating  res mx-3" >
        <select name="aerolineas" id="aerolineas" class="form-select" aria-label="Floating label select example">
          <?php 
            $aerolinea = $conn->query("SELECT compañia_vuelo.* FROM compañia_vuelo WHERE NOT EXISTS ( SELECT 1 FROM aerop_comp WHERE compañia_vuelo.id = aerop_comp.id_comp AND aerop_comp.id_aerop =  '".$_SESSION['usuario']['id_aeropuerto']."')");
            if($aerolinea->rowCount() < 1){
              ?><option value="-1">No hay disponible</option>
              <?php
            }else{
              foreach ($aerolinea as $arl){
              ?>
              <option value="<?=$arl['ID']?>"><?=$arl['Nombre']?></option>
              <?php
              }
            }
          ?>
        </select>
        <label for="aerolineas">Aerolinea</label>
      </div>

      <button class="btn av justify-self-center mx-3" id="addAerolinea">AGREGAR AEROLINEA</button>
    </div>
    
    <div class="container py-4 mt-3">
        <div class="row justify-content-center text-center">
            <table class="table table-sm" id="vuelos">
                <thead>
                    <th>Nombre</th>
                    <th>Aviones</th>
                    <th>Eliminar</th>
                </thead>
                <tbody>
                  <?php
                    $aerolineas = $conn->query("SELECT aerop_comp.ID as cvID, Nombre, aviones FROM compañia_vuelo INNER JOIN aerop_comp ON id_comp = compañia_vuelo.ID WHERE id_aerop = '".$_SESSION['usuario']['id_aeropuerto']."'");
                    foreach ($aerolineas as $aerl){
                  ?>
                  <tr>
                    <td><?=$aerl['Nombre']?></td>
                    <td><?=$aerl['aviones']?></td>
                    <td><button class="btn btn-danger eliminar" idArl="<?= $aerl['cvID']?>">Eliminar</button></td>
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

    <script src="../js/page/aerolineas.js"></script>
    <script>
    $(document).ready(function(e) {
      $('#vuelos').DataTable();
    });
    </script>

</body>
</html>