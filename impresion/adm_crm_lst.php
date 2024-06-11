<?php

require('pdf_function.php');

/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_crm_lst extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

//        $this->fact_dev( utf8_decode("ARTÍCULOS"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
        $this->TituloRec("CONTROL DE REMITOS");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Remito",0,0,"L");           
        $this->setX($colu[2]);
        $this->Cell(10,5,"H.Inico",0,0,"C");           
        $this->setX($colu[3]);
        $this->Cell(10,5,"H.Fin",0,0,"C");   
        $this->setX($colu[4]);
        $this->Cell(10,5,"Responsable",0,1,"L");        



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;
        global $id;
        global $colu;
        global $fecha;
        global $horainicio;
        global $horafin;
        global $responsable;
        global $remito;        
        global $d_can;
        global $d_art;
        global $d_tem;
        global $d_obs;
        global $detallecrm;
        global $colu2;

        $this->SetFont('Arial','',8);
        $this->SetX($colu[0]);
        $this->Cell(10,5,$dsup->getFechaNormalCorta($fecha),0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,$remito,0,0,"L");             
        $this->SetX($colu[2]);
        $this->Cell(10,5,$horainicio,0,0,"L"); 
        $this->SetX($colu[3]);
        $this->Cell(10,5,$horafin,0,0,"L");             
        $this->SetX($colu[4]);
        $this->Cell(20,5,$responsable,0,1,"L");
        if($detallecrm==1) {                                       
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"Producto",0,0,"L");
            $this->SetX($colu2[1]);
            $this->Cell(15,5,"Cantidad",0,0,"C");
            $this->SetX($colu2[2]);
            $this->Cell(15,5,"Temp.",0,0,"C");   
            $this->SetX($colu2[3]);
            $this->Cell(10,5,"Observaciones",0,1,"L");
            $this->SetFont("Arial","",8);
            $ssql="select * from adm_crm_det where idcrm=".$id; 
//            echo $ssql;
            $adm=new adm_crm_det_2($ssql);
            $d_can=$adm->getCantidad();
            $d_art=$adm->getArticulo();                       
            $d_tem=$adm->getTemperatura();            
            $d_obs=$adm->getObservaciones();
            for($d=0;$d<count($d_art);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,utf8_decode($d_art[$d]),0,0,"L");
                $this->SetX($colu2[1]);
                $this->Cell(10,5,$d_can[$d],0,0,"C");
                $this->SetX($colu2[2]);
                $this->Cell(10,5,$d_tem[$d],0,0,"C");
                $this->SetX($colu2[3]);
                $this->Cell(10,5,$d_obs[$d],0,1,"L");

                
            }                                                                              
            
        }              
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }
 }