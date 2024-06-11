<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_crem extends pdf_function {
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
        $this->TituloRec("Remitos de Clientes");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",8);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Remito",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[3]);
        $this->Cell(10,5,"Fecha Entrega",0,0,"C");   
        $this->setX($colu[4]);
        $this->Cell(10,5,"Patente",0,0,"L");           
        $this->setX($colu[5]);
        $this->Cell(10,5,"Cliente",0,0,"L");           
        $this->setX($colu[6]);
        $this->Cell(10,5,"Kilos",0,0,"R");           
        $this->setX($colu[7]);
        $this->Cell(20,5,"Total",0,1,"R");        



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_crem.php';
        $dsup=new datesupport();
        global $cartel;
        global $a_id;
        global $a_cli;
        global $a_tot;
        global $a_fec;
        global $a_fece;
        global $d_art;
        global $d_imp;
        global $d_rec;
        global $d_pre;
        global $a_rem;
        global $d_can;
        global $a_pat;
        global $colu;
        global $colu2;
        global $detallecrem;     
        $totk=0;
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$a_rem[$i],0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[3]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fece[$i]),0,0,"C"); 
            $this->SetX($colu[4]);
            $this->Cell(10,5,$a_pat[$i],0,0,"L");             
            $this->SetX($colu[5]);
            $this->Cell(10,5,substr($a_cli[$i],0,35),0,0,"L");             
            $this->SetX($colu[6]);
            $this->Cell(10,5,number_format(array_sum($d_can[$i]),2),0,0,"R");             
            $totk+=array_sum($d_can[$i]);
            //echo array_sum($d_can);
            $this->SetX($colu[7]);
            $this->Cell(20,5, number_format($a_tot[$i],2),0,1,"R");
            if($detallecrem==1) {                                       
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"Cantidad",0,0,"C");
            $this->SetX($colu2[1]);
            $this->Cell(15,5, utf8_decode("Descripción"),0,0,"L");
            $this->SetX($colu2[2]);
            $this->Cell(10,5, utf8_decode("Recipiente"),0,0,"C");            
            $this->SetX($colu2[3]);
            $this->Cell(20,5,"Precio",0,0,"R");
            $this->SetX($colu2[4]);
            $this->Cell(20,5,"Total",0,1,"R");   
            $this->SetFont("Arial","",8);
            $ssql="select * from adm_crem_det where idrem=".$a_id[$i]; 
//            echo $ssql;
            $adm=new adm_crem_det_2($ssql);
            $x_can=$adm->getCantidad();
            $x_art=$adm->getArticulo();  
            $x_rec=$adm->getRecipiente();
            $x_pre=$adm->getPrecio();
            $x_imp=$adm->getImporte();            
            for($d=0;$d<count($x_can);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,$x_can[$d],0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(10,5,$x_art[$d],0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(10,5,$x_rec[$d],0,0,"C");                
                $this->SetX($colu2[3]);
                $this->Cell(20,5, number_format($x_pre[$d],2),0,0,"R");
                $this->SetX($colu2[4]);
                $this->Cell(20,5, number_format($x_imp[$d],2),0,1,"R");

                
            }                                                                              
            
        }            
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }
        $this->SetFont('Arial','B',8);        
        $this->setX($colu[0]);
        $this->Cell(10,5,"TOTAL",0,0,"L");                
        $this->setX($colu[6]);
        $this->Cell(10,5,number_format($totk,2),0,0,"R");           
        $this->setX($colu[7]);
        $this->Cell(20,5,number_format(array_sum($a_tot),2),0,1,"R");         
        

    }
}