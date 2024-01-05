<?php
  include("php/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="css/aeropuertos.css">
    <title>Aeropuertos</title>
</head>
<body>

    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #16425b;">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html"><img src="images/airplane_logo.png" height="60" alt=""></a>
          <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.html">Inicio</a>
              </li>
              <li>
                <a class="nav-link active" aria-current="page" href="aeropuertos.html">Aeropuertos</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container py-4 mt-3">
        <div class="row justify-content-evenly mt-4">
            <button class="col-4 btn agregar">
              Agregar Aeropuerto
            </button>
            <div class="col-4 searchBox">

                <input class="searchInput" type="text" name="" placeholder="Search something">
                <button class="searchButton" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                    <g clip-path="url(#clip0_2_17)">
                        <g filter="url(#filter0_d_2_17)">
                        <path d="M23.7953 23.9182L19.0585 19.1814M19.0585 19.1814C19.8188 18.4211 20.4219 17.5185 20.8333 16.5251C21.2448 15.5318 21.4566 14.4671 21.4566 13.3919C21.4566 12.3167 21.2448 11.252 20.8333 10.2587C20.4219 9.2653 19.8188 8.36271 19.0585 7.60242C18.2982 6.84214 17.3956 6.23905 16.4022 5.82759C15.4089 5.41612 14.3442 5.20435 13.269 5.20435C12.1938 5.20435 11.1291 5.41612 10.1358 5.82759C9.1424 6.23905 8.23981 6.84214 7.47953 7.60242C5.94407 9.13789 5.08145 11.2204 5.08145 13.3919C5.08145 15.5634 5.94407 17.6459 7.47953 19.1814C9.01499 20.7168 11.0975 21.5794 13.269 21.5794C15.4405 21.5794 17.523 20.7168 19.0585 19.1814Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" shape-rendering="crispEdges"></path>
                        </g>
                    </g>
                    <defs>
                        <filter id="filter0_d_2_17" x="-0.418549" y="3.70435" width="29.7139" height="29.7139" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                        <feOffset dy="4"></feOffset>
                        <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                        <feComposite in2="hardAlpha" operator="out"></feComposite>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></feColorMatrix>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2_17"></feBlend>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2_17" result="shape"></feBlend>
                        </filter>
                        <clipPath id="clip0_2_17">
                        <rect width="28.0702" height="28.0702" fill="white" transform="translate(0.403503 0.526367)"></rect>
                        </clipPath>
                    </defs>
                    </svg>
                </button>
            </div>
        </div>
        <br><br><br>
        <div class="row justify-content-center text-center">
            <table class="table table-sm" id="tablita">
                <thead>
                    <th>Nombre</th>
                    <!-- <th class="sorting-asc">Nombre</th> -->
                    <th>Ciudad</th>
                    <th>Pais</th>
                    <th>Eliminar</th>
                </thead>
                <tbody>
                    <?php
                      $Auto = $conn->query("SELECT nombre, ciudad, pais FROM aeropuerto INNER JOIN lugar ON id_lugar = lugar.ID");
                      foreach ($Auto as $row){
                      ?>
                      <tr>
                        <td><?=$row['nombre']?></td>
                        <td><?=$row['ciudad']?></td>
                        <td><?=$row['pais']?></td>
                        <td>
                          <button class="btn btn-danger">Eliminar</button>
                        </td>
                      </tr>
                      <?php
                      }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    

    

    <script>
        $(document).ready(function(e) {
            $(document).on("click","#enviar",function(){
              $.ajax({
                type: "POST",
                url: "php/login.php",
                data: ({
                  funcion : "login",
                  correo : $ ("#correo").val(),
                  pass : $ ("#pass").val()
                }),
                dataType: "html",
                async:false,
                success: function(msg){
                  //var e = prompt("mensajito",msg);
                  var hola = msg.toString() === 'Inicio';

                  for (let i = 0; i < msg.length; i++) {
                      console.log(msg.charAt(i));
                  }
                  
                  if (msg.trim() == 'Inicio') {
                    alert('Bienvenido');
                    window.location="index.html";
                  }else{
                    alert('Error al ingresar');
                  }
                }
              });
            })
        });
        </script>

            <script src="js/jquery-3.5.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function(e) {
              $('#tablita').DataTable();
            });
        </script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>