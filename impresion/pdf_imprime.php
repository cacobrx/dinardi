<?php
/*
 * creado el 09/02/2018 17:34:00
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: pdf_imprime
 */

require 'pdf_function.php';

class alu_cuo_recibo extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;
    
    function addDetalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_alu.php';
        require_once 'clases/adm_plan.php';
        $sup=new support();
        $dsup=new datesupport();
        global $cartel;
        global $cuo;

        global $nombreemp;
        global $direccionemp;
        global $telefonoemp;
        global $detalleabono;
        
        $alu=new adm_alu_1($cuo->getIdalu());
        $plan=new adm_plan_1($cuo->getIdplan());
        $numero=$cuo->getRecibo();
        $fechapago=$cuo->getFechapago();
        $cuotades=$cuo->getCuotades();
        $totalcuotas=10;
        $importepago=$cuo->getImportepag();
        
        $nro="";
        for($i=0;$i<count($numero);$i++) {
            $nro.=$sup->AddZeros($numero[$i], 8)." / ";
        }
        if($nro!="") $nro=substr($nro,0,strlen($nro)-3);

        $r1=5;
        $r2=205;
        $y1=15;
        $y2=120;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');  
        $this->addCliente( $nombreemp,$direccionemp, $telefonoemp);
        $this->fact_dev( "RECIBO Nro. $nro",0,125);
        $this->addDate(date("d/m/Y", strtotime($fechapago[0])));
        if($cuo->getCuota()>0 and $cuo->getCuota()<99)
            $this->addPageNumber(utf8_decode($cuo->getCuotades())."/".$totalcuotas);
        else
            $this->addPageNumber(utf8_decode ($cuotades));
        $this->SetFont("Arial","",10);
        $this->SetXY(10,20);
        $this->Cell(30,5,"Alumno:",0,1);
        $this->Cell(30,5,utf8_decode("Dirección:"),0,1);
        $this->Cell(30,4,"Ciudad",0,1);
        $this->SetXY(30,20);
        $this->SetFont("Arial","B",10);
        $this->Cell(100,5,$alu->getLegajo()." - ".utf8_decode($alu->getApellido()." ".$alu->getNombre()),0,1);
        $this->SetX(30);
        $this->Cell(100,5,utf8_decode($alu->getDireccion()),0,1);
        $this->SetX(30);
        $this->Cell(100,5,utf8_decode($alu->getCiudaddes()),0,1);
        $this->line(5,$this->GetY(),205,$this->GetY()); 
        $this->SetX(10);
        $this->Cell(100,5,"Detalle",0,0,"L");
        if($cuo->getRecargo()>0) {
            $this->SetX(160);
            $this->Cell(20,5,"Recargo",0,0,"R");
        }
        $this->SetX(180);
        $this->Cell(20,5,"Importe",0,1,"R");
        $this->line(5,$this->GetY(),205,$this->GetY()); 
        $this->SetFont("Arial","",10);
        $this->SetX(10);
        $this->Cell(100,5, utf8_decode($cuo->getCuotades()),0,1);
        $this->Cell(100,5,utf8_decode("Plan de Estudios: ".$plan->getNombre()),0,1);
        $this->Cell(100,5,"Vencimiento: ".$dsup->getFechaNormalCorta($cuo->getFechaven()),0,0);
        if($cuo->getRecargo()>0) {
            $this->SetX(160);
            $this->Cell(20,5,number_format($cuo->getImporte(),2),0,0,"R");
            $this->SetX(180);
            $this->Cell(20,5,number_format($cuo->getRecargo(),2),0,1,"R");

        } else {
            $this->SetX(180);
            $this->Cell(20,5,number_format($cuo->getImporte(),2),0,1,"R");
        }
        $this->SetFillColor(0);
        $r1=140;
        $r2=205;
        $y1=105;
        $y2=120;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->SetFont("Arial","B",16);
        $this->SetXY(140,108);
        $this->Cell(65,10,number_format(array_sum($importepago),2),0,0,"C");
        //$this->Image("images/logopagofacil.png", 130, 80,20,20);
    }


    
}

class PDF_alu extends pdf_function
{
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $nombreemp;
    global $telefonoemp;
    global $colu;
     $this->addCliente( $nombreemp,$telefonoemp);
    //$this->Image("images/logomaral.png",5,5,40,20);
    
    $this->fact_dev( "Alumnos",0,100);
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());
    $this->addPageNumber($this->PageNo());
    $r1=5;
    $r2=205;
    $y1=35;
    $y2=290;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);
    $this->SetFont("Arial","B",10);
    $this->setX($colu[0]);
    $this->Cell(10,5,"Legajo",0,0,"C");
    $this->SetX($colu[1]);
    $this->Cell(15,5,"Alumno",0,0,"L");
    $this->SetX($colu[2]);
    $this->Cell(15,5,"Documento",0,0,"L");
    $this->SetX($colu[3]);
    $this->Cell(10,5,"Ciudad",0,1,"L");


    
}

function addDetalle() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $cartel;

        global $a_leg;
        global $a_ape;
        global $a_nom;
        global $a_doc;
        global $a_ciu;              

        global $colu;

    $this->SetFont('Arial','',8);
    for($i=0;$i<count($a_leg);$i++) {
        $this->SetX($colu[0]);
        $this->Cell(10,5,$a_leg[$i],0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,utf8_decode(substr($a_ape[$i]." ".$a_nom[$i],0,30)),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5, $a_doc[$i],0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(15,5, utf8_decode($a_ciu[$i]),0,1,"L");    
        
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        
    }
 
}


}

class PDF_alu_asi_prn extends pdf_function
{
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $nombreemp;
    global $telefonoemp;
    global $colu;
    global $cartel;
     $this->addCliente( $nombreemp,$telefonoemp);
    //$this->Image("images/logomaral.png",5,5,40,20);
    
    $this->fact_dev( "Asistencia",0,125);
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());(
    $this->addPageNumber($this->PageNo());
    $this->SetX(10);
    $this->Cell(10,5, utf8_decode($cartel));
    $r1=5;
    $r2=205;
    $y1=35;
    $y2=290;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);
    $this->SetFont("Arial","B",8);
    $this->setX($colu[0]);
    $this->Cell(10,5,"Materia",0,0,"L");
    $this->SetX($colu[1]);
    $this->Cell(15,5,"Precentes",0,0,"C");    
    $this->SetX($colu[2]);
    $this->Cell(15,5,"Ausentes",0,0,"C");
    $this->SetX($colu[3]);
    $this->Cell(15,5,"Total",0,0,"C");
    $this->SetX($colu[4]);
    $this->Cell(15,5,"%Precentes",0,1,"C");
    
    $this->Line(5, $this->GetY(), 205, $this->GetY());


    
}

function addDetalle() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $cartel;

        global $a_mat;
        global $a_pre;
        global $a_aus;
        global $a_tot;
        global $a_por;
        global $colu;

    $this->SetFont('Arial','',8);
    for($i=0;$i<count($a_mat);$i++) {
        $this->SetX($colu[0]);
        $this->Cell(10,5,$a_mat[$i],0,0,"L");
        $this->SetX($colu[1]);
        $this->Cell(10,5,$a_pre[$i],0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(10,5,$a_aus[$i],0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(10,5,$a_tot[$i],0,0,"C");
        $this->SetX($colu[4]);
        $this->Cell(15,5,number_format($a_por[$i],2),0,1,"R");
        
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        
    }
 
}


}

class PDF_alu_not extends pdf_function
{
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $nombreemp;
    global $telefonoemp;
    global $colu;
    global $cartel;
     $this->addCliente( $nombreemp,$telefonoemp);
    //$this->Image("images/logomaral.png",5,5,40,20);
    
    $this->fact_dev( "NOTAS DEL ALUMNO",0,125);
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());
    $this->addPageNumber($this->PageNo()); 
    $this->SetX(10);
    $this->Cell(10,5, utf8_decode($cartel));
    $r1=5;
    $r2=205;
    $y1=35;
    $y2=290;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);
    $this->SetFont("Arial","B",8);
    $this->setX($colu[0]);
    $this->Cell(10,5,"Materia",0,0,"L");
    $this->SetX($colu[1]);
    $this->Cell(15,5,"Tipo",0,0,"C");   
    $this->SetX($colu[2]);
    $this->Cell(15,5,"Nota",0,1,"C");
    
    $this->Line(5, $this->GetY(), 205, $this->GetY());


    
}

function addDetalle() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $cartel;

        global $a_mat;
        global $a_not;
        global $a_tip;
        global $colu;

    $this->SetFont('Arial','',8);
    for($i=0;$i<count($a_mat);$i++) {
        $this->SetX($colu[0]);
        $this->Cell(10,5,$a_mat[$i],0,0,"L");
        $this->SetX($colu[1]);
        $this->Cell(15,5,$a_tip[$i],0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(15,5,$a_not[$i],0,1,"R");
        
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        
    }
 
}


}

class PDF_alu_asi extends pdf_function
{
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $nombreemp;
    global $telefonoemp;
    global $colu;
     $this->addCliente( $nombreemp,$telefonoemp);
    //$this->Image("images/logomaral.png",5,5,40,20);
    
    $this->fact_dev( "Asistencia",0,100);
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());
    $this->addPageNumber($this->PageNo());
    $r1=5;
    $r2=205;
    $y1=35;
    $y2=290;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);
    $this->SetFont("Arial","B",10);
    $this->setX($colu[0]);
    $this->Cell(10,5,"Legajo",0,0,"C");
    $this->SetX($colu[1]);
    $this->Cell(15,5,"Alumno",0,0,"L");
    $this->SetX($colu[2]);
    $this->Cell(15,5,"Anterior",0,0,"L");
    $this->SetX($colu[3]);
    $this->Cell(10,5,"Asistencia",0,1,"L");


    
}

function addDetalle() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $cartel;

        global $a_leg;
        global $a_ape;
        global $a_nom;
        global $a_ant;
        global $a_asi;              

        global $colu;

    $this->SetFont('Arial','',8);
    for($i=0;$i<count($a_leg);$i++) {
        $this->SetX($colu[0]);
        $this->Cell(10,5,$a_leg[$i],0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,utf8_decode(substr($a_ape[$i]." ".$a_nom[$i],0,30)),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5, $a_ant[$i],0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(15,5, $a_asi[$i],0,1,"L");    
        
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        
    }
 
}


}

class PDF_plan extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreemp;
        global $telefonoemp;
        global $colu;
        $this->addCliente( $nombreemp,$telefonoemp);
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( "Plan De Estudio",0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,"Codigo",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Nombre",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"Inscripcion",0,0,"R");
        $this->SetX($colu[4]);       
        $this->Cell(10,5,"Importe",0,0,"R");
        $this->SetX($colu[5]);       
        $this->Cell(10,5,"Recargo",0,0,"R");
        $this->SetX($colu[6]);       
        $this->Cell(10,5,"Examen",0,1,"R");        



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

            global $a_id;
            global $a_cod;
            global $a_nom;
            global $a_ins;
            global $a_imp;
            global $a_rec;
            global $a_exa;
            global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_cod[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5, $a_nom[$i],0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(15,5,$a_ins[$i] ,0,0,"R");    
            $this->SetX($colu[4]);
            $this->Cell(10,5,$a_imp[$i],0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(10,5,$a_rec[$i],0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(10,5,$a_exa[$i],0,1,"R");
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}

class PDF_mat extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreemp;
        global $telefonoemp;
        global $colu;
        $this->addCliente( $nombreemp,$telefonoemp);
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( "Plan De Estudio",0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Nombre",0,0,"L");
        $this->SetX($colu[1]);
        $this->Cell(15,5,utf8_decode("Año"),0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Plan.",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"Parcial",0,0,"R");
        $this->SetX($colu[4]);       
        $this->Cell(10,5,"Final",0,0,"R");
        $this->SetX($colu[5]);       
        $this->Cell(10,5,"Prom.",0,0,"R");
        $this->SetX($colu[6]);       
        $this->Cell(10,5,"Nota",0,1,"R");        



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

            global $a_id;
            global $a_nom;
            global $a_ano;
            global $a_idp;
            global $a_par;
            global $a_fin;
            global $a_pro;
            global $a_not;
            global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_nom[$i],0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_ano[$i],0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(10,5, $a_idp[$i],0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(10,5,$a_par[$i],0,0,"R");            
            $this->SetX($colu[4]);
                if($a_fin[$i]==1) {                                                             
                   $this->cell(10,5,"X",0,0,"C");
                    }   
            $this->SetX($colu[5]);
                if($a_pro[$i]==1) {                                                             
                    $this->cell(10,5,"X",0,0,"C");
                    } 
            $this->SetX($colu[6]);
            $this->Cell(10,5,$a_not[$i],0,1,"R");
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}


class PDF_cur extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreemp;
        global $telefonoemp;
        global $colu;
     //   $this->addCliente( $nombreemp,$telefonoemp);
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( "Cursos",0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,"Plan De Estudio",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Inscripcion",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"Importe",0,0,"L");
        $this->SetX($colu[4]);       
        $this->Cell(10,5,"Recargo",0,1,"C");



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

            global $a_id;
            global $a_idp;
            global $a_ins;
            global $a_imp;
            global $a_rec;                        
            global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_idp[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5, $a_ins[$i],0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(15,5,$a_imp[$i] ,0,0,"L");    
            $this->SetX($colu[4]);
            $this->Cell(10,5,$a_rec[$i],0,1,"C");

            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}

class PDF_prof extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreemp;
        global $telefonoemp;
        global $colu;
     //   $this->addCliente( $nombreemp,$telefonoemp);
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( "Profesores",0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=200;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,"Nombre",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Email",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"Ciudad",0,0,"L");
        $this->SetX($colu[4]);       
        $this->Cell(10,5,"Telefono",0,1,"C");



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

            global $a_id;
            global $a_nom;
            global $a_ape;
            global $a_ema;
            global $a_ciu;
            global $a_tel;            
            global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_ape[$i]." ".$a_nom[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5, $a_ema[$i],0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(15,5,$a_ciu[$i] ,0,0,"L");    
            $this->SetX($colu[4]);
            $this->Cell(10,5,$a_tel[$i],0,1,"C");

            $this->Line(5, $this->GetY(), 200, $this->GetY());

        }

    }
}

class PDF_fis_lst extends pdf_function
{
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $nombreemp;
    global $telefonoemp;
    global $colu;
 //   $this->addCliente( $nombreemp,$telefonoemp);
//    $this->Image("images/logomaral.png",10,5,50,30);
    
    $this->fact_dev( "COMPROBANTES FISCALES",0,100);
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());
    $this->addPageNumber($this->PageNo());
    $r1=5;
    $r2=200;
    $y1=35;
    $y2=290;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);
    $this->SetFont("Arial","B",10);
    $this->SetX($colu[0]);
    $this->Cell(15,5,"ID",0,0,"C");
    $this->SetX($colu[1]);
    $this->Cell(15,5,"Fecha",0,0,"C");
    $this->SetX($colu[2]);
    $this->Cell(10,5,"Comprobante",0,0,"L");
    $this->SetX($colu[3]);
    $this->Cell(15,5,utf8_decode("Alumnos"),0,0,"L");
    $this->SetX($colu[4]);
    $this->Cell(15,5,utf8_decode("Ciudad"),0,0,"L");    
    $this->SetX($colu[5]);
    $this->Cell(20,5,utf8_decode("Importe"),0,1,"R");
    
    $this->Line(5, $this->GetY(), 200, $this->GetY());
    
}

function addDetalle() {
    require_once 'clases/datesupport.php';
    require_once 'clases/support.php';
    $dsup=new datesupport();
    $sup=new support();
    global $cartel;

    global $a_id;
    global $a_fec;
    global $a_num;
    global $a_let;
    global $a_tpc;
    global $a_pto;
    global $a_alu;
    global $a_ciu;
    global $a_tot;
    global $colu2;
    global $colu;
    global $d_id;
    global $d_det;
    global $d_can;
    global $d_iva;
    global $d_tot;
    global $d_cod;
    global $d_pre;
    global $detallefis;

    $this->SetFont('Arial','',8);
    for($i=0;$i<count($a_id);$i++) {
        $this->SetX($colu[0]);
        $this->Cell(15,5,$a_id[$i],0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(10,5,$a_tpc[$i].'-'.$a_let[$i]."-".$sup->AddZeros($a_pto[$i],4)."-".$sup->AddZeros($a_num[$i],8),0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(15,5,$a_alu[$i],0,0,"L");
        $this->SetX($colu[4]);
        $this->Cell(15,5,$a_ciu[$i],0,0,"L");
        $this->SetX($colu[5]);
        $this->Cell(20,5,number_format($a_tot[$i],2),0,1,"R"); 
        if($detallefis==1) {
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"ID",0,0,"C");
            $this->SetX($colu2[1]);
            $this->Cell(15,5,"Codigo",0,0,"L");
            $this->SetX($colu2[2]);
            $this->Cell(10,5,"Articulos",0,0,"C");
            $this->SetX($colu2[3]);
            $this->Cell(10,5,"Cantidad",0,0,"C");
            $this->SetX($colu2[4]);
            $this->Cell(10,5,"IVA",0,0,"C");
            $this->SetX($colu2[5]);
            $this->Cell(10,5,"Precio",0,0,"C");
            $this->SetX($colu2[6]);
            $this->Cell(10,5,"Total",0,1,"C");
            $this->SetFont("Arial","",8);
            for($d=0;$d<count($d_id[$i]);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,$d_id[$i][$d],0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(10,5,$d_cod[$i][$d],0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(10,5,$d_det[$i][$d],0,0,"L");
                $this->SetX($colu2[3]);
                $this->Cell(10,5,$d_can[$i][$d],0,0,"L");
                $this->SetX($colu2[4]);
                $this->Cell(10,5,$d_iva[$i][$d],0,0,"R");
                $this->SetX($colu2[5]);
                $this->Cell(10,5,number_format($d_pre[$i][$d],2),0,0,"R");
                $this->SetX($colu2[6]);
                $this->Cell(10,5,number_format($d_tot[$i][$d],2),0,1,"R");
            }
            
                }
        
        $this->Line(5, $this->GetY(), 200, $this->GetY());
        
    }
 
}


}