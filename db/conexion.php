<?php

class conexion{

    var $settings;
    var $con;

    function __construct(){

        $this->settings = array(
            'host'  => 'localhost',
            'user'  => 'root',
            'pass'  => '',
            'db'    => 'db_practica_7'
        );

    }


    function conectar(){

        extract($this->settings);

        $this->con = mysqli_connect(
            $host, 
            $user,
            $pass,
            $db
            ) or die ('Error de conexión');

    }


    function desconectar(){
        mysqli_close($this->con);
    }


    
    // RUD

    function ejecutar($sql){

        $this->conectar();

        $result = mysqli_query($this->con, $sql);

        $error = false;

        if(!$result){
            $error = mysqli_error($this->con);
        }

        $this->desconectar();

        return array(
            'result'    => $result,
            'error'     => $error
        );

    }



    // C

    function get_datos($sql){

        $result = $this->ejecutar($sql);
        extract($result);

        $rows = array();

        if($result){

            while($row = mysqli_fetch_array($result)){
                $rows[] = $row;
            }

        }

        return $rows;

    }



}

?>