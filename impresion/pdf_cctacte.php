<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('pdf_function.php');

class PDF_CCtacte extends pdf_function {
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
        global $tipo;
        global $cliente;
        if(file_exists("images/logo.png")) 
            $this->Image("images/logo.png",5,5,40,20);
        else
            $this->addCliente( $nombreemp,$telefonoemp);

        $this->Titulo( "CTACTE. CLIENTE");
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->SetX(10);
        $this->SetFont("Arial", "B",10);
        $this->Cell(10,5, utf8_decode($cliente),0,0,"L");
        $this->Ln(10);        
        $this->SetFont("Arial","B",8);        
        $this->SetX($colu[0]);
        $this->Cell(20,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,"Detalle",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Facturas",0,0,"R");    
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Pagos",0,0,"R");    
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Saldo",0,1,"R");    
    }  


    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;
        global $i_fec;
        global $i_det;
        global $i_imp;
        global $i_sal;
        global $i_sig;
        global $totalcompra;
        global $totalpago;
        global $colu;


        $this->SetFont('Arial','',8);
        for($i=0;$i<count($i_fec);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($i_fec[$i]),0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(5,5,$i_det[$i],0,0,"L");
            if($i_sig[$i]=="D")
                $this->SetX($colu[2]);
            else
                $this->SetX($colu[3]);
            $this->Cell(20,5,number_format(abs($i_imp[$i]),2),0,0,"R");               
            $this->SetX($colu[4]);
            $this->Cell(20,5,number_format($i_sal[$i],2),0,1,"R");               

            $this->line(5,$this->GetY(),205,$this->GetY());
        }

    }
}
