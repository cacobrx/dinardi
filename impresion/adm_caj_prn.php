<?php

#----------------------------------------
# Autor: gus
# Fecha: 03/04/2015 21:39:06
# Archivo: pdf_imprime.php
#----------------------------------------

require('pdf_function.php');

class PDF_caja extends pdf_function {
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
    if(file_exists("images/logo.png")) $this->Image("images/logo.png",5,5,40,20);
    
    $this->Titulo( "CAJAS");
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
        $this->SetFont("Arial","B",8);        
        $this->SetX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,"Nombre",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5,"Moneda",0,1,"C");    
  

    }  


    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global    $a_id;
        global    $a_mon;
        global    $a_nom;
        global    $colu;


        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {


                $this->SetX($colu[0]);
                $this->Cell(10,5,$a_id[$i],0,0,"C");
                $this->SetX($colu[1]);
                $this->Cell(5,5,$a_nom[$i],0,0,"L");
                $this->SetX($colu[2]);
                if($a_mon[$i]==0)
                    $this->Cell(10,5,"U\$S",0,1,"C");               
                else
                    $this->Cell(10,5,"\$",0,1,"C");               
                
                $this->line(5,$this->GetY(),205,$this->GetY());
        }

    }
}
