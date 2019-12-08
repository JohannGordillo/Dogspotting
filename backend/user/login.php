<?php

    include_once '../config/database.php';
    include_once '../objects/user.php';
     
    $db_host = "localhost";
    $db_name = "dogspotting";
    $db_user_name = "root";
    $db_password = "";    

    $database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
    $db_connection = $database->getConnection();
      
    if(isset($_GET['username']) && isset($_GET['password'])) {
        $user_name = $_GET['username'];
        $user_password = $_GET['password'];
          
        $user = new User($db_connection, $user_name, $user_password);
    }
    else {
        die();
    }

    $stmt = $user->login();

    if($stmt->rowCount() > 0){
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         
        $user_arr = array(
            "status" => "ok",
            "key" => $user->getApiKey()
        );
    }
    else{
        $user_arr = array(
            "status" => "failed",
            "message" => "the username doesn't exist"
        );
    }
    
    print_r(json_encode($user_arr)); 

?>