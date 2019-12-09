<?php

/**
* ARCHIVO LIKE.
* Modela la acción de dar likes a imagenes en la red social.
*
* Nos permite aumentar el contador de likes del ID del perro dado,
* así como agregar el like a la tabla de likes con campos user_id 
* y dog_id.
*
* PHP version 7.
*
* @author  Jhovan Gallardo
* @author  Johann Gordillo
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

// Se obtienen los valores GET.
$api_key = $_GET['key'];
$dog_id = $_GET['dog_id'];

// Se define el query para recuperar al usuario de la llave.
$query = "SELECT `id` FROM user" . " WHERE api_key='" . $api_key . "'";

// Preparamos la petición.
$stmt = $db_connection->prepare($query);

// Ejecutamos la petición.
$stmt->execute();

if($stmt->rowCount() > 0) {
    $row = $stmt->fetch();

    $user_id = $row['id'];

    // Inserta un nuevo like en la tabla likes.
    $query = "INSERT INTO likes" . " (dog_id, user_id) VALUES ('" . $dog_id . "', '" . $user_id . "')";
    $stmt = $db_connection->prepare($query); 
    $stmt->execute(); 
    if($stmt) {
        echo "Records inserted into likes successfully.";
    } 
    else {
        echo "An error has ocurred while trying to update the number of likes.";
    }

    // Incrementa el contador de likes del perro en la base de datos.
    $query = "UPDATE dog SET likes = likes + 1" . " WHERE id = '" . $dog_id . "'";
    $stmt = $db_connection->prepare($query); 
    $stmt->execute(); 
    if($stmt) {
        echo "Records inserted into dog successfully.";
    } 
    else {
        echo "An error has ocurred while trying to update the likes table.";
    }
}
else {
    echo "Invalid API key.";
}

?>