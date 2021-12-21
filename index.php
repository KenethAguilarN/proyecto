<?php

require_once('ui/ui_personas.php');

$settings = array(
    'title' => 'Empleados',
    'url'   => 'personas.php',
);

$ui = new ui_personas($settings);
$ui->action_controller();
$ui->build();

?>