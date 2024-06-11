<?php

#----------------------------------------
# Autor: gus
# Fecha: 03/04/2015 21:39:06
# Archivo: pdf_imprime.php
#----------------------------------------

require('pdf_function.php');

class PDF_cht extends pdf_function {
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
    global $cfg;
//    $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
//    $this->Image("images/logocya.png",5,5,40,20);
    
    $this->TituloRec("Cheques Terceros");
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());
    $this->addPageNumber($this->PageNo());
    $r1=5;
    $r2=290;
    $y1=35;
    $y2=200;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);        
        $this->SetFont("Arial","B",8);        
        $this->SetX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(20,5,"F.Origen",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(20,5,utf8_decode("F.Venc."),0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"D",0,0,"C");
        $this->SetX($colu[4]);
        $this->Cell(10,5,"Banco",0,0,"L");
        $this->SetX($colu[5]);
        $this->Cell(10,5,"Nro.Cheque",0,0,"L");
        $this->SetX($colu[6]);
        $this->Cell(10,5,"Nombre",0,0,"L");
        $this->SetX($colu[7]);
        $this->Cell(10,5,"Cliente",0,0,"L");
        $this->SetX($colu[8]);
        $this->Cell(10,5,"Entregado/Fecha Acr",0,0,"L");       
        $this->SetX($colu[9]);
        $this->Cell(20,5,"Importe",0,1,"R");    
  

    }  


    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global    $a_id;
        global    $a_fori;
        global    $a_fven;
        global    $a_ban;
        global    $a_nro;
        global    $a_nom;
        global    $a_imp;
        global    $a_cli;
        global    $a_ent;
        global $a_fea;
        global    $a_dias;
        global    $totalimporte;
        global    $colu;


        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($a_fori[$i]),0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($a_fven[$i]),0,0,"C");
            $this->SetX($colu[3]);
            $this->Cell(10,5,$a_dias[$i],0,0,"C");
            $this->SetX($colu[4]);
            $this->Cell(5,5, utf8_decode($a_ban[$i]),0,0,"L");
            $this->SetX($colu[5]);
            $this->Cell(5,5,$a_nro[$i],0,0,"L");
            $this->SetX($colu[6]);
            $this->Cell(5,5,$a_nom[$i],0,0,"L");
            $this->SetX($colu[7]);
            $this->Cell(5,5,$a_cli[$i],0,0,"L");
            $this->SetX($colu[8]);
            if($a_fea[$i]==NULL)
                $this->Cell(5,5,$a_ent[$i],0,0,"L"); 
            else
                    $this->Cell(5,5,$a_fea[$i],0,0,"L");                 
                //if($a_fea[$i]=="NULL") $this->Cell(5,5,"",0,0,"L"); 
            $this->SetX($colu[9]);
            $this->Cell(20,5,number_format($a_imp[$i],2,",",""),0,1,"R");

            $this->line(5,$this->GetY(),290,$this->GetY());
        }
            $this->SetFont('Arial','B',10);
            $this->setx($colu[6]);
            $this->cell(5,5,"TOTAL",0,0,"C");
            $this->setx($colu[9]);
            $this->cell(20,5,number_format($totalimporte,2),0,1,"R");        

    }
}
