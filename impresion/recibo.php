<?php
/*
 * Creado el 18/10/2019 08:49:00
 * Autor: gus
 * Archivo: recibo.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_CRecibo extends pdf_function {
    var $colonnes;
    var $format;
    var $angle=0;
    function addDetalle() {
        require_once 'clases/support.php';
        $sup=new support();
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreempresa;
        global $direccionempresa;
        global $telefonoempresa;
        global $cpostalempresa;
        global $ciudadempresa;
        global $numero;
        global $rec;
        global $cli;
        global $det;
        global $tipocontabilidad;
        global $idrec;
        global $cfg;
        
        // recuadros
        $r1=5;
        $r2=205;
        $y1=5;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetXY(5,5);
        $this->SetFont("Arial","B",14);
        $this->Cell(200,5,"RECIBO",0,1,"C");
        $this->SetX(5);
        $this->SetFont("Arial","",10);
        $this->Cell(200,5,"DOCUMENTO NO VALIDO COMO FACTURA",0,1,"C");
        $this->line(5,$this->GetY(),205,$this->GetY());
        $r1=95;
        $r2=115;
        $y1=15;
        $y2=35;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetFont("Arial","B",40);
        $this->SetXY(95,15);
        $this->Cell(20,20,"R",1,0,"C");
        $this->SetFont("Arial","B",14);
        $this->SetXY(7,15);
        $this->Cell(20,5,$nombreempresa,0,1);
        $this->SetFont("Arial","",10);
        $this->Cell(20,5,$direccionempresa,0,1);
        $this->Cell(20,5,$cpostalempresa." - ".utf8_decode($ciudadempresa),0,1);
        $this->Cell(20,5,$telefonoempresa,0,1);
        $this->SetXY(120,20);
        $this->SetFont("Arial","B",12);
        $this->Cell(20,5,"Nro. 0001-".substr("00000000",0,8-strlen($numero)).$numero." Fecha: ".$dsup->getFechaNormalCorta($rec->getFecha()),0,1);
        $this->SetFont("Arial","",10);
        $this->SetX(120);
        $this->Cell(20,5,"CUIT: ".$cfg->getFiscalcuit(),0,1);
        $this->SetX(120);
        $this->Cell(20,5,"Cond. IVA: ".$cfg->getFiscaliva(),0,1);
//        $this->SetX(120);
//        $this->Cell(20,5,"Establecimiento Nro. 4665",0,1);
//        $this->SetX(120);
//        $this->Cell(20,5,"Nro. Senasa 4665",0,1);
//        $this->SetX(120);
//        $this->Cell(20,5,"Matricula 104416-8",0,1);
        $this->SetX(120);
        $this->Cell(20,5,"Inicio Actividades ".$dsup->getFechaNormalCorta($cfg->getFiscalfechainicio()),0,1);
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetXY(7,40);
        $this->SetFont("Arial","B",12);
        $this->Cell(20,5,$rec->getCliente(),0,1);
        $this->SetFont("Arial","",10);
        $this->Cell(20,5,$rec->getDireccion(),0,1);
        $this->Cell(20,5,$cli->getCondicionivades(),0,1);
        $this->Cell(20,5,"CUIT: ".$cli->getCuit(),0,1);
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetX(7);
        $this->SetFont("Arial","B",10);
        $this->Cell(20,5,"DOCUMENTOS CANCELADOS",0,1);
        $this->SetFont('Arial','',10);
        $this->SetX(15);
        $this->Cell(10,5,"Fecha",0,0);
        $this->SetX(50);
        $this->Cell(10,5,"Comprobante",0,0);
        $this->SetX(130);
        $this->Cell(20,5,"Importe",0,0,"R");
        $this->SetX(150);
        $this->Cell(20,5,"Pagado",0,1,"R");
        $ssql="select * from adm_crec2 where idcrec=$idrec";   
//        echo $ssql."<br>";
        $rec=new adm_crec2_2($ssql);
        $d_fec=$rec->getFecha();
        $d_imp=$rec->getImporte();
        $d_pag=$rec->getImportepago();
        $d_com=$rec->getComprobante();
        $totdoc=0;
        $totpag=0;
        for($i=0;$i<count($d_fec);$i++) {
            $this->SetX(15);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($d_fec[$i]),0);
            $this->SetX(50);
            $this->Cell(10,5,$d_com[$i],0,0);
            $this->SetX(130);
            $this->Cell(20,5,number_format($d_imp[$i],2),0,0,"R");
            $this->SetX(150);
            $this->Cell(20,5,number_format($d_pag[$i],2),0,1,"R");
            if(substr($d_com[$i],0,2)=="NC") {
                $totdoc-=$d_imp[$i];
                $totpag-=$d_pag[$i];
            } else {
                $totdoc+=$d_imp[$i];
                $totpag+=$d_pag[$i];
            }
        }
        $this->SetFont("Arial","B",10);
        $this->SetX(130);
        $this->Cell(20,5,number_format($totdoc,2),0,0,"R");
        $this->SetX(150);
        $this->Cell(20,5,number_format($totpag,2),0,1,"R");
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetX(7);
        $this->SetFont("Arial","B",10);
        $this->Cell(20,5,"CHEQUES",0,1);
        $this->SetFont('Arial','',10);
        $ssql="select * from adm_crec3 where idcrec=$idrec and idcht>0";
        $rec3=new adm_crec3_2($ssql);
        $r_det=$rec3->getDetalle();
        $r_imp=$rec3->getImporte();
        for($i=0;$i<count($r_det);$i++) {
            $this->SetX(15);
            $this->Cell(10,5,  utf8_decode($r_det[$i]),0,0);
            $this->SetX(150);
            $this->Cell(20,5,number_format($r_imp[$i],2),0,1,"R");
        }
        $totche=array_sum($r_imp);
        $this->SetFont("Arial","B",10);
        $this->SetX(150);
        $this->Cell(20,5,number_format(array_sum($r_imp),2),0,1,"R");
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetX(7);
        $this->SetFont("Arial","B",10);
        $this->Cell(20,5,"VALORES RECIBIDOS",0,1);
        $this->SetFont("Arial","",10);
        $this->SetX(15);
        $this->Cell(10,5,"CHEQUES",0,0);
        $this->SetX(150);
        $this->Cell(20,5,number_format(array_sum($r_imp),2),0,1,"R");
        $ssql="select * from adm_crec3 where idcrec=$idrec and idcht=0";
        $rec3=new adm_crec3_2($ssql);
        $e_det=$rec3->getDetalle();
        $e_imp=$rec3->getImporte();
        for($i=0;$i<count($e_det);$i++) {
            $this->SetX(15);
            $this->Cell(10,5, utf8_decode($e_det[$i]),0);
            $this->SetX(150);
            $this->Cell(20,5,number_format($e_imp[$i],2),0,1,"R");
        }
        $this->line(5,$this->GetY(),205,$this->GetY());
        $this->SetFont("Arial","B",10);
        $this->SetX(100);
        $this->Cell(20,5,utf8_decode("Usted Pagó:"),0,0);
        $this->SetX(150);
        $this->Cell(20,5,number_format(array_sum($e_imp)+array_sum($r_imp),2),0,1,"R");
        $this->SetXY(130,250);
        $this->SetFont("Arial","",10);
        $this->Cell(70,5,"_______________________________",0,1,"C");
        $this->SetX(130);
        $this->Cell(70,5,"Firma",0,1,"C");
        $this->SetXY(130,260);
        $this->SetFont("Courier", "", 10);
        $this->Cell(70,5,$cfg->getFiscalnombre(),0,1,"C");
        $this->SetX(130);
        $this->Cell(70,5,utf8_decode($cfg->getFiscalresponsable()),0,1,"C");
        $this->SetX(130);
        $this->Cell(70,5,utf8_decode($cfg->getFiscalcargo()),0,1,"C");
        
    }
    
}
