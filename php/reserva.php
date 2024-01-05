<?php

include("conexion.php");

if ($_POST['funcion'] == "reservar") {
    $costo = ($_POST['pa'] * $_SESSION['vuelo']['adulto'])+($_POST['pm'] * $_SESSION['vuelo']['menor'])+($_POST['pn'] * $_SESSION['vuelo']['niño']);
    while (true) {
        $id = genID();
        try {
            $stmt = $conn -> prepare("INSERT INTO reserva VALUES('".$id."', ?, '".date("Y-m-d")."', ?, NULL, ".$costo.", ?, ?, ?, ?)");
            $stmt->bindParam(1,$_POST['idVuelo'], PDO::PARAM_STR);
            $stmt->bindParam(2,$_SESSION['usuario']['id'], PDO::PARAM_STR);
            $stmt->bindParam(3,$_SESSION['vuelo']['adulto'], PDO::PARAM_INT);
            $stmt->bindParam(4,$_SESSION['vuelo']['menor'], PDO::PARAM_INT);
            $stmt->bindParam(5,$_SESSION['vuelo']['niño'], PDO::PARAM_INT);
            $stmt->bindParam(6,$_SESSION['vuelo']['total'], PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['vuelo']['id'] = $_POST['idVuelo'];
            $_SESSION['vuelo']['hora'] = $_POST['hora'];

            echo $costo;
            break;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] != 1062) {
                echo "Error: " . $e->getMessage();
                break;
            }
        }
    }
}

?>