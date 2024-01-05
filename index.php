
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

    <div class=" row mx-auto" style=" height: 90vh;">
      <div class="col-12 col-md-5" style="margin:0 auto 50px auto;">
        <br>
        <h3 class="ml-2"><strong>Reservar vuelo</strong></h3><br>

        <div class="form-floating mb-3 res">
          <input type="date"
            class="form-control" name="fecha" id="fecha" aria-describedby="helpId"  min="<?= date('Y-m-d'); ?>">
            <label for="" class="form-label">Fecha</label>
        </div>
        
        <div class="form-floating mb-3 res">
          <select name="origen" id="origen" class="form-select" aria-label="Floating label select example">
            <?php
              $lugar = $conn->query("SELECT * FROM lugar ORDER BY ciudad");
              foreach ($lugar as $ciudad){
              ?>
              <option value="<?php echo $ciudad['ID']?>"><?php echo $ciudad['ciudad']?>-<?php echo $ciudad['pais']?></option>
              <?php
              }
            ?>
          </select>
          <label for="compañia">Origen</label>
        </div>

        <div class="form-floating mb-3 res">
          <select name="destino" id="destino" class="form-select" aria-label="Floating label select example">
            <?php
              $lugar = $conn->query("SELECT * FROM lugar ORDER BY ciudad");
              foreach ($lugar as $ciudad){
              ?>
              <option value="<?php echo $ciudad['ID']?>"><?php echo $ciudad['ciudad']?>-<?php echo $ciudad['pais']?></option>
              <?php
              }
            ?>
          </select>
          <label for="destino">Destino</label>
        </div>

        <p>Cantidad de boletos</p>

        <div class="row justify-content-evenly" >
          <div class="col-3">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" placeholder="N° personas" id="adulto" name="adulto" value="0" min="0" max="5">
              <label class="texto" for="adulto" >Adultos</label>
            </div>
          </div>
          <div class="col-3">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" placeholder="N° personas" id="menor" name="menor" value="0" min="0" max="5">
              <label class="texto" for="menor">Menores</label>
            </div>
          </div>
          <div class="col-3">
            <div class="form-floating mb-3">
              <input type="number" class="form-control" placeholder="N° personas" id="niño" name="niño" value="0" min="0" max="5">
              <label class="texto" for="niño">Niños</label>
            </div>
          </div>
        </div>
        <br>

        <div class="row justify-content-center">
          <div class="col-4">
            <button class="btn" style="background-color: #81c3d7;" id="buscar">Buscar vuelos</button>
          </div>
        </div>
          
      </div>
      <div class="col-12 col-md-7 images" style="background-color: #16425b;">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" style="height: 100%;">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner" id="ciudades">
            <script>
              var ciudades = <?php echo lugares();?>;
              // $(document).ready(function() {
                for (let i = 0; i < 3; i++) {
                  let ciudad = ciudades[i].ciudad;
                  $.ajax({
                    type: "get",
                    url: "https://api.unsplash.com/photos/random?query="+ciudad+"&orientation=landscape&client_id=Iq2MbxxL1XfseNvhDz1bRbT5-QTZkUKZyw1yrJcVZ4I",
                    dataType: "json",
                    success: function (data) {
                      $("#ciudades").append($('<div class="carousel-item active" style="width: 90%; margin-left:5%">').html("<img src='"+data.urls.full+"' class='d-block w-100' alt='"+ciudad+"'><div class='carousel-caption d-none d-md-block'><h2 class='texto-ciudad'>"+ciudad+"</h2></div>"))
                    }
                  });
                };
            </script>
            <!-- <div class="carousel-item active">
              <img src='https://images.unsplash.com/photo-1516481402338-0443817e04c5?crop=entropy&cs=srgb&fm=jpg&ixid=M3w1Mjk1NDl8MHwxfHJhbmRvbXx8fHx8fHx8fDE3MDAyNzg3NDd8&ixlib=rb-4.0.3&q=85' class='d-block w-100' alt=''>
              <div class='carousel-caption d-none d-md-block'><h5>"+ciudad+"</h5></div>
            </div>
            <div class="carousel-item active">
              <img src='https://images.unsplash.com/photo-1516481402338-0443817e04c5?crop=entropy&cs=srgb&fm=jpg&ixid=M3w1Mjk1NDl8MHwxfHJhbmRvbXx8fHx8fHx8fDE3MDAyNzg3NDd8&ixlib=rb-4.0.3&q=85' class='d-block w-100' alt=''>
              <div class='carousel-caption d-none d-md-block'><h5>"+ciudad+"</h5></div>
            </div> -->
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>

    <script src="js/page/buscador.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


    
    <!-- Bootstrap -->
</body>
</html>