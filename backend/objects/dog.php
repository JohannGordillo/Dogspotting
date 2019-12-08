<?php

/**
 * Clase para modelar perros.
 */
class Dog{
 
    // Propiedades de la clase.
    private $_connection;
    private $_table_name = "dogs";
    private $_id;
    private $_dog_name;
    private $_imagen;
    private $_likes;
 
    /**
     * Constructor para la clase.
     * @param $db_connection. La conexion a la base de datos.
     */
    public function __construct($db_connection, $dog_name, $imagen){
        $this->_connection = $db_connection;
        $this->_dog_name = $dog_name;
        $this->_imagen = $imagen;
        $this->_likes = 0;
    }

    /**
     * Función para insertar al perro en la Base de Datos.
     */
    public function insertar(){
        // Si el perro ya existe en la base, regresamos 'false'.
        if($this->exists()){
            return false;
        }

        // Petición para insertar al perro en la base.
        $query = "INSERT INTO " . $this->_table_name . " (name, imagen, likes) VALUES (" 
                    . "'" . $this->_dog_name . "', '" . $this->_imagen . "', '" . $this->_likes . "')";

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
     * Función que nos dice si el perro ya existe en la base de datos.
     */
    public function exists(){
        // Petición.
        $query = "SELECT * FROM " . $this->_table_name . " WHERE username='" . $this->_dog_name . "'";
        
        // Declaración preparada (prepared statement).
        $stmt = $this->_connection->prepare($query);

        // Ejecutamos la petición.
        $stmt->execute();

        // Si el número de filas es mayor a cero, el perro existe en la base de datos,
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