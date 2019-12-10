<?php

/**
* ARCHIVO USER.
* Contiene la clase para modelar usuarios de la red social.
*
* PHP version 7.
*
* @author  Johann Gordillo
* @author  Jhovan Gallardo
* @author  Diana Nicolas
* @license http://www.opensource.org/licenses/mit-license.html  MIT License
*/


/**
 * Clase para modelar usuarios.
 */
class User{
 
    // Propiedades de la clase.
    private $_connection;
    private $_table_name = "user";
    private $_id;
    private $_user_name;
    private $_password;
    private $_api_key;
 
    /**
     * Constructor para la clase.
     * @param $db_connection. La conexion a la base de datos.
     * @param $user_name. El nombre de usuario.
     * @param $password. La contraseña del usuario.
     */
    public function __construct($db_connection, $user_name, $password){
        $this->_connection = $db_connection;
        $this->_user_name = $user_name;
        $this->_password = $password;
        $this->_api_key = hash('sha256', $this->_user_name . $this->_password);
    }
    
    public function getUserID() {
        return $this->_id;
    }

    public function setUserID($id) {
        $this->_id = $id;
    }

    public function getUserPassword() {
        return $this->_password;
    }

    public function setUserPassword($password) {
        $this->_password = $password;
    }

    public function getUserName() {
        return $this->_user_name;
    }

    public function setUserName($user_name) {
        $this->_user_name = $user_name;
    }

    public function getApiKey() {
        return $this->_api_key;
    }

    public function setApiKey($api_key) {
        $this->_api_key = $api_key;
    }

    /**
     * Función para registrar al usuario.
     */
    public function signup(){
        // Si el usuario ya existe en la base, regresamos 'false'.
        if($this->exists()){
            return false;
        }

        // Petiión para insertar al usuario.
        $query = "INSERT INTO " . $this->_table_name . " (name, password, api_key) VALUES (" 
                    . "'" . $this->_user_name . "', '" . $this->_password . "', '" . $this->_api_key . "')";

        // Preparamos la petición.
        $stmt = $this->_connection->prepare($query);
    
        // Ejecutamos la petición.
        if($stmt->execute()){
            $this->_id = $this->_connection->lastInsertId();
            return true;
        }
    
        return false;
    }

    /**
     * Función para logearse.
     */
    public function login(){
        // Petición.
        $query = "SELECT `id`, `name`, `password` FROM " . $this->_table_name . " WHERE
                    name='" . $this->_user_name . "' AND password='" . $this->_password .  "'";

        // Preparamos la petición.
        $stmt = $this->_connection->prepare($query);

        // Ejecutamos la petición.
        $stmt->execute();

        return $stmt;
    }

    /**
     * Función que nos dice si el usuario ya existe en la base de datos.
     */
    public function exists(){
        // Petición.
        $query = "SELECT * FROM " . $this->_table_name . " WHERE name='" . $this->_user_name . "'";
        
        // Declaración preparada (prepared statement).
        $stmt = $this->_connection->prepare($query);

        // Ejecutamos la petición.
        $stmt->execute();

        // Si el número de filas es mayor a cero, el usuario existe en la base de datos,
        // y regresamos 'true'. Si no, regresamos 'false'.
        if($stmt->rowCount() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
}

?>