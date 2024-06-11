<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_rem extends pdf_function {
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
        $this->TituloRec("REMITOS");
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
        $this->Cell(10,5,"Fecha",0,0,"L");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Proveedor",0,0,"L");     
        $this->setX($colu[3]);
        $this->Cell(20,5,"Total",0,1,"R");        



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_des;
        global $d_tot;
        global $colu;
        global $colu2;
        global $detallerem;
        global $d_des;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_des[$i],0,0,"L");                        
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format(array_sum($d_tot[$i]),2),0,1,"C");
            if($detallerem==1) {
            $this->SetFont("Arial","B",8);
            $ssql="select * from adm_rem_det where idrem=".$a_id[$i];                                                
            $adm=new adm_rem_det_2($ssql);
            $d_art=$adm->getArticulo();
            $d_des=$adm->getDescripcion();             
            $d_pre=$adm->getPrecio();
            $d_tot=$adm->getTotal();
            $d_can=$adm->getCantidad();
            $d_ani=$adm->getAnimales();
            $d_kil=$adm->getKilos();
            $d_uni=$adm->getUnidad();
//            print_r($d_des);
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"Cantidad",0,0,"C");
            $this->SetX($colu2[1]);
            $this->Cell(15,5,"Descripcion",0,0,"L");
            $this->SetX($colu2[2]);
            $this->Cell(15,5,"Animales",0,0,"C");
            $this->SetX($colu2[3]);
            $this->Cell(15,5,"Unidad",0,0,"C");   
            $this->SetX($colu2[4]);
            $this->Cell(15,5,"Kilos",0,0,"C");            
            $this->SetX($colu2[5]);
            $this->Cell(20,5,"Precio",0,0,"R");
            $this->SetX($colu2[6]);
            $this->Cell(20,5,"Total",0,1,"R");
            $this->SetFont("Arial","",8);
            for($d=0;$d<count($d_des);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,$d_can[$d],0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(10,5, utf8_decode($d_art[$d]." ".$d_des[$d]),0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(10,5,$d_ani[$d],0,0,"C");
                $this->SetX($colu2[3]);
                $this->Cell(10,5,$d_uni[$d],0,0,"C");
                $this->SetX($colu2[4]);
                $this->Cell(10,5,$d_kil[$d],0,0,"C");
                $this->SetX($colu2[5]);
                $this->Cell(20,5,number_format($d_pre[$d],2),0,0,"R");
                $this->SetX($colu2[6]);
                $this->Cell(20,5,number_format($d_tot[$d],2),0,1,"R");
                
            }                                                                              
            
        }            
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}