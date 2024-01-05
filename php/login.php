<?php
include("conexion.php");
// crea el codigo necesario para el login viniendo los datos desde un form de tipo post
// if($_POST['funcion']=='login'){
// 	$sql = "SELECT * FROM usuario WHERE correo = ? AND pass = md5(?)";
//     $stmt= $conn->prepare($sql);
//     $stmt->bind_param("ss", $_POST["correo"], $_POST["pass"]);
//     if ($stmt->execute()) {  //si la consulta se ejecuta correctamente
//         $resultado=$stmt->get_result();
//         //guardar los datos de la consulta en variables de session 
//         echo("Hola mundo");

//         while ($fila = mysqli_fetch_assoc($resultado)) {
//             echo("Hola mundo");
//             $_SESSION['id'] = $fila['ID'];
//             $_SESSION['user'] = $fila['nombreUsuario'];
//             $_SESSION['nombre'] = $fila['nombre'];
//             $_SESSION['pass'] = $fila['pass'];
//             $_SESSION['telefono'] = $fila['telefono'];
//             $_SESSION['correo'] = $fila['correo'];
//             $_SESSION['tipo'] = $fila['tipo'];
//         }

//         echo($_SESSION['user']); 
//     }else{
//         echo "No esta registrado el usuario";
//     }
// }

if ($_POST['funcion'] == 'login') {
    $sql = "SELECT * FROM usuario WHERE nombreUsuario = ? AND pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1,$_POST['usuario'], PDO::PARAM_STR);
    $stmt->bindParam(2,$_POST['pass'], PDO::PARAM_STR);
    $stmt->execute();

    $resultados = $stmt->fetchAll();
    

    if (count($resultados) > 0) {
        foreach ($resultados as $usuario) {

            $_SESSION['usuario']['id'] = $usuario['ID'];
            $_SESSION['usuario']['nombre'] = $usuario['nombre'];
            $_SESSION['usuario']['nombreUser'] = $usuario['nombreUsuario'];
            $_SESSION['usuario']['telefono'] = $usuario['telefono'];
            $_SESSION['usuario']['tipo'] = $usuario['tipo'];
            $_SESSION['usuario']['id_aeropuerto'] = $usuario['id_aeropuerto'];
            $_SESSION['usuario']['id_aerolinea'] = $usuario['id_compañia'];
            
            echo $_SESSION['usuario']['tipo'];

        }
    } else {
        echo 'Usuario no registrado.'.$resultados;
    }
}

if ($_POST['funcion'] == "signup") {
    $id = genID();
    while (true) {
        try {


            $stmt = $conn->prepare("SELECT * FROM usuario WHERE nombreUsuario = ?");
            $stmt->bindParam(1, $_POST['nUser'], PDO::PARAM_STR);
            $stmt->execute();
            $numFilas = $stmt->rowCount();
            if ($numFilas > 0) {
                echo "Ese usuario ya esta en uso";
                break;
            }else{
                $sql = "INSERT INTO usuario VALUES('".$id."', ?, ?, ?, ?, ?, ?, ".$_POST['arp'].", ".$_POST['arl'].")";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1,$_POST['nombre'], PDO::PARAM_STR);
                $stmt->bindParam(2,$_POST['apellido'], PDO::PARAM_STR);
                $stmt->bindParam(3,$_POST['pass'], PDO::PARAM_STR);
                $stmt->bindParam(4,$_POST['tel'], PDO::PARAM_STR);
                $stmt->bindParam(5,$_POST['nUser'], PDO::PARAM_STR);
                $stmt->bindParam(6,$_POST['tipo'], PDO::PARAM_STR);
                $stmt->execute();
    
                $_SESSION['usuario']['id'] = $id;
                $_SESSION['usuario']['nombre'] = $_POST['nombre'];
                $_SESSION['usuario']['nombreUser'] = $_POST['nUser'];
                $_SESSION['usuario']['telefono'] = $_POST['tel'];
                $_SESSION['usuario']['tipo'] = $_POST['tipo'];
    
                echo $_POST['tipo'];
                break;
            }


        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // echo "Error: La clave primaria ya existe. Duplicado.";
                $id = genID();
            } else {
                echo "Error: " . $e->getMessage();
                break;
            }
        }
    }
}

if ($_POST['funcion'] == "aeropuerto") {
    $id = genID();
    while (true) {
        try {
            $sql = "INSERT INTO aeropuerto VALUES('".$id."', ?, ?, 0)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$_POST['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(2,$_POST['id'], PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['usuario']['id_aeropuerto'] = $id;

            echo $id;
            break;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // echo "Error: La clave primaria ya existe. Duplicado.";
                $id = genID();
            } else {
                echo "Error: " . $e->getMessage();
                break;
            }
        }
    }
}

if ($_POST['funcion'] == "aerolinea") {
    $id = genID();
    while (true) {
        try {
            $sql = "INSERT INTO compañia_vuelo VALUES('".$id."', ?, 0)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$_POST['nombre'], PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['usuario']['id_aerolinea'] = $id;

            echo $id;
            break;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // echo "Error: La clave primaria ya existe. Duplicado.";
                $id = genID();
            } else {
                echo "Error: " . $e->getMessage();
                break;
            }
        }
    }
}

?>