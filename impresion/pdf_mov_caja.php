<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'pdf_function.php';
class PDF_mov_caja_lst extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        require_once 'clases/conexion.php';
        $dsup=new datesupport();
        $conx=new conexion();
        global $nombreemp;
        global $telefonoemp;
        global $cajamcj;
        global $colu;
        $fff=$conx->getTextoValor($cajamcj, "CAJA");
        
        $this->addCliente( "Movimientos de Caja",$fff);
        //$this->fact_dev( "Movimientos de Caja",10,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=290;
        $y1=35;
        $y2=205;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(20,5,utf8_decode("Fecha"),0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(50,5,utf8_decode("Detalle"),0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(50,5,"Descriptores - Oficina",0,0);
        $this->SetX($colu[4]);
        $this->Cell(20,5,utf8_decode("Entrada"),0,0,"R");
        $this->SetX($colu[5]);
        $this->Cell(20,5,utf8_decode("Salida"),0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,utf8_decode("Saldo"),0,1,"R");



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_det;
        global $a_imp;
        global $a_tip;
        global $a_tmv;
        global $a_des1;
        global $a_des2;
        global $a_des3;
        global $a_des4;
        global $a_seg1;
        global $a_seg2;
        global $a_seg3;
        global $a_seg4;
        global $a_ofi;
        global $saldoini;
        global $fechainimcj;
        global $colu;

        $saldo=0;
        $this->SetFont('Arial','',8);
//        $saldo=$saldoini;
//        $this->SetX($colu[1]);
//        $this->Cell(10,5,date("d/m/Y", strtotime("$fechainimcj - 1 day")),0,0);
//        $this->SetX($colu[2]);
//        $this->Cell(50,5,"Saldo Inicial",0,0,"L");
//        $this->SetX($colu[5]);
//        $this->Cell(20,5,  number_format($saldo,2),0,1,"R");
//        $this->line(5,$this->GetY(),290,$this->GetY());

        for($i=0;$i<count($a_id);$i++) {
//            if($a_tmv[$i]==2)
                $saldo+=$a_imp[$i];
//            else
//                $saldo-=$a_imp[$i];
            $cad=$a_des1[$i]."/".$a_des2[$i]."/".$a_des3[$i]."/".$a_des4[$i]." - ".$a_ofi[$i];
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(50,5,  substr(utf8_decode($a_det[$i]),0,66),0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(50,5,  utf8_decode($cad),0,0);
            if($a_imp[$i]>0)
                $this->SetX($colu[4]);
            else
                $this->SetX ($colu[5]);
            $this->Cell(20,5,number_format(abs($a_imp[$i]),2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,  number_format($saldo,2),0,1,"R");
            $this->line(5,$this->GetY(),290,$this->GetY());
        }
    }
}