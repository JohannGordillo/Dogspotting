<?php

/**
* ARCHIVO INDEX (Feed).
* Modela la página principal de la red social.
*
* Dada una api key como parámetro GET, se verifica que la
* llave sea válida. De serlo, se muestran 20 perros
* al azar contenidos en la tabla 'dogs' de la base de datos
* de la red social, con información de sus likes, id e imagen.
*
* PHP version 7.
*
* @author  Johann Gordillo
* @author  Jhovan Gallardo
* @license http://www.opensource.org/licenses/mit-license.html  MIT License
*/

// Incluimos los archivos necesarios.
include_once 'database.php';

header('Content-Type: application/json');

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
 
$api_key = $_GET['key']; // Obtenemos la llave da la URL.

$stmt = validate($api_key, $db_connection); // Prepared statement para validar la api key.

if($stmt->rowCount() > 0){
    // Petición.
    $query = "SELECT * FROM dog ORDER BY RAND() LIMIT 2000"; // Devolveremos 2000 perros.

    // Preparamos la petición.
    $stmt = $db_connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    $perros = [];

    // Imprimimos los datos de los perros.
    while($row = $stmt->fetch()) {
        // Llenamos el arreglo con la información de los registros.
        $info_arr = array(
            "id" => $row["id"],
            "name" => $row["name"],      
            "imagen" => $row["image"], 
            "likes" => $row["likes"]
        );
        array_push($perros, $info_arr);
    }
    print_r(json_encode($perros));
}
else{
    // En el caso de que la llave no exista.
    $info_arr = array(
        "message" => "invalid key"
    );

    print_r(json_encode($info_arr)); 
}

?>