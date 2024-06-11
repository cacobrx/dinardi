<?php
// * Autor: gus
// * Archivo: pdf_com.php
// * planbsistemas.com.ar
// */

require_once 'pdf_function.php';

class opg_ret_gan extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;


    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fechafinopg;
        global $fechainiopg;

        $this->SetFont("Arial","",12);
        $this->SetXY(10,5);
        $this->Cell(10,5,utf8_decode("Darío Dinardi"),0,0);        
        $this->SetX(160);
        $this->Cell(10,5,utf8_decode("Página: ".$this->PageNo()),0,1);
        $this->Cell(10,5,utf8_decode("Menudencias"),0,0);   
        $this->SetX(160);
        $this->Cell(10,5,date("d/m/Y"),0,1);
        $this->SetFont("Arial","",9);        
        $this->Cell(10,5,"Fecha: ".date("d/m/Y", strtotime($fechainiopg))." hasta: ".date("d/m/Y", strtotime($fechafinopg)),0,1);

        $this->SetFont("Arial","",12);          
        $this->SetXY(5,30);
        $this->Cell(200,5,"Retenciones de Ganancias",0,1,"C");
        $this->Line(5, $this->GetY(), 205, $this->getY());

//        $this->Ln(5);
        $this->SetFont("Arial","B",10);
        $this->SetX($colu[0]);
        $this->Cell(5,7,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(5,7,utf8_decode("Razón Social"),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,7,"Cuit",0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(15,7,"Fecha",0,0,"L");    
        $this->SetX($colu[4]);
        $this->Cell(20,7,utf8_decode("N° Certificado"),0,0,"C");
        $this->SetX($colu[5]);
        $this->Cell(20,7,"Importe",0,1,"R");    

    }  


    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        global $cartel;

        global    $a_id;
        global    $a_fec;
        global    $a_con;
        global    $a_tip;
        global    $a_imp;
        global    $a_pro;
        global    $a_cui;
        global    $a_num;
        global $a_idprv;
        global    $a_tc;
        global    $colu;
        global $sup;
                   
        $this->SetFont('Arial','',8);
        $total=0;
        for($i=0;$i<count($a_id);$i++) {
            $cc=$a_idprv[$i];
            $subtotal=0;
//            echo "i: $i<".count($a_idprv)."\n";
//            echo "$i: ".$a_idprv[$i]."\n";
            while($cc==$a_idprv[$i] and $i<count($a_idprv)) {
                if($a_tc[$i]==2) {
                    $subtotal-=$a_imp[$i];
                    $total-=$a_imp[$i];
                    $signo="-";
                } else {
                    $subtotal+=$a_imp[$i];
                    $total+=$a_imp[$i];
                    $signo="";
                }
                $this->SetX($colu[0]);
                $this->Cell(5,7,$a_id[$i],0,0,"L");
                $this->SetX($colu[1]);
                $this->Cell(5,7,substr($a_pro[$i],0,30),0,0,"L");
                $this->SetX($colu[2]);
                $this->Cell(10,7,$a_cui[$i],0,0,"C");
                $this->SetX($colu[3]);
                $this->Cell(15,7,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
                $this->SetX($colu[4]);
                $this->Cell(20,7,date("Y", strtotime($a_fec[$i]))."-".$sup->AddZeros($a_num[$i],8),0,0,"C");
                $this->SetX($colu[5]);
                $this->Cell(20,7,$signo.number_format($a_imp[$i],2),0,1,"R"); 

//                $this->Line(5, $this->GetY(), 205, $this->getY());
                $i++;
                if($i>=count($a_idprv)) break;
            }
            $this->SetX($colu[4]);
            $this->Cell(10,5,"Subtotal",0,0,"L");
            $this->SetX($colu[5]);
            $this->Cell(20,5,number_format($subtotal,2),0,1,"R");
            if($i<count($a_idprv)) $i--;
        }
        $this->SetX($colu[4]);
        $this->Cell(10,5,"Total Retenciones",0,0,"L");
        $this->SetX($colu[5]);
        $this->Cell(20,5,number_format($total,2),0,1,"R");

    }
}