<?php

/**
 * Clase para modelar la base de datos.
 */
class DataBase {

    // Propiedades de la clase.
    private $_host;
    private $_database_name;
    private $_user_name;        
    private $_password;
    public $connection;

    /**
     * Constructor de la clase.
     */
    public function __construct($host, $database_name, $user_name, $password) {
        $this->_host = $host;
        $this->_database_name = $database_name;
        $this->_user_name = $user_name;
        $this->_password = $password;
    }

    /**
     * Devuelve la conexión a la base de datos.
     */
    public function getConnection() {
        $link = "mysql:host=" . $this->_host . ";dbname=" . $this->_database_name;

        $this->connection = null;
 
        try {
            $this->connection = new PDO($link, $this->_user_name, $this->_password);
            $this->connection->exec("set names utf8");
        } catch(PDOException $e){
            echo "Error en la conexión: " . $e->getMessage() . "<br>";
            die();
        }
 
        return $this->connection;
    }

    public function getHost() {
        return $this->_host;
    }

    public function setHost($host) {
        $this->_host = $host;
    }

    public function getDataBaseName() {
        return $this->_database_name;
    }

    public function setDataBaseName($database_name) {
        $this->_database_name = $database_name;
    }

    public function getUserName() {
        return $this->_user_name;
    }

    public function setUserName($user_name) {
        $this->_user_name = $user_name;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($password) {
        $this->_password = $password;
    }
}

?>