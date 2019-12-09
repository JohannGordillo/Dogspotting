<?php
require 'base.php';

// Se obtienen los valores POST
$api_key = $_POST["api_key"];
$dog_id = $_POST["dog_id"];
$texto = $_POST["texto"];

// Se define el query para recuperar al usuario de la llave
$sql = "SELECT id FROM user WHERE api_key = '$api_key'";

if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
            
        while($row = $result->fetch_object()){
            $user_id = $row->id ;
        }

        // Inserta el comentario en la tabla comment
        $sql ="INSERT INTO comment (dog_id, user_id, texto)  VALUES ('$dog_id','$user_id', '$texto')";
        if($mysqli->query($sql) === true){
            echo "Records inserted into comment successfully.\n";
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
