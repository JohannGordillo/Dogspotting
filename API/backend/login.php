<?php

/**
* ARCHIVO LOGIN.
* Modela el inicio de sesión de un usuario en la red social.
*
* Dados en la url los parámetros GET username y password, 
* se verifica que el username y la contraseña sean correctos. 
* Si lo son, se muestra la api key única para cada usuario, con
* la que se podrá hacer uso de la API.
*
* PHP version 7.
*
* @author  Johann Gordillo
* @author  Jhovan Gallardo
* @license http://www.opensource.org/licenses/mit-license.html  MIT License
*/

// Incluimos los archivos necesarios.
include_once 'database.php';
include_once 'user.php';
     
// Datos necesarios para conectarnos con la base de datos.
$db_host = "localhost";
$db_name = "id11870230_base";
$db_user_name = "id11870230_admin";
$db_password = "password";   

// Nos conectamos con la base de datos.
$database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
$db_connection = $database->getConnection();
      
// Tomamos el nombre de usuario y la contraseña de la URL.
if(isset($_GET['username']) && isset($_GET['password'])) {
    $user_name = $_GET['username'];
    $user_password = $_GET['password'];
          
    // Instanciamos un nuevo usuario.
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
    
print_r(json_encode($user_arr)); // Pasamos el arreglo obtenido a json.

?>