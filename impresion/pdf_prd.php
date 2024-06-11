<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('pdf_function.php');

class PDF_prd extends pdf_function
{
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
        //$this->Image("images/logomaral.png",5,5,40,20);

//        $this->fact_dev( utf8_decode("ARTÍCULOS"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
        $this->TituloRec("Articulos de Venta");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Codigo",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,"Descripcion",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5,"Rubro",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Precio",0,1,"R");

    
    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;

        global $a_des;
        global $a_rub;
        global $a_pre;               
        global $a_cod;       
        global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_cod[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_des[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_rub[$i],0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(20,5,$a_pre[$i],0,1,"R");
       
            $this->Line(5, $this->GetY(), 205, $this->GetY());
        
            }
 
     }


}