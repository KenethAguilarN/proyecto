<?php
require_once('UI.php');
require_once('ln/ln_proyectos.php');

class ui_proyectos extends UI{
    var $ln;

    function __construct($set=false){
        parent::__construct($set);
        $this->ln = new ln_proyectos();
    }

    function action_controller(){
        $this->ln->action_controller();
    }

    function get_form(){
        $text_btn   = 'REGISTRAR';
        $action     = 'insert';

        $data = array(
            'id_persona'    => -1,
            'nombre'        => '',
            'fecha_inicio'  => '',
            'fecha_fin'     => '',
            'periodo'       => '',
            'provincia'     => '',
            'descripcion'   => '',
        );
        
        if(isset($_GET['view'])){
            if($_GET['view']=='edit'){
                $data = $this->ln->get_persona(($_GET['id']));
                $text_btn   = 'ACTUALIZAR';
                $action     = 'update';
            }
        }
        extract($data);
        ?>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <script>
            $(document).ready(function(e){
                /* 
                DATE RANGE PICKER 
                https://www.daterangepicker.com/
                */
                $('input[name="periodo"]').daterangepicker({
                    locale: {
                        format: "DD-MM-YYYY",
                    },
                    ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    alwaysShowCalendars: true,
                    autoApply: true,
                });
            });
        </script>

        <style>
            .table-condensed th, .table-condensed td {
                padding: 4px 2px;
            }
        </style>
       
        <!-- AUTOCOMPLETE -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function(e){
                /* 
                AUTOCOMPLETE - SELECT2 
                https://select2.org/getting-started/installation
                */
                $(document).ready(function(){
                    $(".select").select2();
                });
            });
        </script>

        <form action="proyectos.php?action=<?=$action;?>" method="POST">
            <input type="hidden" name="id_persona" value="<?=$id_persona;?>">
           
            <label>Nombre</label>
            <input class="form-control span12" name="nombre" type="text" value="<?=$nombre;?>">
            
            <label>Período de Trabajo</label>
            <input class="form-control span12" name="periodo" type="text" value="<?=$periodo;?>">

            <div class="clearfix"></div>
            
            <label>Rol</label>         
            <select class="form-control span12 select" name="provincia">
                <option>Seleccione un Rol</option>
                <?php 
                $provincias = array(
                    'Analista', 
                    'Diseñador',
                    'Programador',
                    'DBA',
                    'Tester'
                );
                ?>
                <?php foreach($provincias as $p){ ?>
                    <option value="<?=$p;?>" <?=($p==$provincia?'selected':'');?>>
                        <?=$p;?>
                    </option>
                <?php } ?>
            </select>
            <br>
            <hr>
            <button class="btn btn-primary"><?=$text_btn?></button>
            <a href="proyectos.php" class="btn btn-info pull-right"><i class="icon icon-plus"></i> Nuevo</a>
        </form>
        <?php
    }

    function get_table(){
        $buscar = "";

        if(isset($_GET['buscar'])){
            $buscar = $_GET['buscar'];
        }
        $datos = $this->ln->get_proyectos($buscar);
        ?>

        <!-- DATA TABLE -->
        <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" />
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function(e){
                /* 
                DATA TABLE 
                https://datatables.net/examples/basic_init/zero_configuration.html
                */
                $(document).ready(function(){
                    $('.datatable').DataTable();
                });
            });
        </script>   

        <style>
            .dataTables_filter {
                top: 0;
            }
        </style>

        <div class="text-left pull-left">
            <a target="_blank" class="btn btn-danger btn-lg" href="pdf_proyectos.php?action=download_personas">
                <i class="icon icon-file"></i> Descargar PDF</a>
        </div>

        <div class="clearfix"></div>
        <hr>
        
        <table class="table table-hover table-bordered datatable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Entrega</th>
                    <th>Dias para entrega</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>

            <tbody>
            
                <?php foreach($datos as $item){ ?>
                <tr>
                    <td><?=$item['nombre'];?></td>
                    <td><?=$this->ln->get_date_range_to_out($item);?></td>
                    <td><?=$item['provincia'];?></td>
                    <td><?=$item['descripcion'];?></td>
                    <td>
                        <a class="btn btn-warning" href="proyectos.php?view=edit&id=<?=$item['id_persona'];?>">
                            <span class="icon icon-edit"></span>
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="proyectos.php?action=delete&id=<?=$item['id_persona'];?>">
                            <span class="icon icon-remove"></span>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <style>
            table img{
                max-width: 150px;
            }
        </style>
        <?php
    }
}
?>