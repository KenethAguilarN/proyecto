<?php

require_once('db/db_personas.php');

class ln_personas{

    var $db;

    function __construct(){
        $this->db = new db_personas();
    }


    function action_controller(){

        if(isset($_GET['action'])){

            switch($_GET['action']){

                case 'insert':
                    $this->insert($_POST);
                break;
                
                case 'update':
                    $this->update($_POST);
                break;
                
                case 'delete':
                    $this->delete($_GET['id']);
                break;
                

            }

            exit();

        }

    }


    


    /*
    Funciones para ejecutar
    */

    // Obtener las fechas para insertar en DB

    function get_date_range_to_in($fechas){

        $partes = explode(' - ', $fechas);

        $f1 = date("Y-m-d", strtotime($partes[0]));
        $f2 = date("Y-m-d", strtotime($partes[1]));

        return array(
            'fecha_inicio'  => $f1,
            'fecha_fin'     => $f2,
        );

    }


    // Obtener la fecha única para mostrar en UI

    function get_date_range_to_out($data){

        $f1 = date("d/m/Y", strtotime($data['fecha_inicio']));
        $f2 = date("d/m/Y", strtotime($data['fecha_fin']));

        return $f1.' - '.$f2;
        //return '04/29/2020 - 04/29/2020';

    }



    function insert($data){
        
        // Se obtiene el rango de fechas y se divide.
        $periodo = $this->get_date_range_to_in($data['periodo']);

        // Se mezcla las fechas de $periodo con los datos que venían del formulario
        $data = array_merge($data, $periodo);  
        
        $result = $this->db->insert($data);

        header('Location:personas.php');

    }

    
    function update($data){

        // Se obtiene el rango de fechas y se divide.
        $periodo = $this->get_date_range_to_in($data['periodo']);

        // Se mezcla las fechas de $periodo con los datos que venían del formulario
        $data = array_merge($data, $periodo);
        
        $result = $this->db->update($data);
        header('Location:personas.php?view=edit&id='.$data['id_persona']);

    }

    function delete($id){
        $result = $this->db->delete($id);
        header('Location:personas.php');
    }


    /*
    Funciones para obtener datos
    */

    function get_personas($buscar=""){
        return $this->db->get_personas($buscar);
    }

    function get_persona($id){
        $result = $this->db->get_persona($id);
        if($result){
            
            // Generamos el periodo y se lo asignamos al resultado para ser utilizado en UI
            $data = $result[0];
            $data['periodo'] = $this->get_date_range_to_out($data);

            return $data;

        }else{
            return false;
        }
    }


}

?>