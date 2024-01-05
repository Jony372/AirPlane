<?php

include "conexion.php";

if ($_POST['funcion'] == "buscar") {
    $_SESSION['vuelo']['origen'] = $_POST['origen'];
    $_SESSION['vuelo']['destino'] = $_POST['destino'];
    $_SESSION['vuelo']['norigen'] = $_POST['norigen'];
    $_SESSION['vuelo']['ndestino'] = $_POST['ndestino'];
    $_SESSION['vuelo']['fecha'] = $_POST['fecha'];
    $_SESSION['vuelo']['adulto'] = $_POST['a'];
    $_SESSION['vuelo']['menor'] = $_POST['m'];
    $_SESSION['vuelo']['niño'] = $_POST['n'];
    $_SESSION['vuelo']['total'] = $_POST['total'];
}

?>