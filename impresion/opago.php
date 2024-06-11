<?php
/*
 * Creado el 23/07/2019 22:41:59
 * Autor: gus
 * Archivo: opago.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_opg1 extends pdf_function {
    var $colonnes;
    var $format;
    var $angle=0;
    function addDetalle() {
        require_once 'clases/support.php';
        $sup=new support();
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_opg2.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_gas.php';
        $dsup=new datesupport();
        global $cfg;
        global $nombreempresa;
        global $direccionempresa;
        global $telefonoempresa;
        global $cpostalempresa;
        global $ciudadempresa;
        global $numero;
        global $opg;       
        global $det;
        global $imp;
        global $cht;  
        global $idop;
        global $idprv;
        global $a_id;
        global $centrosel;
        global $a_fec;        
        global $tipocontabilidad;
        global $idopg;
        global $op2_detalle;
        global $op2_importe;
        global $tipocontabilidad;
        global $inicioactividad;
        // recuadros
        $r1=5;
        $r2=205;
        $y1=5;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetXY(5,5);
        $this->SetFont("Arial","B",14);
        $this->Cell(200,5,"ORDEN DE PAGO",0,1,"C");
        $this->SetX(5);
        $this->SetFont("Arial","",10);
        $this->line(5,$this->GetY(),205,$this->GetY());
        if($tipocontabilidad==1) {
            $this->SetFont("Arial","B",14);
            $this->SetXY(7,15);
            $this->Cell(20,5,$nombreempresa,0,1);
            $this->SetFont("Arial","",10);
            $this->Cell(20,5,utf8_decode($direccionempresa." - ".$ciudadempresa),0,1);
            $this->Cell(20,5,$cpostalempresa,0,1);
            $this->Cell(20,5,$telefonoempresa,0,1);
        }
        $this->SetXY(120,15);
        $this->SetFont("Arial","B",12);
        $this->Cell(20,5,"Nro. 0001-".$sup->AddZeros($opg->getId(),8)." Fecha: ".$dsup->getFechaNormalCorta($opg->getFecha()),0,1);
        $this->SetFont("Arial","",10);
        if($tipocontabilidad==1) {
            $this->SetX(120);
            $this->Cell(20,5,"",0,1);
            $this->SetX(120);
            $this->Cell(20,5,"",0,1);
            $this->SetX(120);
            $this->Cell(20,5,"",0,1);
            $this->SetX(120);
            $this->Cell(20,5,"Inicio Actividades: ".date("d/m/Y", strtotime($inicioactividad)),0,1);
        } else
            $this->Ln(20);
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetXY(7,40);
        $this->SetFont("Arial","B",12);
        $this->Cell(20,5,$opg->getProveedor(),0,1);
        $this->SetFont("Arial","",10);
        $this->Cell(20,5,$opg->getDireccion(),0,1);
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetX(7);
        $this->SetFont("Arial","B",10);
        $this->Cell(20,5,"DOCUMENTOS CANCELADOS",0,1);
        $this->SetFont('Arial','B',10);
        $this->SetX(15);
        $this->Cell(10,5,"Fecha",0,0);
        $this->SetX(50);
        $this->Cell(10,5,"Comprobante",0,0);
        $this->SetX(130);
        $this->Cell(20,5,"Importe",0,0,"R");
        $this->SetX(150);
        $this->Cell(20,5,"Cancelado",0,1,"R");
        if($tipocontabilidad==1){
            $ssql="select * from adm_com where idopg=".$idop;
//            echo $ssql;
            $op3=new adm_com_2($ssql);
            $fec=$op3->getFecha();
            $imp=$op3->getTotaltotal();
            $impc=$op3->getImportepag();
            $com=$op3->getComprobantetodo();
            $tip=$op3->getTipocom();
            $totdoc=0;
            $totcan=0;
        } else { 
            $ssql="select * from adm_gas where idopg=".$idop;
            $gas=new adm_gas_2($ssql);
            $id=$gas->getId();
            $imp=$gas->getImporte();
            $fec=$gas->getFecha();
            $impc=$gas->getPagado();
            $com=$gas->getComprobantedes();
            if(count($com)>0)
                $tip=array_fill(0, count($com), 1);
            else
                $tip=array();
            $totdoc=0;
            $totcan=0;            
        }
        $this->SetFont("Arial", "", 10);
        for($i=0;$i<count($com);$i++) {
            $this->SetX(15);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($fec[$i]),0);
            $this->SetX(50);
            $this->Cell(10,5,($com[$i]),0,0);
            $this->SetX(130);
            $this->Cell(20,5,number_format($imp[$i],2),0,0,"R");
            $this->SetX(150);
            $this->Cell(20,5,number_format($impc[$i],2),0,1,"R");
            $totdoc+=$imp[$i];
            $totcan+=$impc[$i];
        }
        $this->SetFont("Arial","B",10);
        $this->SetX(130);
        $this->Cell(20,5,number_format($totdoc,2),0,0,"R");
        $this->SetX(150);
        $this->Cell(20,5,number_format($totcan,2),0,1,"R");
        $this->line(5,$this->GetY(),205,$this->GetY());     
        $this->SetX(7);
        $this->SetFont("Arial","B",10);
        $this->Cell(20,5,"VALORES RECIBIDOS",0,1);
        $this->SetX(15);
        $this->Cell(10,5,"Detalle",0,0);
        $this->SetX(150);
        $this->Cell(20,5,"Importe",0,1,"R");
        $this->SetFont('Arial','',10);
        $totpag=0;
        for($i=0;$i<count($op2_detalle);$i++) {
            $this->SetX(15);
            $this->Cell(10,5, utf8_decode($op2_detalle[$i]),0,0);
            $this->SetX(150);
            $this->Cell(20,5,number_format($op2_importe[$i],2),0,1,"R");
            $totpag+=$op2_importe[$i];
        }
        $this->SetFont("Arial","B",10);
        $this->SetX(150);
        $this->Cell(20,5,number_format($totpag,2),0,1,"R");
        $this->line(5,$this->GetY(),205,$this->GetY());     
        
        $this->SetFont("Arial","B",10);
        $this->SetXY(20,240);
        $this->Cell(20,5,"Recibi la cantidad de PESOS: ".number_format($totpag,2),0,0);
        $this->SetX(150);
        $this->SetXY(130,240);
        $this->SetFont("Arial","",10);
        $this->Cell(70,5,"_______________________________",0,1,"C");
        $this->SetX(130);
        $this->Cell(70,5,"Firma",0,1,"C");
        if(file_exists("images/firmaopago.png"))
            $this->Image("images/firmaopago.png", 140, 200, 30,42);
        $this->SetXY(100,250);
//        $this->SetFont("Courier", "", 10);
        $this->Cell(70,10,utf8_decode("Aclaración: _______________________________________"),0,1,"L");
        $this->SetX(100);
        $this->Cell(70,10,"Nro. DNI: _________________________________________",0,1,"L");
//        $this->SetX(130);
//        $this->Cell(70,5,utf8_decode($cfg->getFiscalcargo()),0,1,"C");
        
    }
    
}
