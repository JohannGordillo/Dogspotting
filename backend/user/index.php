<?php

include_once '../config/database.php';
include_once '../objects/dog.php';
include_once '../objects/user.php';

/**
 * Función para validar que la api key ingresada sea valida.
 */
function validate($api_key, $connection) {
    $query = "SELECT `apikey` FROM users" . " WHERE apikey='" . $api_key . "'";

    // Preparamos la petición.
    $stmt = $connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    return $stmt;
}

$db_host = "localhost";
$db_name = "dogspotting";
$db_user_name = "root";
$db_password = "";    

$database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
$db_connection = $database->getConnection();
 
$api_key = $_GET['key'];

$stmt = validate($api_key, $db_connection);

$mysqli = new mysqli("localhost", "root", "", "dogspotting"); 

if($stmt->rowCount() > 0){
    $query = "SELECT * FROM dogs";

    $stmt = $db_connection->prepare($query);

    // Ejecutamos la petición.
    $stmt->execute();

    while($row = $stmt->fetch()) {
        // Imprimimos la información de cada perro.
        $info_arr = array(
            "id" => $row["id"],
            "name" => $row["name"],
            "imagen" => $row["imagen"],
            "likes" => $row["likes"]
        );
        print_r(json_encode($info_arr)); 
    }

}
else{
    $info_arr = array(
        "message" => "invalid key"
    );

    print_r(json_encode($info_arr));  
}
?>