<?php

require_once('ui/ui_proyectos.php');

$settings = array(
    'title' => 'Proyectos',
    'url'   => 'proyectos.php',
);

$ui = new ui_proyectos($settings);
$ui->action_controller();
$ui->build();

?>