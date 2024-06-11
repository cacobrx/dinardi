<?php
/*
 * Creado el 05/11/2018 12:15:59
 * Autor: gus
 * Archivo: retencioniibb.php
 * planbsistemas.com.ar
 */

require('pdf_function.php');

class retencioniibb extends pdf_function {
// private variables
var $colonnes;
var $format;
var $angle=0;

    function Header() {
    }  


    function addDetalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        global $cartel;

        global    $adm;
        global    $cfg;
        
        $comprobante="";
        $neto=0;
        $a_com=$adm->getD_comprobante();
        $a_net=$adm->getD_neto();
        $a_tip=$adm->getD_tipo();
        for($i=0;$i<count($a_com);$i++) {
            $comprobante.=$a_com[$i]." ";
            if($a_tip[$i]==2)
                $neto-=$a_net[$i];
            else
                $neto+=$a_net[$i];
        }
        
        $this->SetFont("Arial","B", 14);
        $this->SetXY(10,10);
        $this->Cell(200, 10, utf8_decode("RETENCIÓN DE INGRESOS BRUTOS"), 0, 1, "C");
        $this->SetX(10);
        $this->Cell(200,10, utf8_decode("PROVINCIA DE BUENOS AIRES"),0,1,"C");
        $this->SetFont("Arial","B",12);
        $this->Ln(5);
        $this->SetFont("Arial", "", 10);
        $this->SetX(100);
        $this->Cell(10,5, utf8_decode("Número de Certificado:"),0,0);
        $this->SetFont("Arial", "B", 10);
        $this->SetX(150);
        $this->Cell(10,5,date("Y", strtotime($adm->getFecha()))."-".$sup->AddZeros($adm->getNumeroret(),8),0,1);
        $this->SetFont("Arial", "", 10);
        $this->SetX(100);
        $this->Cell(10,5, utf8_decode("Fecha:"),0,0);
        $this->SetFont("Arial", "B", 10);
        $this->SetX(150);
        $this->Cell(10,5,date("d/m/Y", strtotime($adm->getFecha())),0,1);
        $this->Ln(5);
        $this->SetX(10);
        $this->line(10,$this->GetY(),200,$this->GetY());
        
        $this->Cell(10,5, utf8_decode("A - Datos del Agente de Retención"),0,1,"L");
        $this->SetFont("Arial", "", 10);
        $this->SetX(10);
        $col=$this->GetY();
        $this->Cell(10,10,utf8_decode("Denominación:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("C.U.I.T.:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("Domicilio:"),0,1,"L");
        $this->SetXY(35,$col);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10,10, utf8_decode($cfg->getFiscalnombre()),0,1,"L");
        $this->SetX(25);
        $this->Cell(10,10,$cfg->getFiscalcuit(),0,1,"L");
        $this->SetX(27);
        $this->Cell(10,10, utf8_decode($cfg->getFiscaldireccion()),0,1,"L");
        
        $this->SetFont("Arial","B",12);
        $this->SetX(10);
        $this->line(10,$this->GetY(),200,$this->GetY());
        $this->Cell(10,5, utf8_decode("B - Datos del Sujeto Retenido"),0,1,"L");
        $this->SetFont("Arial", "", 10);
        $this->SetX(10);
        $col=$this->GetY();
        $this->Cell(10,10,utf8_decode("Apellido y Nombre o Denominación:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("C.U.I.T.:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("Domicilio:"),0,1,"L");
        $this->SetXY(70,$col);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10,10, utf8_decode($adm->getProveedor()),0,1,"L");
        $this->SetX(25);
        $this->Cell(10,10,$adm->getCuit(),0,1,"L");
        $this->SetX(27);
        $this->Cell(10,10, utf8_decode($adm->getDireccion()),0,1,"L");
        
        $this->SetFont("Arial","B",12);
        $this->SetX(10);
        $this->line(10,$this->GetY(),200,$this->GetY());
        $this->Cell(10,5, utf8_decode("C - Datos de la Retención Practicada"),0,1,"L");
        $this->SetFont("Arial", "", 10);
        $this->SetX(10);
        $col=$this->GetY();
        $this->Cell(10,10,utf8_decode("Impuesto:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("Comprobantes que origina la Retención:"),0,1,"L");
        $this->SetXY(27,$col);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10,10, utf8_decode("Retención de Ingresos Brutos"),0,1,"L");
        $this->Ln(10);
        $this->SetX(75);
        for($i=0;$i<count($a_com);$i=$i+4) {
            $this->SetX(10);
            $this->Cell(10,4,$a_com[$i],0,"L");
            if($i+1<count($a_com)) {
                $this->SetX(46);
                $this->Cell(10,4,$a_com[$i+1],0,"L");
                
            }
            if($i+2<count($a_com)) {
                $this->SetX(82);
                $this->Cell(10,4,$a_com[$i+2],0,"L");
            }
            if($i+3<count($a_com)) {
                $this->SetX(118);
                $this->Cell(10,4,$a_com[$i+3],0,"L");
            }
            $this->Cell(5,4,"",0,1);
        }
        $this->Cell(5,4,"",0,1);
        $col=$this->GetY();
        $this->SetFont("Arial", "", 10);
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("Monto del Comprobante que origina la Retención:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("Alicuota:"),0,1,"L");
        $this->SetX(10);
        $this->Cell(10,10,utf8_decode("Monto del la Retención:"),0,1,"L");
        $this->SetFont("Arial", "B", 10);
        $this->SetXY(100,$col);
        $this->Cell(20,10,"$".number_format($neto,2),0,1,"R");
        $this->SetX(100);
        $this->Cell(20,10, $adm->getAlicuotaret()."%",0,1,"R");
        $this->SetX(100);
        $this->Cell(20,10, "$".number_format($adm->getRetencioniibb(),2),0,1,"R");
        $this->SetXY(140,200);
        $this->SetFont("Arial", "", 10);
        $this->Cell(10,5,utf8_decode("Firma del Agente de Retención"),0,0,"L");
        if(file_exists("images/firmaretencion.png"))
            $this->Image("images/firmaretencion.png", 140, 200, 30,42);
        $this->SetXY(130,230);
        $this->SetFont("Courier", "", 10);
        $this->Cell(70,5,$cfg->getFiscalnombre(),0,1,"C");
        $this->SetX(130);
        $this->Cell(70,5,utf8_decode($cfg->getFiscalresponsable()),0,1,"C");
        $this->SetX(130);
        $this->Cell(70,5,utf8_decode($cfg->getFiscalcargo()),0,1,"C");

    }
}
