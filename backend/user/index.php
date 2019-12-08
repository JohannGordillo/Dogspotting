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

$mysqli = new mysqli("localhost", "root", "", "dogspotting"); // MODIFICAR. Para usar con PDO, no con mysqli.

if($stmt->rowCount() > 0){
    $sql = "SELECT * FROM dogs";  // MODIFICAR. Esta query imprimirá todos los perros de la tabla.
    $list = [];
    if($result = $mysqli->query($sql)){
        if($result->num_rows > 0){     
            while($row = $result->fetch_object()){
                array_push($list, $row);
            }
            $result->free();
        } else{
            echo "No records matching your query were found.";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
    }
    echo json_encode($list);
}
else{
    $info_arr = array(
        "message" => "invalid key"
    );

    print_r(json_encode($info_arr));  
}
?>