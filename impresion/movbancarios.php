<?php
/*
 * creado el 10 ene. 2022 11:26:55
 * Usuario: gus
 * Archivo: movbancarios
 */

require_once 'pdf_function.php';

class pdf_movbancarios extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fechaini;
        global $fechafin;
        global $tipo;
        
        
        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( utf8_decode("MOVIMIENTOS BANCARIOS"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
        $cc="";
        if($tipo==1) $cc=" (Entradas)";
        if($tipo==2) $cc=" (Salidas)";
        $this->TituloRec("Desde ".$dsup->getFechaNormalCorta($fechaini)." hasta ".$dsup->getFechaNormalCorta($fechafin).$cc);
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->SetX($colu[0]);
        $this->Cell(15,5,utf8_decode("Fecha"),0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,utf8_decode("Detalle"),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(20,5,utf8_decode("Importe"),0,1,"R");

       

    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();

        global $a_fec;
        global $a_det;
        global $a_imp;
        
        global $colu;
    

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_fec);$i++) {
            $this->setX($colu[0]);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->setX($colu[1]);
            $this->Cell(20,5, utf8_decode($a_det[$i]),0,0,"L");
            $this->setX($colu[2]);
            $this->Cell(20,5,number_format($a_imp[$i],2),0,1,"R");  
            $this->line(5,$this->GetY(),205,$this->GetY());
            
        }
        $this->SetFont("Arial","B",10);        
        $this->setX($colu[1]);
        $this->Cell(20,5,"TOTAL",0,0,"L");
        $this->setX($colu[2]);
        $this->Cell(20,5,number_format(array_sum($a_imp),2),0,1,"R");
    }
 }
      