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
              <a class="nav-link active seleccionado" aria-current="page" href="vuelos.php">Vuelos</a>
            </li>
            <li>
              <a class="nav-link active" aria-current="page" href="aviones.php">Aviones</a>
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
      <h1>Vuelos</h1>
    </div>
    
    <br>
    <div class="d-flex justify-content-center">
      <button class="btn av justify-self-center" data-bs-toggle="modal" data-bs-target="#addVuelo">AGREGAR VUELO</button>
    </div>
    
    <div class="container py-4 mt-3">
      <div class="row justify-content-center text-center">
        <table class="table table-sm" id="vuelos">
          <thead>
            <th>Fecha de salida</th>
            <th>Hora de salida</th>
            <th>Aeropuerto destino</th>
            <th>Ciudad destino</th>
            <th>Estado</th>
            <th>Eliminar</th>
            <th>Editar</th>
          </thead>
          <tbody>
            <?php
              $col = "GREEN";
              $vuelos = $conn->query("SELECT vuelo.ID as vID, fecha_salida, hora_salida, ciudad, nombre, estado FROM vuelo INNER JOIN aeropuerto ON id_aeropuerto_destino = aeropuerto.ID INNER JOIN lugar ON id_lugar = lugar.ID WHERE vuelo.id_aeropuerto = '".$_SESSION['usuario']['id_aeropuerto']."'");
              foreach ($vuelos as $vuelo){
                $col = "GREEN";
                if ($vuelo['estado'] == "CANCELADO") {
                  $col = "RED";
                }else if($vuelo['estado'] == "EN VUELO"){
                  $col = "YELLOW";
                }else if ($vuelo['estado'] == "FINALIZADO") {
                  $col = "CYAN";
                }
            ?>
            <tr>
              <td><?=$vuelo['fecha_salida']?></td>
              <td><?=$vuelo['hora_salida']?></td>
              <td><?=$vuelo['nombre']?></td>
              <td><?=$vuelo['ciudad']?></td>
              <td style="background-color: <?=$col?>;"><?=$vuelo['estado']?></td>
              <td><button class="btn btn-warning editar" isCancel="<?=$vuelo['estado']?>"  idVuelo="<?= $vuelo['vID']?>">Editar</button></td>
              <td><button class="btn btn-danger eliminar" isCancel="<?=$vuelo['estado']?>" idVuelo="<?= $vuelo['vID']?>">Cancelar</button></td>
            </tr>
            <?php
              }
              ?>
          </tbody>
        </table>
      </div>
    </div>
          
    <!-- MODAL AGREGAR-->
    <div class="modal fade" id="addVuelo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-floating mb-3">
              <select class="form-select" name="avion" id="avion" aria-label="Floating label select example">
                <?php
                  $aviones = $conn->query("SELECT avion.ID, SN, Capacidad, id_comp_vuelo as icv FROM avion INNER JOIN compañia_vuelo ON id_comp_vuelo = compañia_vuelo.ID WHERE id_comp_vuelo IN(SELECT compañia_vuelo.ID FROM compañia_vuelo INNER JOIN aerop_comp ON id_comp = compañia_vuelo.ID WHERE id_aerop = '".$_SESSION['usuario']['id_aeropuerto']."') AND estado = 1");
                  
                  foreach ($aviones as $avion){
                    ?>
                  <option value="<?=$avion['ID']?>" idComp="<?=$avion['icv']?>"><?=$avion['SN']?>-<?=$avion['Capacidad']?></option>
                  <?php
                  }
                  ?>
              </select>
              <label for="tipoUser">Avion para el vuelo</label>
            </div>
            <div class="form-floating mb-3">
              <input type="date" name="fecha-salida" id="fecha-salida" class="form-control" placeholder="name@example.com" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 day')); ?>">
              <label for="fecha-salida">Fecha de salida</label>
            </div>
            <div class="form-floating mb-3">
              <input type="time" name="hora-salida" id="hora-salida" class="form-control" placeholder="name@example.com" step="1800">
              <label for="hora-salida">Hora de salida</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" name="tiempo" id="tiempo" class="form-control" placeholder="0000" value="">
              <label for="hora-salida">Tiempo de vuelo (hrs)</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select" name="aeropuerto" id="aeropuerto" aria-label="Floating label select example">
                <?php
                  $aeropuertos = $conn->query("SELECT aeropuerto.ID, Nombre, ciudad, pais FROM aeropuerto INNER JOIN lugar on id_lugar = lugar.ID WHERE aeropuerto.ID != '".$_SESSION['usuario']['id_aeropuerto']."'");
                  
                  foreach ($aeropuertos as $arp){
                    ?>
                  <option value="<?=$arp['ID']?>"><?=$arp['Nombre']?> (<?=$arp['ciudad']?>-<?=$arp['pais']?>)</option>
                  <?php
                  }
                  ?>
              </select>
              <label for="tipoUser">Aeropuerto destino</label>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="form-floating mb-3">
                  <input type="number" name="precioA" id="precioA" class="form-control" placeholder="" min="0" value="0">
                  <label for="precioA">Precio adulto</label>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-3">
                  <input type="number" name="precioM" id="precioM" class="form-control" placeholder="" min="0" value="0">
                  <label for="precioA">Precio menor</label>
                </div>
              </div>
              <div class="col-4">
                <div class="form-floating mb-3">
                  <input type="number" name="precioN" id="precioN" class="form-control" placeholder="" min="0" value="0">
                  <label for="precioA">Precio niño</label>
                </div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
            <button type="button" class="btn btn-success" id="agregar">GUARDAR</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL EDITAR -->
    <div class="modal fade" id="editarVuelo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">EDITAR</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body modeditar" id="modeditar">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="editVuelo" class="btn btn-success">Editar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="../js/page/vuelos.js"></script>
    <script>
    $(document).ready(function(e) {
      $('#vuelos').DataTable();
    });
    </script>
</body>
</html>