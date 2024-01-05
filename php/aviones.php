<?php
    include "conexion.php";

    if ($_POST['function'] == "crear") {
        $id = genID();
        while (true) {
            try {
                
                $sql = "INSERT INTO avion VALUES('".$id."', ?, ?, NULL, 1, ?, 1, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1,$_POST['capacidad'], PDO::PARAM_INT);
                $stmt->bindParam(2,$_SESSION['usuario']['id_aerolinea'], PDO::PARAM_STR);
                $stmt->bindParam(3,$_POST['SN'], PDO::PARAM_INT);
                $stmt->bindParam(4,$_POST['capacidad'], PDO::PARAM_INT);
                $stmt->execute();

                echo"Se agrego a la base de datos";
                break;
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    echo "Error: La clave primaria ya existe. Duplicado.";
                    $id = genID();
                } else {
                    echo "Error: " . $e->getMessage();
                    break;
                }
            }
        }
    }else if ($_POST['function'] == "borrar") {
        try {
            $stmt = $conn->query("UPDATE avion SET estado = 0 WHERE ID = '".$_POST['id']."'");
            echo "Se elimino el avion";
        } catch (PDOException $e) {
            echo "No se pudo eliminar el avion ";
        }
    }else if ($_POST['function'] == "editar") {
        try {
            $sql = "UPDATE avion SET Capacidad = ?, SN = ? WHERE ID = '".$_POST['id']."'";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$_POST['capacidad'], PDO::PARAM_INT);
            $stmt->bindParam(2,$_POST['sn'], PDO::PARAM_STR);
            $stmt->execute();

            echo"Se edito el avion";
        } catch (PDOException $e) {
            echo "Error al editar el avion".$e;
        }
    }


    else if ($_POST['function'] = 'modeditar') {
        $stmt = $conn->query("SELECT * FROM avion WHERE ID='".$_POST["id"]."'");
        foreach ($stmt as $row);
        ?>
            <div class="row">
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="edsn" id="edsn" placeholder="" value="<?= $row['SN']?>">
                      <label for="sn">Numero de serie</label>
                  </div>
              </div>
              <div class="col">
                  <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="edcapacidad" id="edcapacidad" placeholder="" value="<?= $row['Capacidad']?>">
                      <label for="capacidad">Capacidad</label>
                  </div>
              </div>
            </div>
        <?php
    }
?>