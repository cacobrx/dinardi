<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_rem2 extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
//        require_once 'clases/datesupport.php';
//        $dsup=new datesupport();
//        global $cfg;
//        global $colu;
//        global $carteltarea;
//        global $adm;
//        global $direccion;
//        global $copiasimp;
//
//        switch ($copiasimp) {
//            case 1:
//                $c1=0;
//                $c2=1;
//                break;
//            case 2:
//                $c1=1;
//                $c2=2;
//                break;
//            case 3:
//                $c1=2;
//                $c2=3;
//                break;
//            case 4:
//                $c1=0;
//                $c2=2;
//                break;
//            case 5:
//                $c1=0;
//                $c2=3;
//                break;
//        }
////        $this->AddPage();
//        switch ($copiasimp) {
//            case 1:
//                $copia="ORIGINAL";
//                break;
//            case 2:
//                $copia="DUPLICADO";
//                break;
//            case 3:
//                $copia="TRIPLICADO";
//                break;
//        }           
//        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
//        //$this->Image("images/logomaral.png",5,5,40,20);
//
//        $this->fact_dev( utf8_decode($carteltarea),0,125);
//    //$pdf->temporaire( $cen->getNombre() );
//        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//    //$pdf->addClient($cli->getId());
//        $this->addPageNumber($this->PageNo());
////        $this->Titulo("LISTADO DE PRODUCTOS", 0);
//        $r1=5;
//        $r2=205;
//        $y1=6;
//        $y2=35;
//        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 0, 'D');  
//        $this->SetXY(5,5);
//        $this->SetFont("Arial","B",14);
//        $this->Cell(200,10,$copia,0,1,"C");
////        $this->line(5,$this->GetY(),205,$this->GetY());
//        $r1=5;
//        $r2=130;
//        $y1=15;
//        $y2=35;
//        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
//        $this->SetFont("Arial","",10);
//        $this->setXY(5,17);
//        $this->Cell(10,5,"Proveedor",0,1,"L");
//        $this->SetX(5);         
//        $this->Cell(10,5,utf8_decode("Dirección"),0,1,"L");
//        $this->SetX(5);
//        $this->Cell(10,5,"Patente",0,1,"L");
//        $this->SetFont("Arial","B",10); 
//        $this->setXY(25,17);
//        $this->Cell(10,5,utf8_decode($adm->getProveedor()),0,1,"L");
//        $this->SetX(25);         
//        $this->Cell(10,5,$direccion,0,1,"L");        
//        $this->SetX(25);
//        $this->Cell(10,5,$adm->getPatente(),0,1,"L");
//        $r1=5;
//        $r2=205;
//        $y1=35;
//        $y2=290;
//        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
//        $this->Ln(10);
//        $this->SetFont("Arial","B",8);
//        $this->setXy($colu[0], 35);
//        $this->Cell(10,5,"Producto",0,0,"L");
//        $this->SetX($colu[1]);
//        $this->Cell(15,5,utf8_decode("Unidad"),0,0,"C");
//        $this->SetX($colu[2]);
//        $this->Cell(15,5,"Cantidad",0,0,"R");
//        $this->setX($colu[3]);
//        $this->Cell(15,5,"Control",0,0,"R");
//        $this->SetX($colu[4]);
//        $this->Cell(15,5,utf8_decode("Diferencia"),0,0,"R");
//        $this->setX($colu[5]);
//        $this->Cell(20,5,"Precio",0,0,"R");
//        $this->SetX($colu[6]);
//        $this->Cell(20,5,utf8_decode("Total"),0,1,"R");        



    }
//
    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;
        global $carteltarea;
        global $adm;
        global $direccion;

        global $a_id;
        global $d_articulo;
        global $d_cantidad;
        global $d_unidad;
        global $c_cantidad;
        global $d_precio;
        global $c_cantidad;
        global $c_temperatura;
        global $c_articulo;
        global $c_unidad;
        global $totalkilos;
        global $faena;
        global $cfg;
        global  $copiasimp;
        
        global $colu;
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
            $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
            //$this->Image("images/logomaral.png",5,5,40,20);

            $this->fact_dev( utf8_decode($carteltarea),0,125);
        //$pdf->temporaire( $cen->getNombre() );
            $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        //$pdf->addClient($cli->getId());
            $this->addPageNumber($this->PageNo());
    //        $this->Titulo("LISTADO DE PRODUCTOS", 0);
            $r1=5;
            $r2=205;
            $y1=6;
            $y2=35;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');  
            $this->SetXY(5,5);
            $this->SetFont("Arial","B",14);
            $this->Cell(200,10,$copia,0,1,"C");
    //        $this->line(5,$this->GetY(),205,$this->GetY());
            $r1=5;
            $r2=130;
            $y1=15;
            $y2=35;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
            $this->SetFont("Arial","",10);
            $this->setXY(5,17);
            $this->Cell(10,5,"Proveedor",0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Dirección"),0,1,"L");
            $this->SetX(5);
            $this->Cell(10,5,"Patente",0,1,"L");
            $this->SetFont("Arial","B",10); 
            $this->setXY(25,17);
            $this->Cell(10,5,utf8_decode($adm->getProveedor()),0,1,"L");
            $this->SetX(25);         
            $this->Cell(10,5,$direccion,0,1,"L");        
            $this->SetX(25);
            $this->Cell(10,5,$adm->getPatente(),0,1,"L");
            $r1=5;
            $r2=205;
            $y1=35;
            $y2=290;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
            $this->Ln(10);
            $this->SetFont("Arial","B",8);
            $this->setXy($colu[0], 35);
            $this->Cell(10,5,"Producto",0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(15,5,utf8_decode("Unidad"),0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(15,5,"Cantidad",0,0,"R");
            $this->setX($colu[3]);
            $this->Cell(15,5,"Control",0,0,"R");
            $this->SetX($colu[4]);
            $this->Cell(15,5,utf8_decode("Diferencia"),0,0,"R");
            $this->setX($colu[5]);
            $this->Cell(20,5,"Precio",0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,utf8_decode("Total"),0,1,"R");        
            
        $total=0;
        $this->SetFont('Arial','',8);
     
        for($i=0;$i<count($d_articulo);$i++) {
            $this->setX($colu[0]);
            if($faena)
                $this->Cell(10,5,"FAENA",0,0,"L");
            else
                $this->Cell(10,5,$d_articulo[$i],0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(15,5,$d_unidad[$i],0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(15,5,$d_cantidad[$i],0,0,"R");
            if(!$faena) {
                if($c_cantidad[$i]!=-1) {
                    $this->setX($colu[3]);
                    $this->Cell(15,5,$c_cantidad[$i],0,0,"R");
                    $this->SetX($colu[4]);
                    $this->Cell(15,5,$d_cantidad[$i]-$c_cantidad[$i],0,0,"R");
                } else {
                    $this->SetX($colu[3]);
                    $this->Cell(15,5,"",0,0,"R");
                    $this->setX($colu[4]);
                    $this->Cell(15,5,"",0,0,"R");

                }
            } else {
                $this->SetX($colu[3]);
                $this->Cell(15,5,"",0,0,"R");
                $this->setX($colu[4]);
                $this->Cell(15,5,"",0,0,"R");
                
            }
            $this->setX($colu[5]);
            $this->Cell(20,5,$d_precio[$i],0,0,"R");
            if(!$faena) {
                if($c_cantidad[$i]!=-1) { 
                    $this->SetX($colu[6]);
                    $this->Cell(20,5,$c_cantidad[$i]*$d_precio[$i],0,1,"R");
                    $total+=$c_cantidad[$i]*$d_precio[$i];
                } else {
                    $this->SetX($colu[6]);
                    $this->Cell(20,5,$d_cantidad[$i]*$d_precio[$i],0,1,"R");                    
                    $total+=$d_cantidad[$i]*$d_precio[$i];
                }
            } else {
                $this->SetX($colu[6]);
                $this->Cell(20,5,$d_cantidad[$i]*$d_precio[$i],0,1,"R");                    
                $total+=$d_cantidad[$i]*$d_precio[$i];
            }
            $this->Line(5, $this->GetY(), 205, $this->GetY());
        }
        if($faena) {
            for($i=0;$i<count($c_articulo);$i++) {
                $this->setX($colu[0]);
                $this->Cell(10,5,$c_articulo[$i],0,0,"L");
                $this->SetX($colu[1]);
                $this->Cell(15,5,$c_unidad[$i],0,0,"C");
                $this->SetX($colu[2]);
                $this->Cell(15,5,$c_cantidad[$i],0,0,"R");
                $this->setX($colu[3]);
                $this->Cell(15,5,$c_cantidad[$i],0,1,"R");
                $this->Line(5, $this->GetY(), 205, $this->GetY());
            }
        }    
        $this->SetFont("Arial", "B",10);
        $this->SetX($colu[1]);
        $this->Cell(10,5,"TOTAL");
        $this->SetX($colu[2]);
        $this->Cell(15,5,number_format($totalkilos,2),0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,number_format($total,2),0,0,"R"); 
        }        
    }
}
