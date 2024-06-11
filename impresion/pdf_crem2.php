<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_crem2 extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {

    }
//
    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        global $cartel;

        global $d_articulo;
        global $d_cantidad;
        global $d_precio;        
        global $d_total;     
        global $d_recipiente;
        global $observaciones;
        global $cantidaddet;
        global $canttotal;
        global $totalrec;           
        global $cfg;
        global $colu;
        global $carteltarea;
        global $patente;
        global $adm;
        global $direccion;
        global $copiasimp;
        
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
//        print_r($copiasimp);
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
//        
        //$this->fact_dev( utf8_decode($carteltarea),0,125);
        //$this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        //$this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=205;
        $y1=5;
        $y2=50;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    

        $this->SetXY(10, 7);
        $this->SetFont("Arial","B",16);
        $this->Cell(50,5,"Dinardi Menudencias S.A.",0,1,"L");
        $this->SetFont("Arial","",10);        
        $this->Cell(50,5,"Venta de Subproductos Ganaderos",0,2,"L");
        $this->Line(10, 17, 67, 17);        
        $this->SetFont("Arial","B",10);        
        $this->SetXY(10,25);
        $this->Cell(50,5,"RUTA 41       Km 64,400",0,1,"L");        
        $this->Cell(50,5,"2325 440380 - 443620",0,1,"L");        
        $this->Cell(50,5,utf8_decode("6270 San Andrés de Giles (B)"),0,1,"L");
        $this->SetFont("Arial","",10); 
        $this->Cell(50,5,"IVA RESPONSABLE INSCRIPTO",0,1,"L");        
        
        
        $this->Line(102, 5, 102, 15);
        $this->setXY(100,16);
        $this->SetFont("Arial","B",18);
        $this->Cell(5,5,"R",0,1,"C");
        $this->setXY(100,20);        
        $this->SetFont("Arial","",7);        
        $this->Cell(5,5,utf8_decode("CODIGO N°11"),0,1,"C");
        $this->Line(102, 24, 102, 50);        
        $this->SetFont("Arial","",7);          
        $this->SetXY(130, 5);
        $this->Cell(5,5,utf8_decode("DOCUMENTO NO VÁLIDO COMO FACTURA"),0,1,"L");
        
        
        $this->SetFont("Arial","B",12);          
        $this->SetXY(140, 10);
        $this->Cell(5,5,utf8_decode("REMITO - ".$copia ),0,1,"L");
        
        $this->SetFont("Arial","B",10);          
        $this->SetXY(135, 15);
        $this->Cell(5,5,utf8_decode("N° 0001-   ").$sup->Addzeros($adm->getNumero(),8),0,1,"L");
        
        $this->SetFont("Arial","",10);          
        
        $this->Line(135, 22, 168, 22);      
        $this->Line(135, 26, 168, 26);      
        $this->Line(135, 22, 135, 33);      
        $this->Line(168, 22, 168, 33);   
        $this->Line(135, 33, 168, 33); 
        $this->Line(146, 22, 146, 33);
        $this->Line(157, 22, 157, 33);
        
        
        $this->SetXY(135, 22);
        $this->Cell(11,4,utf8_decode("Día"),0,1,"C");
        $this->SetXY(135, 27);        
        $this->Cell(11,4,substr($dsup->getFechaNormalCorta($adm->getFecha()),0,2),0,1,"C");
        
        $this->SetXY(146, 22);
        $this->Cell(11,4,utf8_decode("Mes"),0,1,"C");
        $this->SetXY(146, 27);        
        $this->Cell(11,4,substr($dsup->getFechaNormalCorta($adm->getFecha()),3 ,2),0,1,"C");

        $this->SetXY(157, 22);
        $this->Cell(11,4,utf8_decode("Año"),0,1,"C");
        $this->SetXY(157, 27);        
        $this->Cell(11,4,substr($dsup->getFechaNormalCorta($adm->getFecha()),6,4),0,1,"C");
        
        $this->SetFont("Arial","",8);        
        $this->SetXY(125,35);
        $this->Cell(50,5,"CUIT: 33-71247515-9",0,1,"L");  
        $this->SetXY(125,39);        
        $this->Cell(50,5,"INGRESOS BRUTOS: 33-71247515-9",0,1,"L");        
        $this->SetXY(125,43);
        $this->Cell(50,5,"INICIO DE ACTIVIDADES: 09/12",0,1,"L");        
        

        
        $this->SetFont("Arial","",10);
        $this->setXY(5,50);
        $this->Cell(10,5,"Cliente",0,1,"L");
        $this->SetX(5);         
        $this->Cell(10,5,utf8_decode("Dirección"),0,1,"L");
        $this->SetX(5);         
        $this->Cell(10,5,utf8_decode("Localidad"),0,1,"L");        
        $this->SetX(5);         
        $this->Cell(10,5,utf8_decode("Patente"),0,1,"L");
        $this->setXY(120,50);
        $this->Cell(10,5,"CUIT",0,1,"L");
        $this->setXY(120,55);
        $this->Cell(10,5,"Cond. IVA",0,1,"L");
        
        $this->SetFont("Arial","B",10); 
        $this->setXY(25,50);
        $this->Cell(10,5,utf8_decode($adm->getCliente()),0,1,"L");
        $this->SetX(25);         
        $this->Cell(10,5,$direccion,0,1,"L");   
        $this->SetX(25);         
        $this->Cell(10,5,$adm->getCiudad(),0,1,"L");   
        $this->SetX(25);         
        $this->Cell(10,5,$patente,0,1,"L");        
        $this->setXY(140,50);
        $this->Cell(10,5,$adm->getCuit(),0,1,"L");
        $this->setXY(140,55);
        $this->Cell(10,5,$adm->getCondiva(),0,1,"L");
        
        $this->SetX(130);
        $this->Cell(70,7,"Fecha de Entrega: ".$dsup->getFechaNormalCorta($adm->getFechaentrega()),1,0,"C");
        

        $r1=5;
        $r2=205;
        $y1=50;
        $y2=70;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $r1=5;
        $r2=205;
        $y1=70;
        $y2=260;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');  
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXy($colu[0], 70);
        $this->Cell(10,5,"Cantidad",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,utf8_decode("Descripción"),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(20,5,utf8_decode("Recipiente"),0,0,"R");
        $this->SetX($colu[3]);
        $this->Cell(20,5,utf8_decode("Precio"),0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,utf8_decode("Total"),0,1,"R");              

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($d_cantidad);$i++) {          
        $this->setX($colu[0]);
        $this->Cell(10,5,$d_cantidad[$i],0,0,"C");       
        $this->SetX($colu[1]);
        $this->Cell(15,5,$d_articulo[$i],0,0,"L"); 
        $this->SetX($colu[2]);
        $this->Cell(20,5,$d_recipiente[$i],0,0,"R");
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format($d_precio[$i],2),0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,number_format($d_precio[$i]*$d_cantidad[$i],2),0,1,"R");      

         $this->Line(5, $this->GetY(), 205, $this->GetY());
        }           
        $this->SetFont("Arial", "B", 10);
        $this->SetX($colu[0]);
        $this->Cell(10,5,number_format($canttotal,2),0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(20,5,$totalrec,0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,number_format($d_total,2),0,0,"R");
        $this->SetXY(10,230);
        $this->SetFont("Arial", "", 8);
        $this->MultiCell(190, 5, $observaciones, 0);    
        $r1=5;
        $r2=205;
        $y1=260;
        $y2=280;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');  
        $this->Line(50, 260, 50, 280);
        $this->SetXY(10, 263);
        $this->SetFont("Arial","B",7);         
        $this->MultiCell(30, 4, "Abastos e impuestos internos a cargo del comprador");                       
                     
        $this->SetXY(60,263);
        $this->SetFont("Arial","",10);         
        $this->Cell(150,5,utf8_decode("Recibí conforme:___________________________________________________"),0,1);
        $this->SetXY(60,269);
        $this->Cell(150,5,utf8_decode("Aclaración:________________________________________________________"),0,1);        
        }
    }
}
