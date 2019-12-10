<?php

/**
* ARCHIVO INSERTCOMENTAR.
* Modela la acción de comentar una imagen en la red social.
*
* Nos permite agregar un comentario a la imagen correspondiente
* con la ID del perro dada.
*
* PHP version 7.
*
* @author  Jhovan Gallardo
* @author  Johann Gordillo
* @author  Diana Nicolas
* @license http://www.opensource.org/licenses/mit-license.html  MIT License
*/

// Incluimos los archivos necesarios.
include_once 'database.php';

// Datos necesarios para conectarnos con la base de datos.
$db_host = "localhost";
$db_name = "id11870230_base";
$db_user_name = "id11870230_admin";
$db_password = "password";     

// Nos conectamos con la base de datos.
$database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
$db_connection = $database->getConnection();

// Se obtienen los parámetros POST.
$api_key = $_POST["api_key"];
$dog_id = $_POST["dog_id"];
$texto = $_POST["texto"];

// Se define el query para recuperar al usuario de la llave.
$query = "SELECT id FROM user" . " WHERE api_key = '" . $api_key . "'";

// Preparamos la petición.
$stmt = $db_connection->prepare($query);

// Ejecutamos la petición.
$stmt->execute();

if($stmt){
    if($stmt->rowCount() > 0){
        $row = $stmt->fetch();

        $user_id = $row['id'];

        // Inserta el comentario en la tabla comments.
        $query = "INSERT INTO comment (dog_id, user_id, texto)  VALUES ('$dog_id','$user_id', '$texto')";
        
        // Preparamos la petición.
        $stmt = $db_connection->prepare($query);

        // Ejecutamos la petición.
        $stmt->execute();

        if($stmt) {
            echo "Records inserted into comment successfully.";
        } else {
            echo "ERROR: Could not able to execute " .  $query;
        }

    } else {
        echo "No records matching your query were found.";
    }
} else {
    echo "ERROR: Could not able to execute " .  $query;
}

?>