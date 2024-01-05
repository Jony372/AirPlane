<?php
include "php/conexion.php";

if (isset($_SESSION['usuario']['id'])) {
  if ($_SESSION['usuario']['tipo'] == "Usuario" || $_SESSION['usuario']['tipo'] == "Administrador") {
    header("Location: index.php");
  } else if ($_SESSION['usuario']['tipo'] == "Aeropuerto") {
    header("Location: indexAeropuerto.php");
  } else if ($_SESSION['usuario']['tipo'] == "Aerolinea") {
    header("Location: indexAerolinea.php");
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

  <script src="js/jquery-3.5.1.min.js"></script>

  <link rel="stylesheet" href="css/login.css">

  <title>Airplane</title>
</head>

<body style="background-image: url('images/bg.jpg'); background-size: cover; background-position: center;">



  <div class="container login">
    <h2>Iniciar Sesión</h2>
    <div class="form-floating mb-3">
      <input type="text" class="form-control" name="user" id="user" placeholder="">
      <label for="user">Usuario</label>
    </div>

    <div class="form-floating mb-3">
      <input type="password" class="form-control" name="pass" id="pass" placeholder="">
      <label for="pass">Contraseña</label>
    </div>

    <div class="row justify-content-between">
      <!-- <div class="col "> -->
      <button class="btn btn-success col-3" id="enviar">INICIAR SESION</button>
      <button class="registrarse btn col-3" id="reg">Registrarse</button>
      <!-- </div> -->
    </div>
  </div>

  <div class="container esconder signup" style="height: 80%;">
    <!-- <form action="php/login.php" method="post"> -->
    <!-- <form action="php/login.php" class="mb-3" method="post" style="height: 100%;"> -->

    <div class="row">
      <h2 class="col">Registrarse</h2>
      <div class="col" id="datosFaltantes" style="overflow-x: auto;"></div>
    </div>
    <input type="hidden" name="funcion" id="funcion" value="signup">

    <div id="si" style="overflow-x: hidden; overflow-y: auto; height: 80%;">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="" required
          title="Favor de llenar todos los datos">
        <label for="nombre">Nombres</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="name@example.com" required
          title="Favor de llenar todos los datos">
        <label for="nombre">Apellidos</label>
      </div>

      <div class="form-floating mb-3">
        <input type="text" name="ruser" id="ruser" class="form-control" placeholder="name@example.com" required
          title="Favor de llenar todos los datos">
        <label for="username">Nombre de usuario</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" name="rpass" id="rpass" class="form-control" placeholder="name@example.com" required
          title="Favor de llenar todos los datos">
        <label for="pass">Contraseña</label>
      </div>

      <div class="form-floating mb-3">
        <input type="password" name="pass2" id="pass2" class="form-control" placeholder="name@example.com" required
          title="Favor de llenar todos los datos">
        <label for="pass2">Repite la contraseña</label>
      </div>

      <div class="form-floating mb-3">
        <input type="tel" name="telefono" id="telefono" class="form-control" placeholder="name@example.com" required>
        <label for="telefono">Telefono</label>
      </div>

      <div class="form-floating mb-3">
        <select class="form-select" name="tipoUser" id="tipoUser" aria-label="Floating label select example" required
          title="Favor de llenar todos los datos">
          <option value="Usuario">Usuario</option>
          <option value="Aeropuerto">Aeropuerto</option>
          <option value="Aerolinea">Aerolinea</option>
        </select>
        <label for="tipoUser">Tipo de usuario</label>
      </div>
    </div>

    <div class="row justify-content-between mt-3">
      <button class="btn btn-success col-3" id="rEnviar">REGISTRARSE</button>
      <button class="registrarse btn col-3" id="is">Iniciar Sesion</button>
      <!-- </div> -->
    </div>
    <!-- </form> -->
    <!-- </form> -->
  </div>


  <!-- Modal -->
  <div class="modal fade " id="m-aerolinea" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Info de la aerolinea</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name-aerolinea" id="name-aerolinea" placeholder="" required
              title="Favor de llenar todos los datos">
            <label for="nombre">Nombre de la Aerolinea</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
          <button type="button" class="btn btn-success" id="gAerolinea">REGISTRARSE</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade " id="m-aeropuerto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Info del aeropuerto</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name-aeropuerto" id="name-aeropuerto" placeholder="" required
              title="Favor de llenar todos los datos">
            <label for="nombre">Nombre del aeropuerto</label>
          </div>
          <div class="form-floating res mx-3">
            <select name="lugar" id="lugar" class="form-select" aria-label="Floating label select example">
              <option selected value="otro">Otro</option>
              <?php
              $lugar = $conn->query("SELECT * FROM lugar");
              foreach ($lugar as $lgr) {
                ?>
                <option value="<?= $lgr['ID'] ?>">
                  <?= $lgr['ciudad'] ?>-
                  <?= $lgr['pais'] ?>
                </option>
                <?php
              }
              ?>
            </select>
            <label for="lugar">Ciudades</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
          <button type="button" class="btn btn-success" id="gAeropuerto">REGISTRARSE</button>
        </div>
      </div>
    </div>
  </div>

  <script src="js/page/login.js"></script>
  <!-- <script>
        $(document).ready(function(e) {
            $(document).on("click","#enviar",function(){
              var user = $("#user").val().trim();
              var pass = $ ("#pass").val().trim();
              if(user == "" || pass == ""){
                alert("Rellene los datos necesarios por favor");
                return;
              }
              $.ajax({
                type: "POST",
                url: "php/login.php",
                data: ({
                  funcion : "login",
                  usuario : user,
                  pass : pass
                }),
                dataType: "html",
                async:false,
                success: function(msg){
                  //var e = prompt("mensajito",msg);
                  
                  console.log(msg);

                  if (msg.trim() == 'Usuario' || msg.trim() == 'Administrador') {
                    window.location='index.php';
                  }else if(msg.trim() == 'Aerolinea'){
                    window.location='indexAerolinea.php';
                  }else if(msg.trim() == 'Aeropuerto'){
                    window.location='indexAeropuerto.php';
                  }else{
                    alert('Error al registrarse, verifique que los datos sean correctos');
                  }
                }
              });
            })
        });
        </script> -->

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>