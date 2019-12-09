<?php
require 'base.php';

// Se obtienen los valores GET
$api_key = $mysqli->real_escape_string($_REQUEST['key']);
$dog_id = $mysqli->real_escape_string($_REQUEST['dog_id']);

// Se define el query para recuperar al usuario de la llave
$sql = "SELECT id FROM user WHERE api_key = '$api_key'";

if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
            
        while($row = $result->fetch_object()){
            $user_id = $row->id ;
        }

        // Inserta un nuevo like en la tabla likes
        $sql ="INSERT INTO likes (dog_id, user_id)  VALUES ('$user_id', '$dog_id')";
        if($mysqli->query($sql) === true){
            echo "Records inserted into likes successfully.\n";
        } else{
            echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
        }

        // Incrementa el contador de likes del perro en la base de datos
        $sql ="UPDATE dog SET likes = likes + 1 WHERE id = '$dog_id'";
        if($mysqli->query($sql) === true){
            echo "Records inserted into dog successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
        }

        // Free result set
        $result->free();
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
}


 
// Close connection
//$mysqli->close();
?>
