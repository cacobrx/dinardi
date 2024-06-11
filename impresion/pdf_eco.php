<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_eco extends pdf_function {
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

        $this->fact_dev( utf8_decode("Cuenta Económica"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
//        $this->TituloRec("PRODUCTOS");
        $r1=5;
        $r2=290;
        $y1=35;
        $y2=205;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Cuenta",0,0,"L");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Totales",0,0,"R");
        $this->setX($colu[2]);
        $this->Cell(10,5,"ENE",0,0,"R");  
        $this->setX($colu[3]);
        $this->Cell(10,5,"FEB",0,0,"R");        
        $this->SetX($colu[4]);        
        $this->Cell(10,5,"MAR",0,0,"R");
        $this->SetX($colu[5]);        
        $this->Cell(10,5,"ABR",0,0,"R");
        $this->SetX($colu[6]);        
        $this->Cell(10,5,"MAY",0,0,"R");
        $this->SetX($colu[7]);        
        $this->Cell(10,5,"JUN",0,0,"R");
        $this->setX($colu[8]);
        $this->Cell(10,5,"JUL",0,0,"R");  
        $this->setX($colu[9]);
        $this->Cell(10,5,"AGO",0,0,"R");        
        $this->SetX($colu[10]);        
        $this->Cell(10,5,"SEP",0,0,"R");
        $this->SetX($colu[11]);        
        $this->Cell(10,5,"OCT",0,0,"R");
        $this->SetX($colu[12]);        
        $this->Cell(10,5,"NOV",0,0,"R");
        $this->SetX($colu[13]);        
        $this->Cell(10,5,"DIC",0,1,"R");



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $r1;
   
        global $ttotal;
        global $colu;       

        $this->SetFont('Arial','',8);
        while($reg1=mysqli_fetch_object($r1)) {  
            $this->SetX($colu[1]);
            $this->Cell(10,5, number_format($reg1->total,0),0,0,"R");
            $this->SetX($colu[2]);                                                                       
            $this->cell(10,5,number_format($reg1->total01,0),0,0,"R");                               
            $this->SetX($colu[3]);
            $this->Cell(10,5, number_format($reg1->total02,0),0,0,"R");
            $this->SetX($colu[4]);                                                                       
            $this->cell(10,5,number_format($reg1->total03,0),0,0,"R");                               
            $this->SetX($colu[5]);
            $this->Cell(10,5, number_format($reg1->total04,0),0,0,"R");
            $this->SetX($colu[6]);                                                                       
            $this->cell(10,5,number_format($reg1->total05,0),0,0,"R");                               
            $this->SetX($colu[7]);
            $this->Cell(10,5, number_format($reg1->total06,0),0,0,"R");
            $this->SetX($colu[8]);                                                                       
            $this->cell(10,5,number_format($reg1->total07,0),0,0,"R");                               
            $this->SetX($colu[9]);
            $this->Cell(10,5, number_format($reg1->total08,0),0,0,"R");
            $this->SetX($colu[10]);                                                                       
            $this->cell(10,5,number_format($reg1->total09,0),0,0,"R");                               
            $this->SetX($colu[11]);                                                                       
            $this->cell(10,5,number_format($reg1->total10,0),0,0,"R");                               
            $this->SetX($colu[12]);                                                                       
            $this->cell(10,5,number_format($reg1->total11,0),0,0,"R");                               
            $this->SetX($colu[13]);                                                                       
            $this->cell(10,5,number_format($reg1->total12,0),0,0,"C");                               
            $this->SetX($colu[0]);
            $this->MultiCell(30,5, utf8_decode($reg1->descripcion),0,"L");
          
            $this->Line(5, $this->GetY(), 290, $this->GetY());
            $ttotal[0]+=$reg1->total01;
            $ttotal[1]+=$reg1->total02;
            $ttotal[2]+=$reg1->total03;
            $ttotal[3]+=$reg1->total04;
            $ttotal[4]+=$reg1->total05;
            $ttotal[5]+=$reg1->total06;
            $ttotal[6]+=$reg1->total07;
            $ttotal[7]+=$reg1->total08;
            $ttotal[8]+=$reg1->total09;
            $ttotal[9]+=$reg1->total10;
            $ttotal[10]+=$reg1->total11;
            $ttotal[11]+=$reg1->total12;
        }
        $this->SetFont('Arial','B',8);        
        $this->setX($colu[0]);
        $this->Cell(10,5,"TOTAL",0,0,"L");                         
        $this->setX($colu[1]);
        $this->Cell(10,5,number_format(array_sum($ttotal),0),0,0,"R"); 
        $this->setX($colu[2]);
        $this->Cell(10,5,number_format($ttotal[0],0),0,0,"R"); 
        $this->setX($colu[3]);
        $this->Cell(10,5,number_format($ttotal[1],0),0,0,"R"); 
        $this->setX($colu[4]);
        $this->Cell(10,5,number_format($ttotal[2],0),0,0,"R"); 
        $this->setX($colu[5]);
        $this->Cell(10,5,number_format($ttotal[3],0),0,0,"R"); 
        $this->setX($colu[6]);
        $this->Cell(10,5,number_format($ttotal[4],0),0,0,"R"); 
        $this->setX($colu[7]);
        $this->Cell(10,5,number_format($ttotal[5],0),0,0,"R"); 
        $this->setX($colu[8]);
        $this->Cell(10,5,number_format($ttotal[6],0),0,0,"R"); 
        $this->setX($colu[9]);
        $this->Cell(10,5,number_format($ttotal[7],0),0,0,"R"); 
        $this->setX($colu[10]);
        $this->Cell(10,5,number_format($ttotal[8],0),0,0,"R"); 
        $this->setX($colu[11]);
        $this->Cell(10,5,number_format($ttotal[9],0),0,0,"R"); 
        $this->setX($colu[12]);
        $this->Cell(10,5,number_format($ttotal[10],0),0,0,"R"); 
        $this->setX($colu[13]);
        $this->Cell(10,5,number_format($ttotal[11],0),0,1,"R"); 


    }
}