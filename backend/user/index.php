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
include_once '../config/database.php';
include_once '../objects/dog.php';
include_once '../objects/user.php';

/**
 * Función auxiliar para verificar que la api key ingresada sea valida.
 */
function validate($api_key, $connection) {
    // Petición.
    $query = "SELECT `apikey` FROM users" . " WHERE apikey='" . $api_key . "'";

    // Preparamos la petición.
    $stmt = $connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    return $stmt; // Regresamos el prepared statement.
}

// Datos necesarios para conectarnos con la base de datos.
$db_host = "localhost";
$db_name = "dogspotting";
$db_user_name = "root";
$db_password = "";    

// Nos conectamos con la base de datos.
$database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
$db_connection = $database->getConnection();
 
$api_key = $_GET['key']; // Obtenemos la llave da la URL.

$stmt = validate($api_key, $db_connection); // Prepared statement para validar la api key.

if($stmt->rowCount() > 0){
    // Petición.
    $query = "SELECT * FROM dogs ORDER BY RAND() LIMIT 20";

    // Preparamos la petición.
    $stmt = $db_connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    // Imprimimos los datos de los perros.
    while($row = $stmt->fetch()) {
        // Llenamos el arreglo con la información de los registros.
        $info_arr = array(
            "id" => $row["id"],
            "name" => $row["name"],      
            "imagen" => $row["imagen"], 
            "likes" => $row["likes"]
        );
        print_r(json_encode($info_arr)); // Pasamos el array a json.
        echo "<br>";                     // Salto de línea para el siguiente perro.
    }
}
else{
    // En el caso de que la llave no exista.
    $info_arr = array(
        "message" => "invalid key"
    );

    print_r(json_encode($info_arr)); 
}

?>