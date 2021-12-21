<?php

require_once('db/conexion.php');

class db_usuarios extends conexion{

    function __construct(){
        parent::__construct();
    }

    /*
    Funciones para ejecutar
    Se desarrollan las funciones necesarias
    ...
    */

    

    /*
    Funciones para obtener datos
    */

    function get_usuario_login($data){

        extract($data);

        $this->conectar();

        $user = mysqli_real_escape_string($this->con, $user);
        $pass = mysqli_real_escape_string($this->con, $pass);
        $pass = md5($pass);

        $sql = "call sp_get_usuario_login('$user', '$pass');";
        return $this->get_datos($sql);

    }

    

}


?>