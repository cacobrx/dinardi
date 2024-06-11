<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_cped2 extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $carteltarea;
        global $adm;
        global $patente;
        global $direccion;
        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( utf8_decode($carteltarea),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
//        $this->TituloRec("PRODUCTOS");
        $r1=5;
        $r2=130;
        $y1=15;
        $y2=32;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->SetFont("Arial","",10);
        $this->setXY(5,17);
        $this->Cell(10,5,"Cliente",0,1,"L");
        $this->SetX(5);         
        $this->Cell(10,5,utf8_decode("Dirección"),0,1,"L");
        $this->SetX(5);         
        $this->Cell(10,5,utf8_decode("Patente"),0,1,"L");        
        $this->SetFont("Arial","B",10); 
        $this->setXY(25,17);
        $this->Cell(10,5,utf8_decode($adm->getCliente()),0,1,"L");
        $this->SetX(25);         
        $this->Cell(10,5,$direccion,0,1,"L");
        $this->SetX(25);         
        $this->Cell(10,5,$patente,0,1,"L");        
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=145;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXy($colu[0], 35);
        $this->Cell(10,5,"Kilos",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,utf8_decode("Descripción"),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Cantidad",0,0,"R");
        $this->setX($colu[3]);
        $this->Cell(20,5,"Precio",0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,utf8_decode("Total"),0,1,"R");        



    }
//
    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $d_articulo;
        global $d_cantidad;
        global $d_precio;
        global $d_total;
        global $d_recipiente;
        global $observaciones;
        
//        print_r($d_total);
        
        
        global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($d_cantidad);$i++) {
            $this->setX($colu[0]);
            $this->Cell(10,5,$d_cantidad[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$d_articulo[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(20,5,$d_recipiente[$i],0,0,"C");          
            $this->setX($colu[3]);
            $this->Cell(20,5,number_format($d_precio[$i],2),0,0,"R");
            $this->setX($colu[4]);
            $this->Cell(20,5,number_format($d_precio[$i]*$d_cantidad[$i],2),0,1,"R");        
            $this->Line(5, $this->GetY(), 205, $this->GetY());
        }
        $this->SetFont("Arial", "B", 10);
        $this->SetX($colu[3]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->SetX($colu[4]);
        $this->Cell(20,5,number_format($d_total,2),0,0,"R");
        $this->SetXY(10,150);
        $this->SetFont("Arial", "", 8);
        $this->MultiCell(190, 5, $observaciones, 0);
        
    }
}
