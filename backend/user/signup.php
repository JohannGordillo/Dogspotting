<?php
     
    include_once '../config/database.php';
    include_once '../objects/user.php';

    $db_host = "localhost";
    $db_name = "dogspotting";
    $db_user_name = "root";
    $db_password = "";    

    $database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
    $db_connection = $database->getConnection();

    $user_name = $_GET['username'];
    $user_password = $_GET['password'];
      
    $user = new User($db_connection, $user_name, $user_password);
      
    if($user->signup()) {
        $user_arr = array(
            "status" => "ok"
        );
    }
    else {
        $user_arr = array(
            "status" => "failed",
            "message" => "this username has been used"
        );
    }

    print_r(json_encode($user_arr));

?>