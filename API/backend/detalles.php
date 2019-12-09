<?php

/**
* ARCHIVO DETALLES.
* Permite mostrar la información de un perro guardado en la 
* base de datos.
*
* Dada una api key y la ID del perro como parámetros GET,
* muestra la información del perro dado, incluyendo comentarios.
*
* PHP version 7.
*
* @author  Johann Gordillo
* @author  Jhovan Gallardo
* @license http://www.opensource.org/licenses/mit-license.html  MIT License
*/

// Incluimos los archivos necesarios.
include_once 'database.php';

/**
 * Función auxiliar para verificar que la api key ingresada sea valida.
 */
function validate($api_key, $connection) {
    // Petición.
    $query = "SELECT `api_key` FROM user" . " WHERE api_key='" . $api_key . "'";

    // Preparamos la petición.
    $stmt = $connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    return $stmt; // Regresamos el prepared statement.
}

// Datos necesarios para conectarnos con la base de datos.
$db_host = "localhost";
$db_name = "id11870230_base";
$db_user_name = "id11870230_admin";
$db_password = "password";    

// Nos conectamos con la base de datos.
$database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
$db_connection = $database->getConnection();
 
$api_key = $_GET['key'];   // Obtenemos la llave da la URL.
$dog_id = $_GET['dog_id']; // Obtenemos ID del perro.

$stmt = validate($api_key, $db_connection); // Prepared statement para validar la api key.

if($stmt->rowCount() > 0){
    // Petición.
    $query = "SELECT * FROM dog" . " WHERE id='$dog_id'";

    // Preparamos la petición.
    $stmt = $db_connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch();

        $info_arr = array(
            "id" => $row["id"],
            "name" => $row["name"],      
            "imagen" => $row["image"], 
            "likes" => $row["likes"]
        );

        print_r(json_encode($info_arr)); // Pasamos el array a json.
        echo "<br>";                     // Salto de línea para el siguiente perro.

        $query = "SELECT * FROM comment WHERE dog_id='$dog_id'";

        // Preparamos la petición.
        $stmt = $db_connection->prepare($query);

        // Ejecutamos la petición.
        $stmt->execute();

        $list = [];

        while($row = $stmt->fetch()) {
            $info_arr = array(
                "fecha" => $row["date"],
                "user_id" => $row["user_id"],      
                "text" => $row["texto"]
            );
            array_push($list, $info_arr);
        }
        print_r(json_encode($list)); // Pasamos el array a json.
    }
    else {
        // En el caso que la ID del perro no exista.
        $info_arr = array(
            "message" => "invalid id"
        );
    
        print_r(json_encode($info_arr));  
    }
}
else {
    // En el caso de que la llave no exista.
    $info_arr = array(
        "message" => "invalid key"
    );

    print_r(json_encode($info_arr)); 
}

?>