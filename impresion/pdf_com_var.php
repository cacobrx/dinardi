<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_com_var extends pdf_function {
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

        $this->fact_dev( utf8_decode("Compras de Proveedores Varios"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
//        $this->TituloRec("PRODUCTOS");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"#",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Numero",0,0,"C");  
        $this->setX($colu[3]);
        $this->Cell(10,5,"Proveedor",0,0,"L");        
        $this->SetX($colu[4]);        
        $this->Cell(20,5,"Neto",0,0,"R");
        $this->SetX($colu[5]);        
        $this->Cell(20,5,"Impuestos",0,0,"R");
        $this->SetX($colu[6]);        
        $this->Cell(20,5,"Perc. Ret.",0,0,"R");
        $this->SetX($colu[7]);        
        $this->Cell(20,5,"Total",0,1,"R");



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_nasi;
        global $a_comx;
        global $a_mov;
        global $a_prv;
        global $a_neto21;
        global $a_neto10;
        global $a_neto27;
        global $a_neto17;        
        global $a_exe;
        global $a_ngr;
        global $a_iva21;
        global $a_iva10;
        global $a_iva27;
        global $a_iva17;
        global $a_pat;
        global $a_imi;
        global $a_pri;
        global $a_rti;
        global $a_prb;
        global $a_fev;
        global $calor;
        global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[2]);                                                                       
            $this->cell(10,5,$a_comx[$i],0,0,"C");                               
            $this->SetX($colu[4]);
            $this->Cell(20,5, number_format($a_neto21[$i]+$a_neto10[$i]+$a_neto27[$i]+$a_neto17[$i]+$a_exe[$i]+$a_ngr[$i],2),0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(20,5, number_format($a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i]+ $a_iva17[$i] + $a_imi[$i],2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5, number_format($a_pri[$i] + $a_rti[$i] + $a_prb[$i],2),0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5, number_format($a_neto21[$i] + $a_neto10[$i] + $a_neto27[$i] + $a_neto17[$i] + $a_iva21[$i] + $a_iva10[$i] + $a_iva27[$i]+ $a_iva17[$i] + $a_imi[$i] + $a_pri[$i] + $a_rti[$i] + $a_prb[$i] + $a_exe[$i] + $a_ngr[$i],2),0,0,"R");
            $this->SetX($colu[3]);
            $this->MultiCell(60,5, utf8_decode($a_prv[$i]),0);            
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}
