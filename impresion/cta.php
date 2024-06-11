<?php
/*
 * Creado el 19/06/2020 10:55:25
 * Autor: gus
 * Archivo: cta.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_cta extends pdf_function {
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
        $this->TituloRec("PLAN DE CUENTAS");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",8);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Codigo",0,0,"L");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Nombre",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Tipo",0,1,"L");  



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_cod;
        global $a_nom;
        global $a_tip;
        global $colu;
//        print_r($d_can);
        $tf=0;
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_cod[$i],0,0,"l");
            $this->SetX($colu[1]);
            $this->Cell(10,5, utf8_decode($a_nom[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_tip[$i],0,1,"L"); 
            
        $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}   