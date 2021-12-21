<?php
require_once('ln/ln_proyectos.php');
require_once('libs/fpdf/fpdf.php');

class ln_pdf_proyectos extends FPDF{
    var $ln_proyectos;

    function __construct(){
        
        // Configuraciones de FPDF
        parent::__construct('P', 'mm', 'Letter');
        $margin = 10;
        $this->SetMargins($margin, $margin, $margin);

        // Utilizo los objetos propios de mi sistema
        $this->ln_proyectos = new ln_proyectos();
    }

    // se puede emplear un action_controller como lo hemos hecho hasta el momento
    function action_controller(){
        if(isset($_GET['action'])){
            switch($_GET['action']){
                case 'save_personas':
                    $this->export("F");
                break;
                case 'download_personas':
                    $this->export("D");
                break;
                case 'view_personas':
                    $this->export("I");
                break;
                default:
                    $this->export();
                break;
            }
        }
    }

    // utilizamos esta función para empaquetar todo el trabajo final
    function export($output="I"){
        // Aquí se inicia la página, automáticamente agregará las que necesite
        $this->AddPage();

        // Aquí se genera el contenido, en este caso una tabla con personas
        // Pero, si fuera el caso, se podría generar un switch para llamar otros get_table y hacerlo
        // más modular...
        $this->get_table_personas();
        

        // Esto ayuda a definir donde y cómo se guardará el archivo
        if($output=="F"){
            $path = "assets/pdf/rpt_proyectos_(".date('Y-m-d').").pdf";
        }else{
            $path = "rpt_proyectos_(".date('Y-m-d').").pdf";
        }

        // Este método es el que genera como tal el PDF
        /*
        I: envía el fichero al navegador de forma que se usa la extensión (plug in) si está disponible.
        D: envía el fichero al navegador y fuerza la descarga del fichero con el nombre especificado por name.
        F: guarda el fichero en un fichero local de nombre name.
        */
        $this->Output($output, $path);

    }

    // Se puede utilizar esta función como plantilla para exportar otros contenidos
    function get_table_personas(){
        $header = array('Nombre', 'Rol', 'Años Lavorados');
        $data = $this->ln_proyectos->get_proyectos();
        /* 
        Anchuras de las columnas
        Deben sumar 195 para este ejemplo, dependerá del margin 
        y demás configuraciones de la página
        */
        $w = array(60, 60, 60);

        $this->SetFont('Arial','B',10);
        $this->SetFillColor(0,0,0);
        $this->SetTextColor(255);

        // Cabeceras
        for($i=0;$i<count($header);$i++){
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'L', true);
        }
        $this->Ln();

        $h = 10;
        $border = 'LRB';
        $this->SetTextColor(50);

        // Datos
        foreach($data as $item){
            $this->Cell($w[0], $h, utf8_decode($item['nombre']), $border);
            $this->Cell($w[1], $h, utf8_decode($item['fecha_inicio']), $border);
            $this->Cell($w[2], $h, utf8_decode($item['fecha_fin']), $border);
            $this->Ln();
        }
        
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

    /*
    Estos métodos se heredan de FPDF y se reescriben según se necesite, 
    parecido a lo que habíamos hecho en UI
    */

    // Cabecera de página
    function Header(){
        // Logo
        // $this->Image('assets/img/logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        $this->SetTextColor(0,0,0);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(0,10,'Reporte de Proyectos','B',0,'R');
        // Salto de línea
        $this->Ln(20);

        $this->SetTextColor(0);
    }

    // Pie de página
    function Footer(){
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,$this->PageNo(),0,0,'R');
    }
}
?>