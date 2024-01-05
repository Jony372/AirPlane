<?php

include "conexion.php";

if($_POST['funcion'] == "agregar"){
    $id = genID();
    while(true){
        try {
            $sql = "INSERT INTO vuelo VALUES('".$id."', ?, ?, ?, ?, CONCAT(?, ':00'), ?, '".$_SESSION['usuario']['id_aeropuerto']."', ?, ?, ?, 'EN ESPERA', 0)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$_POST['id_avion'], PDO::PARAM_STR);
            $stmt->bindParam(2,$_POST['arl'], PDO::PARAM_STR);
            $stmt->bindParam(3,$_POST['fs'], PDO::PARAM_STR);
            $stmt->bindParam(4,$_POST['hs'], PDO::PARAM_STR);
            $stmt->bindParam(5,$_POST['tiempo'], PDO::PARAM_STR);
            $stmt->bindParam(6,$_POST['destino'], PDO::PARAM_STR);
            $stmt->bindParam(7,$_POST['pa'], PDO::PARAM_STR);
            $stmt->bindParam(8,$_POST['pm'], PDO::PARAM_STR);
            $stmt->bindParam(9,$_POST['pn'], PDO::PARAM_STR);
            $stmt->execute();

            echo("Se agrego el vuelo");
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
}
else if($_POST['funcion'] == "editar"){
    try {
        $sql = "UPDATE vuelo SET id_avion = ?, id_compania = ?, fecha_salida = ?, hora_salida = ?, tiempo = ?, id_aeropuerto_destino = ?, precioA = ?, precioM = ?, precioN = ? WHERE ID = '".$_POST['id_vuelo']."'";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1,$_POST['id_avion'], PDO::PARAM_STR);
        $stmt->bindParam(2,$_POST['arl'], PDO::PARAM_STR);
        $stmt->bindParam(3,$_POST['fs'], PDO::PARAM_STR);
        $stmt->bindParam(4,$_POST['hs'], PDO::PARAM_STR);
        $stmt->bindParam(5,$_POST['tiempo'], PDO::PARAM_STR);
        $stmt->bindParam(6,$_POST['destino'], PDO::PARAM_STR);
        $stmt->bindParam(7,$_POST['pa'], PDO::PARAM_STR);
        $stmt->bindParam(8,$_POST['pm'], PDO::PARAM_STR);
        $stmt->bindParam(9,$_POST['pn'], PDO::PARAM_STR);
        $stmt->execute();

        echo("Se edito el vuelo");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
else if($_POST['funcion'] == "borrar"){
    try {
        $stmt = $conn->query("UPDATE vuelo SET estado = 'CANCELADO' WHERE ID = '".$_POST['id']."'");
        echo "Se cancelo el vuelo";
    } catch (PDOException $e) {
        echo "No se pudo cancelar el vuelo ";
    }
}
else if ($_POST['funcion'] = 'modeditar') {
    $stmt = $conn->query("SELECT * FROM vuelo WHERE ID='".$_POST["id"]."'");
    foreach ($stmt as $row);
    
    ?>
        <div class="form-floating mb-3">
            <select class="form-select" name="editavion" id="editavion" aria-label="Floating label select example">
            <?php
                $aviones = $conn->query("SELECT avion.ID, SN, Capacidad, id_comp_vuelo as icv FROM avion INNER JOIN compañia_vuelo ON id_comp_vuelo = compañia_vuelo.ID WHERE id_comp_vuelo IN(SELECT compañia_vuelo.ID FROM compañia_vuelo INNER JOIN aerop_comp ON id_comp = compañia_vuelo.ID WHERE id_aerop = '".$_SESSION['usuario']['id_aeropuerto']."')");
                
                foreach ($aviones as $avion){
                    $vion = "";
                    if($avion['ID'] == $row['id_avion']){
                        $vion = "selected";
                    }
                ?>
                <option value="<?=$avion['ID']?>" <?=$vion?> idComp="<?=$avion['icv']?>"><?=$avion['SN']?>-<?=$avion['Capacidad']?></option>
                <?php
                }
                ?>
            </select>
            <label for="tipoUser">Avion para el vuelo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="date" name="editfecha-salida" id="editfecha-salida" value="<?=$row['fecha_salida']?>" class="form-control" placeholder="name@example.com" min="<?= date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 day')); ?>">
            <label for="fecha-salida">Fecha de salida</label>
        </div>
        <div class="form-floating mb-3">
            <input type="time" name="edithora-salida" id="edithora-salida" value="<?=$row['hora_salida']?>" class="form-control" placeholder="name@example.com" step="1800">
            <label for="hora-salida">Hora de salida</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="edittiempo" id="edittiempo" class="form-control" placeholder="0000" value="<?=$row['tiempo']?>">
            <label for="hora-salida">Tiempo de vuelo (hrs)</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" name="editaeropuerto" id="editaeropuerto" aria-label="Floating label select example">
            <?php
                $aeropuertos = $conn->query("SELECT aeropuerto.ID, Nombre, ciudad, pais FROM aeropuerto INNER JOIN lugar on id_lugar = lugar.ID WHERE aeropuerto.ID != '".$_SESSION['usuario']['id_aeropuerto']."'");
                
                foreach ($aeropuertos as $arp){
                    $aerp = "";
                    if($arp['ID'] == $row['id_aeropuerto_destino']){
                        $aerp = "selected";
                    }
                ?>
                <option value="<?=$arp['ID']?>" <?=$aerp?>><?=$arp['Nombre']?> (<?=$arp['ciudad']?>-<?=$arp['pais']?>)</option>
                <?php
                }
                ?>
            </select>
            <label for="tipoUser">Aeropuerto destino</label>
        </div>
        <div class="row">
            <div class="col-4">
            <div class="form-floating mb-3">
                <input type="number" name="editprecioA" id="editprecioA" class="form-control" placeholder="" min="0" value="<?=$row['precioA']?>">
                <label for="precioA">Precio adulto</label>
            </div>
            </div>
            <div class="col-4">
            <div class="form-floating mb-3">
                <input type="number" name="editprecioM" id="editprecioM" class="form-control" placeholder="" min="0" value="<?=$row['precioM']?>">
                <label for="precioA">Precio menor</label>
            </div>
            </div>
            <div class="col-4">
            <div class="form-floating mb-3">
                <input type="number" name="editprecioN" id="editprecioN" class="form-control" placeholder="" min="0" value="<?=$row['precioN']?>">
                <label for="precioA">Precio niño</label>
            </div>
            </div>
        </div>
    <?php
}

?>