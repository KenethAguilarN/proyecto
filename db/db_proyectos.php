<?php

require_once('db/conexion.php');

class db_proyectos extends conexion{

    function __construct(){
        parent::__construct();
    }

    /*
    Funciones para ejecutar
    */

    function insert($data){

        extract($data);

        $sql = "call sp_insert_persona(
            '$nombre', 
            '$fecha_inicio', 
            '$fecha_fin', 
            '$provincia',
            '$descripcion'
        );";

        return $this->ejecutar($sql);

    }


    function update($data){

        extract($data);

        $sql = "call sp_update_persona(
            '$id_persona', 
            '$nombre', 
            '$fecha_inicio', 
            '$fecha_fin', 
            '$provincia',
            '$descripcion'
        );";

        return $this->ejecutar($sql);

    }

    


    function delete($id){
        $sql = "call sp_delete_persona($id);";
        return $this->ejecutar($sql);
    }



    /*
    Funciones para obtener datos
    */

    function get_proyectos($buscar=""){
        $sql = "call sp_get_personas('$buscar');";
        return $this->get_datos($sql); 
    }


    function get_proyecto($id){
        $sql = "call sp_get_persona($id);";
        return $this->get_datos($sql); 
    }



}


?>