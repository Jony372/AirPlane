<?php
    include "conexion.php";

    if (isset($_POST['cerrar'])) {
        // Destruir la sesión
        session_destroy();
        
        // Redireccionar u realizar otras acciones después de destruir la sesión si es necesario
        header('Location: ../index.php'); // Cambia 'index.php' por la página a la que quieres redirigir
        exit();
    }
?>