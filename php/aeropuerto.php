<?php

include('conexion.php');

if($_POST['funcion']=='c'){
    while (true) {
        $id = genID();
        $sql = "INSERT INTO aeropuerto VALUES(?,?,?)";
        $stmt = $conn->prepare($sql);
        
    }
    
    
}else if($_POST['funcion']=='r'){
    $sql = "SELECT nombre, ciudad, pais FROM aeropuerto INNER JOIN lugar ON id_lugar = lugar.ID";
    $stmt = $conn->prepare($sql);
}else if($_POST['funcion']=='u'){
    
}else if($_POST['funcion']=='d'){
    
}

?>