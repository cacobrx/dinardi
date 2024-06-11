<?php

#----------------------------------------
# Autor: gus
# Fecha: 03/04/2015 21:39:06
# Archivo: pdf_imprime.php
#----------------------------------------

require('pdf_function.php');

class PDF_saldos extends pdf_function {
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $cfg;
    global $colu;
    $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
//    $this->Image("images/logomaral.png",5,5,40,20);
    $this->fact_dev( utf8_decode("SALDOS DE CLIENTES"),0,125);
    
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
        $this->Cell(20,5,"Cliente",0,0,"L");
        $this->SetX($colu[1]);
        $this->Cell(20,5,"Adeudado",0,0,"R");
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Pagos",0,0,"R");      
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Saldo",0,1,"R");    
  

    }  


    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global    $i_cli;
        global    $i_fac;
        global    $i_rec;
        global    $i_sal;
        global    $colu;


        $this->SetFont('Arial','',8);
        for($i=0;$i<count($i_cli);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(20,5,$i_cli[$i],0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(20,5, number_format($i_fac[$i],2),0,0,"R"); 
            $this->SetX($colu[2]);
            $this->Cell(20,5, number_format($i_rec[$i],2),0,0,"R"); 
            $this->SetX($colu[3]);
            $this->Cell(20,5, number_format($i_sal[$i],2),0,1,"R");                 
                
            $this->line(5,$this->GetY(),205,$this->GetY());
        }
        $this->SetFont("Arial", "B", 8);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"TOTALES",0,0);
        $this->SetX($colu[1]);
        $this->Cell(20,5, number_format(array_sum($i_fac),2),0,0,"R"); 
        $this->SetX($colu[2]);
        $this->Cell(20,5, number_format(array_sum($i_rec),2),0,0,"R"); 
        $this->SetX($colu[3]);
        $this->Cell(20,5, number_format(array_sum($i_sal),2),0,1,"R");                 
        
    }
}
