<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class prv_pre extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_prv.php';        
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $adm;
        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

//        $this->fact_dev( utf8_decode("PRODUCTOS"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
        $this->TituloRec("Precios del Proveedor"." ".strtoupper($adm->getApellido()));
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(20,5,"ID",0,0,"L");
        $this->setX($colu[1]);
        $this->Cell(20,5,"Producto",0,0,"L");
        $this->setX($colu[2]);
        $this->Cell(20,5,"Precio",0,0,"R");
        $this->setX($colu[3]);
        $this->Cell(20,5,"Precio Min.",0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Precio Max.",0,1,"R");



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;
        
        global $pre_idart;
        global $pre_articulo;
        global $pre_importe;
        global $pre_preciominimo;
        global $pre_preciomaximo;
        global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($pre_idart);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(20,5,$pre_idart[$i],0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(20,5, utf8_decode($pre_articulo[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(20,5, number_format($pre_importe[$i],2),0,0,"R");
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format($pre_preciominimo[$i],2),0,0,"R");            
            $this->SetX($colu[4]);
            $this->Cell(20,5,number_format($pre_preciomaximo[$i],2),0,1,"R");
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}
