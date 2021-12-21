<?php

class UI{
    var $settings;
    var $sec;

    function __construct($set=false){
        $this->settings = array(
            'title'     => 'TITULO',
            'url'       => ''
        );
        if($set){
            $this->settings = array_merge($this->settings, $set);
        }
    }

    function get_header($admin=true){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <title></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?php $this->get_css(); ?>
        </head>
        <body>

        <?php if($admin){ ?>
            <!--Header-part-->
            <div id="header">
            
            </div>
            <!--close-Header-part--> 
            <?php
            $this->get_menu_top();
            $this->get_menu_side();
        }
    }

    function get_css(){
        ?>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="assets/css/fullcalendar.css" />
        <link rel="stylesheet" href="assets/css/matrix-style.css" />
        <link rel="stylesheet" href="assets/css/matrix-media.css" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/css/jquery.gritter.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <?php
    }

    function get_menu_top(){
        ?>
        <!--top-Header-menu-->
        <!--close-top-Header-menu-->
        <?php
    }

    function get_menu_side(){
        $menu = array(
            array(
                'url'   => 'personas.php',
                'text'  => 'Personas',
                'icon'  => 'icon-user'
            ),
        );

        ?>
        <!--sidebar-menu-->
        <div id="sidebar">
            <ul>
                <li>
                    <a class="active" href="personas.php"><span>Empleados</span></a> 
                    <a class="active" href="proyectos.php"><span>Proyectos</span></a> 
                </li>
            </ul>
        </div>
        <!--sidebar-menu-->
        <?php
    }

    function get_footer(){
        ?>
        <!--Footer-part-->
        <div class="row-fluid">
        <div id="footer" class="span12"> </div>
        </div>

        <!--end-Footer-part-->
        <?php $this->get_js(); ?>
        </body>
        </html>
        <?php
    }

    function get_js(){
        ?>
        <?php
    }

    function get_breadcrumbs(){
        ?>
        <!--breadcrumbs-->
        <div id="content-header"> 
            <h1><?=$this->settings['title'];?></h1>
        </div>
        <!--End-breadcrumbs-->
        <?php
    }

    // NO SE TOCA
    function get_form(){}

    // NO SE TOCA
    function get_table(){}

    function get_content(){

        ?> 
        <div id="content">
            <?php $this->get_breadcrumbs(); ?>
            <div class="container-fluid">
                <div class="row-fluid">
                    <!-- FORMULARIO -->
                    <div class="span5">
                        <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-edit"></i> </span>
                            <h5>Formulario</h5>
                        </div>
                        <div class="widget-content"><?php $this->get_form(); ?></div>
                        </div>
                    </div>
                    <!-- TABLA -->
                    <div class="span7">
                        <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-list"></i> </span>
                            <h5>Lista de Registros</h5>
                        </div>
                        <div class="widget-content"><?php $this->get_table(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    function build(){
        $this->get_header();
        $this->get_content();
        $this->get_footer(); 

    }
}
?>