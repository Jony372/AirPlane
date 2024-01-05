<?php
    include "conexion.php";

    if ($_POST['function'] == "agregar") {
        $id = genID();
        while (true) {
            try {
                $max = $conn->query("SELECT * FROM aerop_comp WHERE id_aerop ='".$_SESSION['usuario']['id_aeropuerto']."'");
                if ($max->rowCount() == 10) {
                    echo "Solo puedes tener 10 diferentes aerolineas";
                    break;
                };
                $sql = "INSERT INTO aerop_comp VALUES('".$id."', ?, '".$_SESSION['usuario']['id_aeropuerto']."')";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1,$_POST['idarl'], PDO::PARAM_STR);
                $stmt->execute();

                echo"Se agrego la aerolinea\nAhora puedes usar los aviones de ".$_POST['name'];
                break;
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $id = genID();
                } else {
                    echo "Error: " . $e->getMessage();
                    break;
                }
            }
        }
    }else if ($_POST['function'] == "borrar") {
        try {
            $stmt = $conn->query("DELETE FROM aerop_comp WHERE ID = '".$_POST['id']."'");
            echo "Se elimino la erolinea";
        } catch (PDOException $e) {
            echo "No se pudo eliminar el avion ";
        }
    }


?>