
<?php

// iniciar session 
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = "";
}


$dbUser = "root";
$dbPass = "12345678";


// Check connection

try {
    $conn = new PDO('mysql:host=localhost;dbname=airplane', $dbUser, $dbPass);
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn -> query("CALL despegar()");
$conn -> query("CALL updateVuelos()");



function genID() {
    // Generar un número aleatorio de 0 a 16777215 (0xFFFFFF en hexadecimal)
    $numeroAleatorio = mt_rand(0, 0xFFFFFF);

    // Formatear el número como un string hexadecimal de 6 dígitos
    $hexadecimal = sprintf("%06X", $numeroAleatorio);

    return $hexadecimal;
}

function lugares(){
    global $conn;

    $sql = "SELECT ciudad FROM lugar ORDER BY RAND() LIMIT 3";
    $stmt = $conn ->query($sql);

    $ciudad = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return json_encode($ciudad);
}


// $valores = array('elemento1', 'elemento2', 'elemento3');

// // Utilizar implode para combinar los elementos con comillas simples y separados por coma
// $cadena_resultante = "'" . implode("', '", $valores) . "'";

// // Imprimir la cadena resultante
// echo $cadena_resultante;


?>
