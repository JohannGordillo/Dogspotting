<?php
require 'base.php';

// Escape user inputs for security
//Note: The mysqli_real_escape_string() function escapes special 
//characters in a string and create a legal SQL string to provide security against SQL injection.
$api_key = $mysqli->real_escape_string($_REQUEST['key']);
$dog_id = $mysqli->real_escape_string($_REQUEST['dog_id']);
$cero  = 0;

// Attempt select query execution
$sql = "SELECT id FROM user WHERE api_key = '$api_key'";

if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
            
        while($row = $result->fetch_object()){
            $user_id = $row->id ;
        }

        // Attempt insert query execution into likes
        $sql ="INSERT INTO likes (dog_id, user_id)  VALUES ('$user_id', '$dog_id')";
        if($mysqli->query($sql) === true){
            echo "Records inserted into likes successfully.\n";
        } else{
            echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
        }

        // Attempt insert query execution into dog
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
