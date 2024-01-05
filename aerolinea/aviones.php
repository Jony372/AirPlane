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
    
    <link rel="stylesheet" href="../css/style.css">
    <title>Airplane</title>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg " style="background-color: #16425b; height: 10vh;">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"><img src="../images/airplane_logo.png" style="height: 10vh;" alt=""></a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../indexAerolinea.php">Inicio</a>
            </li>
            <li>
              <a class="nav-link active seleccionado" aria-current="page" href="">Aviones</a>
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

    <div class="vTop">
      <h1>Aviones</h1>
    </div>
    
    <br>
    <div class="d-flex justify-content-center">
      <button class="btn av justify-self-center" data-bs-toggle="modal" data-bs-target="#agregarAvion">AGREGAR AVION</button>
    </div>
    
    <div class="container py-4 mt-3">
        <div class="row justify-content-center text-center">
            <table class="table table-sm" id="vuelos">
                <thead>
                    <th>SN</th>
                    <th>Capacidad</th>
                    <th>Aeropuerto</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </thead>
                <tbody>
                  <?php
                    $aviones = $conn->query("SELECT avion.ID, SN, Capacidad, COALESCE(aeropuerto.Nombre, 'NO') AS an , disponible FROM avion INNER JOIN compañia_vuelo ON id_comp_vuelo = compañia_vuelo.ID LEFT JOIN aeropuerto ON id_aeropuerto = aeropuerto.ID WHERE id_comp_vuelo = '".$_SESSION['usuario']['id_aerolinea']."' AND avion.estado = 1");
                    foreach ($aviones as $avion){
                  ?>
                  <tr>
                    <td><?= $avion['SN']?></td>
                    <td><?=$avion['Capacidad']?></td>
                    <td><?=$avion['an']?></td>
                    <td><button class="btn btn-warning editar" data-bs-toggle="modal" data-bs-target="#editarAvion" idAvion="<?= $avion['ID']?>">Editar</button></td>
                    <td><button class="btn btn-danger eliminar" idAvion="<?= $avion['ID']?>">Eliminar</button></td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modales -->
    <!-- AGREGAR -->
    <div class="modal fade" id="agregarAvion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">AGREGAR</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="addsn" id="addsn" placeholder="">
                      <label for="sn">Numero de serie</label>
                  </div>
              </div>
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="addcapacidad" id="addcapacidad" placeholder="">
                      <label for="capacidad">Capacidad</label>
                  </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="addAvion" class="btn btn-success">Guardar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- EDITAR -->
    <div class="modal fade" id="editarAvion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">EDITAR</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body modeditar" id="modeditar">
            <!-- <div class="row">
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="edsn" id="edsn" placeholder="">
                      <label for="sn">Numero de serie</label>
                  </div>
              </div>
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="edcapacidad" id="edcapacidad" placeholder="">
                      <label for="capacidad">Capacidad</label>
                  </div>
              </div>
            </div> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="editAvion" class="btn btn-success">Editar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

    <script src="../js/page/aviones.js"></script>
    
    <script>
    $(document).ready(function() {
      $('#vuelos').DataTable();

      // $(document).on("click", "#addAvion", function(){
      //   var capacidad = $("#capacidad").val().trim();
      //   var sn = $("#sn").val().trim();
      //   console.log("No se qpd")
      //   if(capacidad == "" || sn == ""){
      //     alert("Rellene los datos, por favor");
      //     return;
      //   }
      //   $.ajax({
      //       type: "POST",
      //       url: "../php/aviones.php",
      //       data: ({
      //           function: "crear",
      //           capacidad: capacidad,
      //           SN: sn
      //       }),
      //       dataType: "html",
      //       success: function (response) {
      //           console.log(response);
      //           location.reload();
      //       },
      //       error: function (xhr, status, error) {
      //         console.error("Error en la solicitud AJAX:", status, error);
      //       }
      //   });
      // });
    });
    </script>
</body>
</html>