<?php

/**
* ARCHIVO SIGNUP.
* Modela el registro de un nuevo usuario en la red social.
*
* Dados en la url los parámetros GET username y password, 
* se verifica que el username no exista en la tabla de 
* usuarios de la base de datos. Si el username ya existe,
* no se agrega nada; de otra manera, se agrega el usuario
* a la tabla.
*
* PHP version 7.
*
* @author  Johann Gordillo
* @author  Jhovan Gallardo
* @license http://www.opensource.org/licenses/mit-license.html  MIT License
*/

// Incluimos los archivos necesarios.
include_once '../config/database.php';
include_once '../objects/user.php';

// Datos necesarios para conectarnos con la base de datos.
$db_host = "localhost";
$db_name = "dogspotting";
$db_user_name = "root";
$db_password = "";    

// Nos conectamos con la base de datos.
$database = new DataBase($db_host, $db_name, $db_user_name, $db_password);
$db_connection = $database->getConnection();

// Tomamos el nombre de usuario y la contraseña de la URL.
$user_name = $_GET['username'];
$user_password = $_GET['password'];
      
// Instanciamos un nuevo usuario.
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

print_r(json_encode($user_arr));  // Pasamos a json.

?>