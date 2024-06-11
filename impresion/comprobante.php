<?php
/*
 * Creado el 03/01/2019 17:35:06
 * Autor: gus
 * Archivo: comprobante.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_ComprobanteFiscal extends pdf_function {
    var $colonnes;
    var $format;
    var $angle=0;
    
    function Header() {
        require_once 'clases/support.php';
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_fis_det.php';
        $dsup=new datesupport();
        $sup=new support();
        global $fis;
        global $cfg;
        global $copiasimp;
        global $c;
        global $copia;
//        echo "copia: $copia|$c|$copiasimp<br>";
        $cli=new adm_cli_1($fis->getIdcli());
        $ssql="select * from adm_fis_det where idfis=".$fis->getId()." order by id";
        $det=new adm_fis_det_2($ssql);
        $d_can=$det->getCantidad();
        $d_cod=$det->getIdart();
        $d_art=$det->getDetalle();
        $d_pre=$det->getPrecio();
        $d_iva=$det->getAlicuota();
        $codigocomp=$fis->getCodigocomp();
        switch ($fis->getTipo()) {
            case "F":
                $comprobante="FACTURA";
                break;
            case "C":
                $comprobante="NOTA DE CRÉDITO";
                break;
            case "D":
                $comprobante="NOTA DE DÉBITO";
                break;
            case "G":
                $comprobante="FACTURA DE CRÉDITO ELECTRÓNICA MiPyMEs (FCE)";
                break;
            case "H":
                $comprobante="NOTA DE CRÉDITO ELECTRÓNICA MiPyMEs";
                break;
            case "I":
                $comprobante="NOTA DE DÉBITO ELECTRÓNICA MiPyMEs";
                break;
        }
        switch ($copiasimp) {
            case 1:
                $c1=0;
                $c2=1;
                break;
            case 2:
                $c1=1;
                $c2=2;
                break;
            case 3:
                $c1=2;
                $c2=3;
                break;
            case 4:
                $c1=0;
                $c2=2;
                break;
            case 5:
                $c1=0;
                $c2=3;
                break;
        }
//        $this->AddPage();
        switch ($copiasimp) {
            case 1:
                $copia="ORIGINAL";
                break;
            case 2:
                $copia="DUPLICADO";
                break;
            case 3:
                $copia="TRIPLICADO";
                break;
        }
        $remito_fis=$fis->getRem_numero();
        $remitos="";
        for($i=0;$i<count($remito_fis);$i++) {
            $remitos.=$remito_fis[$i]." ";
        }
        $r1=5;
        $r2=205;
        $y1=5;
        $y2=55;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetXY(5,5);
        $this->SetFont("Arial","B",14);
        $this->Cell(200,10,$copia,0,1,"C");
        $this->SetX(5);
        $this->SetFont("Arial","",10);
        $this->line(5,$this->GetY(),205,$this->GetY());
        $r1=97;
        $r2=112;
        $y1=15;
        $y2=30;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetFont("Arial","B",30);
        $this->SetXY(5,15);
        $this->Cell(200,15,$fis->getLetra(),0,0,"C");
        $this->SetFont("Arial","B",8);
        $this->SetXY(5,25);
        $this->Cell(200,5,"COD. $codigocomp",0,0,"C");
        $this->SetXY(5,18);
        $this->SetFont("Arial","B",17);
        $this->Cell(90,5,$cfg->getFiscalnombre(),0,0);
        $this->SetXY(7,25);
        $this->SetFont("Arial","B",8);
        $this->Cell(20,5,utf8_decode("Razón Social:"),0,0);
        $this->SetXY(7,30);
        $this->Cell(20,5,utf8_decode("Domicilio Comercial:"),0,0);
        $this->SetXY(7,40);
        $this->Cell(20,5,utf8_decode("Condición frente al IVA:"),0,0);
        $this->SetFont("Arial","",8);
        $this->SetXY(45,25);
        $this->Cell(20,5,$cfg->getFiscalnombre(),0,0);
        $this->SetXY(45,30);
        $this->MultiCell(50,4,  utf8_decode($cfg->getFiscaldireccion()));
        $this->SetXY(45,40);
        $this->Cell(20,5,$cfg->getFiscaliva(),0,1);
        $this->SetXY(112,18);
        $this->SetFont("Arial","B","14");
        $this->MultiCell(95,5, utf8_decode($comprobante),0,"C");
        $this->SetFont("Arial","B",9);
        $this->SetX(115);
        $this->Cell(30,5,"Punto de Venta: ",0,0);
        $this->SetX(155);
        $this->Cell(30,5,"Comp. Nro: ",0,0);
        $this->SetFont("Arial","B",10);
        $this->SetX(140);
        $this->Cell(10,5,$sup->AddZeros($fis->getPtovta(),4),0,0);
        $this->SetX(174);
        $this->Cell(10,5,$sup->AddZeros($fis->getNumero(), 8),0,1);
        $this->SetX(115);
        $this->SetFont("Arial","B",9);
        $this->Cell(10,5,utf8_decode("Fecha de Emisión:"),0,0);
        $this->SetFont("Arial","B",10);
        $this->SetX(145);
        $this->Cell(10,5,$dsup->getFechaNormalCorta($fis->getFecha()),0,1);
//            $this->Cell(10,5,"",0,1);
        $this->SetX(115);
        $this->SetFont("Arial","B",9);
        $this->Cell(10,5,"CUIT:",0,0);
        $this->SetFont("Arial","",10);
        $this->SetX(145);
        $this->Cell(10,5,$cfg->getFiscalcuit(),0,1);
        $this->SetX(115);
        $this->SetFont("Arial","B",9);
        $this->Cell(10,5,"Ingresos Brutos:",0,0);
        $this->SetFont("Arial","",10);
        $this->SetX(145);
        $this->Cell(10,5,$cfg->getFiscalcuit(),0,1);
        $this->SetX(115);
        $this->SetFont("Arial","B",9);
        $this->Cell(10,5,"Fecha Inicio de Actividades:",0,0);
        $this->SetFont("Arial","",10);
        $this->SetX(160);
        $this->Cell(10,5,$dsup->getFechaNormalCorta($cfg->getFiscalfechainicio()),0,1);
        $this->line(104,30,104,55);

        $r1=5;
        $r2=205;
        $y1=56;
        $y2=62;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetFont("Arial","B",10);
        $this->SetXY(10,57);
        $this->Cell(20,5,utf8_decode("Período Facturado Desde:"),0,0);
        $this->SetX(80);
        $this->Cell(20,5,utf8_decode("Hasta:"),0,0);
        $this->SetX(130);
        $this->Cell(20,5,utf8_decode("Fecha de Vto. para el pago:"),0,0);
        $this->SetFont("Arial","",10);
        $this->SetXY(55,57);
        $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFechaperini()),0,0);
        $this->SetX(92);
        $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFechaperfin()),0,0);
        $this->SetX(177);
        $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFechapago()),0,0);

        $r1=5;
        $r2=205;
        $y1=63;
        $y2=69;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetXY(30,64);
        $this->SetFont("Arial","B",10);
        $this->Cell(50,5,"CBU del Emisor:",0,0);
        $this->SetX(120);
        $this->Cell(50,5,"Alias CBU:",0,0);
        $this->SetFont("Arial", "", 10);
        $this->SetX(60,64);
        $this->Cell(20,5,$cfg->getCbu(),0,0);
        $this->SetX(140);
        $this->Cell(20,5,$cfg->getAliascbu(),0,0);


        $r1=5;
        $r2=205;
        $y1=70;
        $y2=100;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
        $this->SetFont("Arial","B",10);
        $this->SetXY(10,70);
        $this->Cell(10,5,"CUIT:",0,0);
        $this->SetX(70);
        $this->Cell(60,5,utf8_decode("Apellido y Nombre / Razón Social:"),0,0,"R");
        $this->SetXY(10,80);
        $this->Cell(10,5,  utf8_decode("Condición frente al IVA:"),0,0);
        $this->SetX(70);
        $this->Cell(60,5,  utf8_decode("Domicilio Comercial:"),0,0,"R");
        $this->SetXY(10,90);
        $this->Cell(10,5,  utf8_decode("Condición de Venta:"),0,0);
        $this->SetX(93);
        $this->Cell(10,5,"Remitos",0,0);

        $this->SetFont("Arial","",10);
        $this->SetXY(20,70);
        $this->Cell(10,5,$cli->getCuit(),0,0);
        $this->SetX(130);
        $this->MultiCell(60,5,utf8_decode($cli->getApellido()." ".$cli->getNombre()),0,1);
        $this->SetXY(52,80);
        $this->Cell(10,5,  utf8_decode($cli->getCondicionivades()),0,0);
        $this->SetX(130);
        $this->MultiCell(60,5,  utf8_decode($cli->getDireccion()." ".$cli->getCiudaddes()),0,1);
        $this->SetXY(46,90);
        $this->Cell(10,5,  utf8_decode($fis->getTipopagodes()),0,0);
        $this->SetX(110);
        $this->MultiCell(90,5,$remitos, 0);
        $r1=5;
        $r2=205;
        $y1=101;
        $y2=109;
        $this->SetFont("Arial","",8);
        $this->SetFillColor(200,200,200);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'DF');  
        $this->SetFillColor(0,0,0);
        if($fis->getLetra()=="A") {
            $this->SetXY(5,101);
            $this->Cell(90,8,"Producto / Servicio",1,0,"C");
            $this->SetX(95);
            $this->Cell(15,8,"Cantidad",1,0,"C");
            $this->SetX(110);
            $this->Cell(15,8,"Unidad",1,0,"C");
            $this->SetX(125);
            $this->Cell(20,8,"Precio Unit.",1,0,"C");
            $this->SetX(145);
            $this->Cell(10,8,"%Bonif",1,0,"C");
            $this->SetX(155);
            $this->Cell(20,8,"Subtotal",1,0,"C");
            $this->SetX(175);
            $this->Cell(10,8,"Alicuota",1,0,"C");
            $this->SetX(185);
            $this->Cell(20,8,"Subtotal c/Iva",1,1,"C");
        } else {
            $this->SetXY(5,101);
            $this->Cell(20,8,"Codigo",1,0,"C");
            $this->SetX(25);
            $this->Cell(70,8,"Producto / Servicio",1,0,"C");
            $this->SetX(95);
            $this->Cell(15,8,"Cantidad",1,0,"C");
            $this->SetX(110);
            $this->Cell(15,8,"Unidad",1,0,"C");
            $this->SetX(125);
            $this->Cell(20,8,"Precio Unit.",1,0,"C");
            $this->SetX(145);
            $this->Cell(10,8,"%Bonif",1,0,"C");
            $this->SetX(155);
            $this->Cell(20,8,"Imp.Bonif. ",1,0,"C");
            $this->SetX(175);
            $this->Cell(30,8,"Subtotal c/Iva",1,1,"C");
        }
        
    }
    
    function addDetalle() {
        require_once 'clases/support.php';
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_fis_det.php';
        require_once 'qrcode/qrcode.class.php';
        require_once 'clases/afip_json.php';  
        $dsup=new datesupport();
        $sup=new support();
        global $fis;
        global $cfg;
        global $copiasimp;
        global $codigocomp;
        $js=new afip_json($fis->getId());
        $cli=new adm_cli_1($fis->getIdcli());
        $ssql="select * from adm_fis_det where idfis=".$fis->getId()." order by id";
        $det=new adm_fis_det_2($ssql);
        $d_can=$det->getCantidad();
        $d_cod=$det->getIdart();
        $d_art=$det->getDetalle();
        $d_pre=$det->getPrecio();
        $d_iva=$det->getAlicuota();
        
        $x_art=array();
        $x_can=array();
        $x_pre=array();
        $x_iva=array();
        $x_cod=array();
        $cad=array();
        
        for($i=0;$i<count($d_can);$i++) {
            $aguja=$d_art[$i]."|".$d_pre[$i]."|".$d_iva[$i]."|".$d_cod[$i];
            $search= array_search($aguja, $cad);
//            echo $aguja."\n";
//            echo "search: $search\n";
            if($search===false) {
                array_push($cad,$aguja);
                array_push($x_art,$d_art[$i]);
                array_push($x_can,$d_can[$i]);
                array_push($x_pre,$d_pre[$i]);
                array_push($x_iva,$d_iva[$i]);
                array_push($x_cod,$d_cod[$i]);
            } else {
                $x_can[$search]+=$d_can[$i];
            }
        }
        
//        print_r($cad);
        
        $codigocomp=$fis->getCodigocomp();
        switch ($fis->getTipo()) {
            case "F":
                $comprobante="FACTURA";
                break;
            case "C":
                $comprobante="NOTA DE CRÉDITO";
                break;
            case "D":
                $comprobante="NOTA DE DÉBITO";
                break;
            case "FCE":
                $comprobante="FACTURA DE CRÉDITO ELECTRÓNICA MiPyMEs (FCE)";
                break;
            case "NCE":
                $comprobante="NOTA DE CRÉDITO ELECTRÓNICA MiPyMEs";
                break;
            case "NDE":
                $comprobante="NOTA DE DÉBITO ELECTRÓNICA MiPyMEs";
                break;
        }
        switch ($copiasimp) {
            case 1:
                $c1=0;
                $c2=1;
                break;
            case 2:
                $c1=1;
                $c2=2;
                break;
            case 3:
                $c1=2;
                $c2=3;
                break;
            case 4:
                $c1=0;
                $c2=2;
                break;
            case 5:
                $c1=0;
                $c2=3;
                break;
        }
        for($c=$c1;$c<$c2;$c++) {
            $this->AddPage();
            switch ($c) {
                case 0:
                    $copia="ORIGINAL";
                    break;
                case 1:
                    $copia="DUPLICADO";
                    break;
                case 2:
                    $copia="TRIPLICADO";
                    break;
            }
//        echo "copiax: $copia<br>";
            
//            $r1=5;
//            $r2=205;
//            $y1=5;
//            $y2=55;
//            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
//            $this->SetXY(5,5);
//            $this->SetFont("Arial","B",14);
//            $this->Cell(200,10,$copia,0,1,"C");
//            $this->SetX(5);
//            $this->SetFont("Arial","",10);
//            $this->line(5,$this->GetY(),205,$this->GetY());
//            $r1=97;
//            $r2=112;
//            $y1=15;
//            $y2=30;
//            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
//            $this->SetFont("Arial","B",30);
//            $this->SetXY(5,15);
//            $this->Cell(200,15,$fis->getLetra(),0,0,"C");
//            $this->SetFont("Arial","B",8);
//            $this->SetXY(5,25);
//            $this->Cell(200,5,"COD. $codigocomp",0,0,"C");
//            $this->SetXY(5,18);
//            $this->SetFont("Arial","B",17);
//            $this->Cell(90,5,$cfg->getFiscalnombre(),0,0);
//            $this->SetXY(7,25);
//            $this->SetFont("Arial","B",8);
//            $this->Cell(20,5,utf8_decode("Razón Social:"),0,0);
//            $this->SetXY(7,30);
//            $this->Cell(20,5,utf8_decode("Domicilio Comercial:"),0,0);
//            $this->SetXY(7,40);
//            $this->Cell(20,5,utf8_decode("Condición frente al IVA:"),0,0);
//            $this->SetFont("Arial","",8);
//            $this->SetXY(45,25);
//            $this->Cell(20,5,$cfg->getFiscalnombre(),0,0);
//            $this->SetXY(45,30);
//            $this->MultiCell(50,4,  utf8_decode($cfg->getFiscaldireccion()));
//            $this->SetXY(45,40);
//            $this->Cell(20,5,$cfg->getFiscaliva(),0,1);
//            $this->SetXY(112,18);
//            $this->SetFont("Arial","B","14");
//            $this->MultiCell(95,5, utf8_decode($comprobante),0,"C");
//            $this->SetFont("Arial","B",9);
//            $this->SetX(115);
//            $this->Cell(30,5,"Punto de Venta: ",0,0);
//            $this->SetX(155);
//            $this->Cell(30,5,"Comp. Nro: ",0,0);
//            $this->SetFont("Arial","B",10);
//            $this->SetX(140);
//            $this->Cell(10,5,$sup->AddZeros($fis->getPtovta(),4),0,0);
//            $this->SetX(174);
//            $this->Cell(10,5,$sup->AddZeros($fis->getNumero(), 8),0,1);
//            $this->SetX(115);
//            $this->SetFont("Arial","B",9);
//            $this->Cell(10,5,utf8_decode("Fecha de Emisión:"),0,0);
//            $this->SetFont("Arial","B",10);
//            $this->SetX(145);
//            $this->Cell(10,5,$dsup->getFechaNormalCorta($fis->getFecha()),0,1);
////            $this->Cell(10,5,"",0,1);
//            $this->SetX(115);
//            $this->SetFont("Arial","B",9);
//            $this->Cell(10,5,"CUIT:",0,0);
//            $this->SetFont("Arial","",10);
//            $this->SetX(145);
//            $this->Cell(10,5,$cfg->getFiscalcuit(),0,1);
//            $this->SetX(115);
//            $this->SetFont("Arial","B",9);
//            $this->Cell(10,5,"Ingresos Brutos:",0,0);
//            $this->SetFont("Arial","",10);
//            $this->SetX(145);
//            $this->Cell(10,5,$cfg->getFiscalcuit(),0,1);
//            $this->SetX(115);
//            $this->SetFont("Arial","B",9);
//            $this->Cell(10,5,"Fecha Inicio de Actividades:",0,0);
//            $this->SetFont("Arial","",10);
//            $this->SetX(160);
//            $this->Cell(10,5,$dsup->getFechaNormalCorta($cfg->getFiscalfechainicio()),0,1);
//            $this->line(104,30,104,55);
//
//            $r1=5;
//            $r2=205;
//            $y1=56;
//            $y2=62;
//            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
//            $this->SetFont("Arial","B",10);
//            $this->SetXY(10,57);
//            $this->Cell(20,5,utf8_decode("Período Facturado Desde:"),0,0);
//            $this->SetX(80);
//            $this->Cell(20,5,utf8_decode("Hasta:"),0,0);
//            $this->SetX(130);
//            $this->Cell(20,5,utf8_decode("Fecha de Vto. para el pago:"),0,0);
//            $this->SetFont("Arial","",10);
//            $this->SetXY(55,57);
//            $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFechaperini()),0,0);
//            $this->SetX(92);
//            $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFechaperfin()),0,0);
//            $this->SetX(177);
//            $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFechapago()),0,0);
//            
//            $r1=5;
//            $r2=205;
//            $y1=63;
//            $y2=69;
//            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
//            $this->SetXY(30,64);
//            $this->SetFont("Arial","B",10);
//            $this->Cell(50,5,"CBU del Emisor:",0,0);
//            $this->SetX(120);
//            $this->Cell(50,5,"Alias CBU:",0,0);
//            $this->SetFont("Arial", "", 10);
//            $this->SetX(60,64);
//            $this->Cell(20,5,$cfg->getCbu(),0,0);
//            $this->SetX(140);
//            $this->Cell(20,5,$cfg->getAliascbu(),0,0);
//            
//
//            $r1=5;
//            $r2=205;
//            $y1=70;
//            $y2=100;
//            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
//            $this->SetFont("Arial","B",10);
//            $this->SetXY(10,70);
//            $this->Cell(10,5,"CUIT:",0,0);
//            $this->SetX(70);
//            $this->Cell(60,5,utf8_decode("Apellido y Nombre / Razón Social:"),0,0,"R");
//            $this->SetXY(10,80);
//            $this->Cell(10,5,  utf8_decode("Condición frente al IVA:"),0,0);
//            $this->SetX(70);
//            $this->Cell(60,5,  utf8_decode("Domicilio Comercial:"),0,0,"R");
//            $this->SetXY(10,90);
//            $this->Cell(10,5,  utf8_decode("Condición de Venta:"),0,0);
//
//            $this->SetFont("Arial","",10);
//            $this->SetXY(20,70);
//            $this->Cell(10,5,$cli->getCuit(),0,0);
//            $this->SetX(130);
//            $this->MultiCell(60,5,utf8_decode($cli->getApellido()." ".$cli->getNombre()),0,1);
//            $this->SetXY(52,80);
//            $this->Cell(10,5,  utf8_decode($cli->getCondicionivades()),0,0);
//            $this->SetX(130);
//            $this->MultiCell(60,5,  utf8_decode($cli->getDireccion()." ".$cli->getCiudaddes()),0,1);
//            $this->SetXY(46,90);
//            $this->Cell(10,5,  utf8_decode("Cuenta Corriente"),0,0);
//
//            $r1=5;
//            $r2=205;
//            $y1=101;
//            $y2=109;
//            $this->SetFont("Arial","",8);
//            $this->SetFillColor(200,200,200);
//            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'DF');  
//            $this->SetFillColor(0,0,0);
//            if($fis->getLetra()=="A") {
//                $this->SetXY(5,101);
//                $this->Cell(90,8,"Producto / Servicio",1,0,"C");
//                $this->SetX(95);
//                $this->Cell(15,8,"Cantidad",1,0,"C");
//                $this->SetX(110);
//                $this->Cell(15,8,"Unidad",1,0,"C");
//                $this->SetX(125);
//                $this->Cell(20,8,"Precio Unit.",1,0,"C");
//                $this->SetX(145);
//                $this->Cell(10,8,"%Bonif",1,0,"C");
//                $this->SetX(155);
//                $this->Cell(20,8,"Subtotal",1,0,"C");
//                $this->SetX(175);
//                $this->Cell(10,8,"Alicuota",1,0,"C");
//                $this->SetX(185);
//                $this->Cell(20,8,"Subtotal c/Iva",1,1,"C");
//            } else {
//                $this->SetXY(5,101);
//                $this->Cell(20,8,"Codigo",1,0,"C");
//                $this->SetX(25);
//                $this->Cell(70,8,"Producto / Servicio",1,0,"C");
//                $this->SetX(95);
//                $this->Cell(15,8,"Cantidad",1,0,"C");
//                $this->SetX(110);
//                $this->Cell(15,8,"Unidad",1,0,"C");
//                $this->SetX(125);
//                $this->Cell(20,8,"Precio Unit.",1,0,"C");
//                $this->SetX(145);
//                $this->Cell(10,8,"%Bonif",1,0,"C");
//                $this->SetX(155);
//                $this->Cell(20,8,"Imp.Bonif. ",1,0,"C");
//                $this->SetX(175);
//                $this->Cell(30,8,"Subtotal c/Iva",1,1,"C");
//            }
            $subtotal=0;
            $iva27=0;
            $iva10=0;
            $iva21=0;
            $iva5=0;
            $iva25=0;
            $iva0=0;
            $cnt=0;
            for($i=0;$i<count($x_art);$i++) {
                $cnt++;
                if($cnt==19) {
                    $this->AddPage();
                    $cnt=0;
                }
                $coef=1+ ($x_iva[$i]/100);
                $precio=$x_pre[$i]/$coef;
                $this->SetX(5);
                $this->Cell(70,5,$x_art[$i],0,0);
                $this->SetX(95);
                $this->Cell(15,5,$x_can[$i],0,0,"C");
                $this->SetX(110);
                $this->Cell(15,5,"Kilos",0,0,"C");
                $this->SetX(125);
                $this->Cell(20,5,number_format($precio,5),0,0,"C");
                $this->SetX(145);    
                $this->Cell(10,5,"0.00",0,0,"C");
                if($fis->getLetra()=="A") {
                    $this->SetX(155);
                    $this->Cell(20,5,number_format($precio*$x_can[$i],2),0,0,"C");
                    $this->SetX(175);
                    $this->Cell(10,5,number_format($x_iva[$i],2),0,0,"C");
                    $this->SetX(185);    
                    $this->Cell(20,5,number_format($precio*$x_can[$i]*$coef,2),0,1,"C");
                    switch ($x_iva[$i]) {
                        case 21:
                            $iva21+=$x_pre[$i]*$x_can[$i];
                            break;
                        case 10.5:
                            $iva10+=$x_pre[$i]*$x_can[$i];
                            break;
                    }
                } else {
                    $this->SetX(155);
                    $this->Cell(20,5,number_format(0,2),0,0,"C");
                    $this->SetX(175);
                    $this->Cell(30,5,number_format($x_pre[$i]*$x_can[$i],2),0,1,"C");
                    
                }
                $subtotal+=$x_pre[$i]*$x_can[$i];
            }
//            echo "subtotal: $subtotal<br>";
//            echo "neto: ".$fis->getNeto()."<br>";
//            echo "iva21: ".$fis->getIva21()."<br>";
//            echo "iva10: ".$fis->getIva10()."<br>";
//            $tt=$fis->getNeto()+$fis->getIva21()+$fis->getIva10();
//            echo "subtotal2: $tt<br>";
//            if($cli->getCondicioniva()!=2)
//                $iva21=$subtotal*21/100;
            $this->SetXY(5,190);
//            $this->Cell(100,5,  utf8_decode($fis->getTexto()),0,0);
            if($fis->getLetra()=="A") {
                $r1=5;
                $r2=205;
                $y1=200;
                $y2=255;
                $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
                $this->SetFont("Arial","B",10);
                $this->SetXY(5,200);
                $this->Cell(20,5,"Otros Tributos",0,1);
                $r1=6;
                $r2=120;
                $y1=205;
                $y2=210;
                $this->SetFont("Arial","",8);
                $this->SetFillColor(200,200,200);
                $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'DF');  
                $this->SetFillColor(0,0,0);
                $this->SetXY(6,205);
                $this->Cell(55,5,utf8_decode("Descripción"),1,0,"L");
                $this->SetX(61);
                $this->Cell(30,5,"Detalle",1,0,"L");
                $this->SetX(91);
                $this->Cell(9,5,"Alic. %",1,0,"C");
                $this->SetX(100);
                $this->Cell(20,5,"Importe",1,1,"R");
                $det_impuesto=array("Per./Ret. de Impuestos a las Ganacias", "Per./Ret. de IVA", "Per./Ret. Ingresos Brutos", "Impuestos Internos","Impuestos Municipales", "Impuestos Municipales", "Impuestos Municipales");
                $det_importe=Array(0,0,$fis->getPercepcioniibb(),0,0,0,0);
                for($ii=0;$ii<count($det_impuesto);$ii++) {
                    $this->SetX(6);
                    $this->Cell(55,5,$det_impuesto[$ii],0,0);
                    $this->SetX(100);
                    $this->Cell(20,5,number_format($det_importe[$ii],2),0,1,"R");
                }
                $this->SetX(61);
                $this->SetFont("Arial","",10);
                $this->Cell(30,5,"Importe Otros Tributos: $");
                $this->SetX(100);
                $this->Cell(20,5,number_format(array_sum($det_importe),2),0,1,"R");

                $this->SetFont("Arial","B",10);
                $this->SetXY(120,205);
                $this->Cell(50,5,"Importe Neto Gravado: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"Importe No Gravado: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"IVA 27%: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"IVA 21%: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"IVA 10.5%: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"IVA 5%: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"IVA 2.5%: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"IVA 0%: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"Importe Otros Tributos: $",0,1,"R");
                $this->SetFont("Arial","B",12);
                $this->SetX(120);
                $this->Cell(50,5,"Importe Total: $",0,1,"R");
                $this->SetFont("Arial","B",10);
                $this->SetXY(170,205);
                $this->Cell(35,5,number_format($fis->getNeto(),2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($fis->getNogravado(),2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($iva27,2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($fis->getIva21(),2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($fis->getIva10(),2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($iva5,2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($iva25,2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format($iva0,2,".",""),0,1,"R");
                $this->SetX(170);
                $this->Cell(35,5,number_format(array_sum($det_importe),2,".",""),0,1,"R");
                $this->SetFont("Arial","B",12);
                $this->SetX(170);
                $this->Cell(35,5,number_format($fis->getTotaltotal(),2,".",""),0,1,"R");
            } else {
                $r1=5;
                $r2=205;
                $y1=220;
                $y2=250;
                $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
                $this->SetFont("Arial","B",10);
                $this->SetXY(120,225);
                $this->Cell(50,5,"Subtotal: $",0,1,"R");
                $this->SetX(120);
                $this->Cell(50,5,"Importe Otros Tributos: $",0,1,"R");
                $this->SetFont("Arial","B",12);
                $this->SetX(120);
                $this->Cell(50,5,"Importe Total: $",0,1,"R");
                $this->SetFont("Arial","B",10);
                $this->SetXY(170,225);
                $this->Cell(35,5,number_format($subtotal,2,".",""),0,1,"R");
                $this->SetX(170);
                if($cli->getCondicioniva()==4)
                    $this->Cell(35,5,number_format($fis->getPercepcioniibb(),2,".",""),0,1,"R");
                else
                    $this->Cell(35,5,"0.00",0,1,"R");
                $this->SetFont("Arial","B",12);
                $this->SetX(170);
                $this->Cell(35,5,number_format($subtotal+$fis->getPercepcioniibb(),2,".",""),0,1,"R");
            }
        $qrcode=new QRcode($js->getUrl());                
        $this->SetFont("Arial","B",10);
        $this->SetXY(120,255);
        $this->Cell(50,5,"CAE Nro:",0,1,"R");
        $this->SetX(120);
        $this->Cell(50,5,"Fecha de Vto. de CAE:",0,1,"R");
        $this->SetFont("Arial","",10);
        $this->SetXY(170,255);
        $this->Cell(35,5,ltrim(rtrim($fis->getNumerocae())),0,1,"L");
        $this->SetX(170);
        $this->Cell(50,5,date("d/m/Y", strtotime($fis->getFechacae())),0,1,"L");
        $this->Image("clases/logoafip.png", 50, 256);
        $this->SetXY(50,265);
        $this->SetFont("Arial","BI",10);
        $this->Cell(40,5,"Comprobante Autorizado",0,0);
        $this->SetFont("Arial","B",10);
        $this->SetX(100);
        $this->Cell(10,5,  utf8_decode("Pág. ").$this->PageNo().'/{nb}',0,1);
        $cad=$cli->getCuit().$codigocomp.$sup->AddZeros($fis->getPtovta(), 4).ltrim(rtrim($fis->getNumerocae())).date("Ymd",strtotime($fis->getFechacae()));
//            echo $cli->getCuitdni()."<br>";
//            echo $codigocomp."<br>";
//            echo $sup->AddZeros($fis->getPtovta(), 4)."<br>";
//            echo $fis->getNumerocae()."<br>";
//            echo date("Ymd",strtotime($fis->getFechacae()))."<br>";
//            echo $cad."<br>";
        $dv=$sup->DigitoFiscal($cad);
        $codigobarra=$cad.$dv;
//        $this->i25(5, 267, $codigobarra,0.7,15);
        $this->SetFont("Arial","",7);
        $this->SetXY(50,270);
        $this->Cell(30,5,utf8_decode("Esta administración Federal no se responsabiliza  por los datos ingresados en el detalle de la operación"),0,0);
        $qrcode->displayFPDF($this, 5, 255, 30);            
        }
    }
    
}


class PDF_ComprobanteFiscalA extends pdf_function {
    var $colonnes;
    var $format;
    var $angle=0;
    function addDetalle() {
        require_once 'clases/support.php';
        require_once 'clases/datesupport.php';
        require_once 'clases/edd_alumnos.php';
        require_once 'clases/adm_fis_det.php';
        require_once 'clases/adm_cuit.php';
        $dsup=new datesupport();
        $sup=new support();
        global $fis;
        global $cfg;
        $alu=new edd_alumnos_1($fis->getIdcli());
        $emp=new adm_cuit_1($fis->getCuitfacturacion());
        $ssql="select * from adm_fis_det where idfis=".$fis->getId()." order by id";
        $det=new adm_fis_det_2($ssql);
        $d_can=$det->getCantidad();
        $d_art=$det->getDetalle();
        $d_pre=$det->getPrecio();
        $d_ali=$det->getAlicuota();
        $d_imp=$det->getImporte();
        if($fis->getLetra()=="A")
            $codigocomp="01";
        else
            $codigocomp="06";
        switch ($fis->getTipo()) {
            case "F":
                $comprobante="FACTURA";
                break;
            case "C":
                $comprobante="N.CREDITO";
                break;
            case "D":
                $comprobante="N.DEBITO";
                break;
        }

        for($c=0;$c<=2;$c++) {
            $this->AddPage();
            switch ($this->PageNo()) {
                case 1:
                    $copia="ORIGINAL";
                    break;
                case 2:
                    $copia="DUPLICADO";
                    break;
                case 3:
                    $copia="TRIPLICADO";
                    break;
            }
            
            $r1=5;
            $r2=205;
            $y1=5;
            $y2=55;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
            $this->SetXY(5,5);
            $this->SetFont("Arial","B",14);
            $this->Cell(200,10,$copia,0,1,"C");
            $this->SetX(5);
            $this->SetFont("Arial","",10);
            $this->line(5,$this->GetY(),205,$this->GetY());
            $r1=97;
            $r2=112;
            $y1=15;
            $y2=30;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
            $this->SetFont("Arial","B",30);
            $this->SetXY(5,15);
            $this->Cell(200,15,$fis->getLetra(),0,0,"C");
            $this->SetFont("Arial","B",8);
            $this->SetXY(5,25);
            $this->Cell(200,5,"COD. $codigocomp",0,0,"C");
            $this->SetXY(5,18);
            $this->SetFont("Arial","B",17);
            $this->Cell(90,5,$emp->getRazonsocial(),0,0);
            $this->SetXY(7,25);
            $this->SetFont("Arial","B",8);
            $this->Cell(20,5,utf8_decode("Razón Social:"),0,0);
            $this->SetXY(7,30);
            $this->Cell(20,5,utf8_decode("Domicilio Comercial:"),0,0);
            $this->SetXY(7,40);
            $this->Cell(20,5,utf8_decode("Condición frente al IVA:"),0,0);
            $this->SetFont("Arial","",8);
            $this->SetXY(45,25);
            $this->Cell(20,5,$emp->getRazonsocial(),0,0);
            $this->SetXY(45,30);
            $this->MultiCell(50,4,  utf8_decode($emp->getdomiciliofiscal()));
            $this->SetXY(45,40);
            $this->Cell(20,5,$emp->getCondicioniva(),0,1);
            $this->SetXY(112,18);
            $this->SetFont("Arial","B","17");
            $this->Cell(93,5,$comprobante,0,1,"C");
            $this->SetFont("Arial","B",9);
            $this->SetX(115);
            $this->Cell(30,5,"Punto de Venta: ",0,0);
            $this->SetX(155);
            $this->Cell(30,5,"Comp. Nro: ",0,0);
            $this->SetFont("Arial","B",10);
            $this->SetX(140);
            $this->Cell(10,5,$sup->AddZeros($fis->getPtovta(),4),0,0);
            $this->SetX(174);
            $this->Cell(10,5,$sup->AddZeros($fis->getNumero(), 8),0,1);
            $this->SetX(115);
            $this->SetFont("Arial","B",9);
            $this->Cell(10,5,utf8_decode("Fecha de Emisión:"),0,0);
            $this->SetFont("Arial","B",10);
            $this->SetX(145);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($fis->getFecha()),0,1);
            $this->Cell(10,5,"",0,1);
            $this->SetX(115);
            $this->SetFont("Arial","B",9);
            $this->Cell(10,5,"CUIT:",0,0);
            $this->SetFont("Arial","",10);
            $this->SetX(145);
            $this->Cell(10,5,$emp->getCuit(),0,1);
            $this->SetX(115);
            $this->SetFont("Arial","B",9);
            $this->Cell(10,5,"Ingresos Brutos:",0,0);
            $this->SetFont("Arial","",10);
            $this->SetX(145);
            $this->Cell(10,5,$emp->getCuit(),0,1);
            $this->SetX(115);
            $this->SetFont("Arial","B",9);
            $this->Cell(10,5,"Fecha Inicio de Actividades:",0,0);
            $this->SetFont("Arial","",10);
            $this->SetX(160);
            $this->Cell(10,5,$dsup->getFechaNormalCorta("2014-01-01"),0,1);
            $this->line(104,30,104,55);

            $r1=5;
            $r2=205;
            $y1=56;
            $y2=66;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
            $this->SetFont("Arial","B",10);
            $this->SetXY(10,60);
            $this->Cell(20,5,utf8_decode("Período Facturado Desde:"),0,0);
            $this->SetX(80);
            $this->Cell(20,5,utf8_decode("Hasta:"),0,0);
            $this->SetX(130);
            $this->Cell(20,5,utf8_decode("Fecha de Vto. para el pago:"),0,0);
            $this->SetFont("Arial","",10);
            $this->SetXY(55,60);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFecha()),0,0);
            $this->SetX(92);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFecha()),0,0);
            $this->SetX(177);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($fis->getFecha()),0,0);

            $r1=5;
            $r2=205;
            $y1=67;
            $y2=100;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
            $this->SetFont("Arial","B",10);
            $this->SetXY(10,70);
            $this->Cell(10,5,"CUIT:",0,0);
            $this->SetX(70);
            $this->Cell(60,5,utf8_decode("Apellido y Nombre / Razón Social:"),0,0,"R");
            $this->SetXY(10,80);
            $this->Cell(10,5,  utf8_decode("Condición frente al IVA:"),0,0);
            $this->SetX(70);
            $this->Cell(60,5,  utf8_decode("Domicilio Comercial:"),0,0,"R");
            $this->SetXY(10,90);
            $this->Cell(10,5,  utf8_decode("Condición de Venta:"),0,0);

            $this->SetFont("Arial","",10);
            $this->SetXY(20,70);
            $this->Cell(10,5,$alu->getDocumento(),0,0);
            $this->SetX(130);
            $this->Cell(10,5,utf8_decode($alu->getApellido()." ".$alu->getNombre()),0,0);
            $this->SetXY(52,80);
            $this->Cell(10,5,  utf8_decode("Consumidor Final"),0,0);
            $this->SetX(130);
            $this->MultiCell(60,5,  utf8_decode($alu->getDireccion()." ".$alu->getCiudaddes()),0,"L");
            $this->SetXY(46,90);
            $this->Cell(10,5,  utf8_decode("Cuenta Corriente"),0,0);

            $r1=5;
            $r2=205;
            $y1=101;
            $y2=109;
            $this->SetFont("Arial","",8);
            $this->SetFillColor(200,200,200);
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'DF');  
            $this->SetFillColor(0,0,0);
            $this->SetXY(5,101);
            $this->Cell(20,8,"Codigo",1,0,"C");
            $this->SetX(25);
            $this->Cell(70,8,"Producto / Servicio",1,0,"C");
            $this->SetX(95);
            $this->Cell(15,8,"Cantidad",1,0,"C");
            $this->SetX(110);
            $this->Cell(15,8,"Unidad",1,0,"C");
            $this->SetX(125);
            $this->Cell(20,8,"Precio Unit.",1,0,"C");
            $this->SetX(145);
            $this->Cell(10,8,"%Bonif",1,0,"C");
            $this->SetX(155);
            $this->Cell(20,8,"Subtotal",1,0,"C");
            $this->SetX(175);
            $this->Cell(10,8,"Alicuota",1,0,"C");
            $this->SetX(185);
            $this->Cell(20,8,"Subtotal c/Iva",1,1,"C");
            $subtotal=0;
            $iva27=0;
            $iva10=0;
            $iva21=0;
            $iva5=0;
            $iva25=0;
            $iva0=0;
            for($i=0;$i<count($d_art);$i++) {
                $this->SetX(5);
                $this->Cell(20,5,"",0,0,"C");
                $this->SetX(25);
                $this->Cell(70,5,$d_art[$i],0,0);
                $this->SetX(95);
                $this->Cell(15,5,$d_can[$i],0,0,"C");
                $this->SetX(110);
                $this->Cell(15,5,"",0,0,"C");
                $this->SetX(125);
                $this->Cell(20,5,number_format($d_pre[$i],2),0,0,"C");
                $this->SetX(145);    
                $this->Cell(10,5,"0.00",0,0,"C");
                $this->SetX(155);
                $this->Cell(20,5,number_format($d_pre[$i]*$d_can[$i],2),0,0,"C");
                $this->SetX(175);    
                $this->Cell(10,5,"0.00",0,0,"C");
                $this->SetX(185);    
                $this->Cell(20,5,number_format($d_pre[$i]*$d_can[$i],2),0,1,"C");
                $subtotal+=$d_pre[$i]*$d_can[$i];
            }
            //$iva21=$subtotal*21/100;
            $r1=5;
            $r2=205;
            $y1=220;
            $y2=250;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  

            $this->SetFont("Arial","B",10);
            $this->SetXY(120,225);
            $this->Cell(50,5,"Subtotal: $",0,1,"R");
            $this->SetX(120);
            $this->Cell(50,5,"Importe Otros Tributos: $",0,1,"R");
            $this->SetFont("Arial","B",12);
            $this->SetX(120);
            $this->Cell(50,5,"Importe Total: $",0,1,"R");
            $this->SetFont("Arial","B",10);
            $this->SetXY(170,225);
            $this->Cell(35,5,number_format($subtotal,2,".",""),0,1,"R");
            $this->SetX(170);
            $this->Cell(35,5,"0.00",0,1,"R");
            $this->SetFont("Arial","B",12);
            $this->SetX(170);
            $this->Cell(35,5,number_format($subtotal,2,".",""),0,1,"R");
            $this->SetFont("Arial","B",10);
            $this->SetXY(120,255);
            $this->Cell(50,5,"CAE Nro:",0,1,"R");
            $this->SetX(120);
            $this->Cell(50,5,"Fecha de Vto. de CAE:",0,1,"R");
            $this->SetFont("Arial","",10);
            $this->SetXY(170,255);
            $this->Cell(35,5,$fis->getNumerocae(),0,1,"L");
            $this->SetX(170);
            $this->Cell(50,5,$dsup->getFechaNormalCorta($fis->getFechacae()),0,1,"L");
            $this->Image("logoafip.png", 5, 252);
            $this->SetXY(50,255);
            $this->SetFont("Arial","BI",10);
            $this->Cell(40,5,"Comprobante Autorizado",0,0);
            $this->SetFont("Arial","B",10);
            $this->SetX(100);
            $this->Cell(10,5,  utf8_decode("Pág. 1/1"),0,1);
            $cad=$alu->getDocumento().$codigocomp.$sup->AddZeros($fis->getPtovta(), 4).$fis->getNumerocae().date("Ymd",strtotime($fis->getFechacae()));
            $dv=$sup->DigitoFiscal($cad);
            $codigobarra=$cad.$dv;
            $this->i25(5, 267, $codigobarra,0.7,15);
            $this->SetFont("Arial","",7);
            $this->SetXY(5,262);
            $this->Cell(30,5,utf8_decode("Esta administración Federal no se responsabiliza  por los datos ingresados en el detalle de la operación"),0,0);
                        
        }
    }
    
}
