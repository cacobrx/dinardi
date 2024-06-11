<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_fis extends pdf_function {
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
        $this->TituloRec("Comprobantes Fiscales");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Cliente",0,0,"L");   
        $this->setX($colu[3]);
        $this->Cell(20,5,"Comprobante",0,0,"C");            
        $this->setX($colu[4]);
        $this->Cell(10,5,"Total",0,1,"R");        



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_cli;       
        global $a_let;
        global $a_pto;
        global $a_nro;    
        global $doc;
        global $a_com;
        global $a_tot;
        global $d_id;
        global $d_det;
        global $d_art;
        global $d_can;
        global $d_pre;
        global $d_imp;
        global $colu;
        global $colu2;
        global $detallefis;     

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            switch ($a_com[$i]) {
                case "F":
                    $doc="FC";
                    break;
                case "C":
                    $doc="NC";
                    break;
                case "D":
                    $doc="ND";
                    break;
                case "R":
                    $doc="RC";
                    break;                
            }            
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_cli[$i],0,0,"L"); 
            $this->SetX($colu[3]);
            $this->Cell(20,5,$a_com[$i]."-".$a_let[$i]."-".$a_pto[$i]."-".$a_nro[$i],0,0,"L");             
            $this->SetX($colu[4]);
            $this->Cell(20,5,number_format($a_tot[$i],2),0,1,"L");
            if($detallefis==1) {                                       
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"ID",0,0,"C");
            $this->SetX($colu2[1]);
            $this->Cell(15,5,"Detalle",0,0,"L");
            $this->SetX($colu2[2]);
            $this->Cell(15,5,"Cant.",0,0,"C");
            $this->SetX($colu2[3]);
            $this->Cell(20,5,"Precio",0,0,"R");   
            $this->SetX($colu2[4]);
            $this->Cell(20,5,"Importe",0,1,"R");
            $this->SetFont("Arial","",8);
            $ssql="select * from adm_fis_det where idfis=".$a_id[$i]; 
//            echo $ssql;
            $adm=new adm_fis_det_2($ssql);
            $d_id=$adm->getId();
            $d_det=$adm->getDetalle();
            $d_art=$adm->getArticulo();                       
            $d_can=$adm->getCantidad();
            $d_pre=$adm->getPrecio();            
            $d_imp=$adm->getTotal();
            for($d=0;$d<count($d_id);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,$d_id[$d],0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(15,5,utf8_decode($d_art[$d]." ".$d_det[$d]),0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(15,5,$d_can[$d],0,0,"C");
                $this->SetX($colu2[3]);
                $this->Cell(20,5,$d_pre[$d],0,0,"R");
                $this->SetX($colu2[4]);
                $this->Cell(20,5, number_format($d_imp[$d],2),0,1,"R");

                
            }                                                                              
            
        }            
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}   