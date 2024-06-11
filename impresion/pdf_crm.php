<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_crm extends pdf_function {
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
        $this->TituloRec("CONTROL DE FAENAS");
        $r1=5;
        $r2=290;
        $y1=35;
        $y2=205;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Remito",0,0,"L");  
        $this->setX($colu[3]);
        $this->Cell(10,5,"Cantidad",0,0,"R");          
        $this->setX($colu[4]);
        $this->Cell(10,5,"H.Inico",0,0,"C");           
        $this->setX($colu[5]);
        $this->Cell(10,5,"H.Fin",0,0,"C");   
        $this->setX($colu[6]);
        $this->Cell(10,5,"Responsable",0,0,"L");        
        $this->setX($colu[7]);
        $this->Cell(20,5,"Total Remito",0,0,"R");   
        $this->setX($colu[8]);
        $this->Cell(20,5,"Total Faena",0,0,"R");   
        $this->setX($colu[9]);
        $this->Cell(20,5,"Diferencia",0,1,"R");   



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_hor1;
        global $a_hor2;
        global $a_des;
        global $a_ope;
        global $d_can;
        global $d_art;
        global $d_tem;
        global $d_pes;
        global $d_obs;
        global $colu;
        global $colu2;
        global $f_tot;
        global $a_trem;
        global $detallecrm;    
//        print_r($d_can);
        $tf=0;
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $tf+=array_sum($f_tot[$i]);
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_des[$i],0,0,"L"); 
            $this->SetX($colu[3]);
            $this->Cell(10,5,array_sum($d_can[$i]),0,0,"R");             
            $this->SetX($colu[4]);
            $this->Cell(10,5,$a_hor1[$i],0,0,"L"); 
            $this->SetX($colu[5]);
            $this->Cell(10,5,$a_hor2[$i],0,0,"L");             
            $this->SetX($colu[6]);
            $this->Cell(20,5,$a_ope[$i],0,0,"L");
            $this->SetX($colu[7]);
            $this->Cell(20,5,number_format($a_trem[$i],2),0,0,"R");
            $this->SetX($colu[8]);
            $this->Cell(20,5,number_format(array_sum($f_tot[$i]),2),0,0,"R");
            $this->SetX($colu[9]);
            $this->Cell(20,5,number_format($a_trem[$i]-array_sum($f_tot[$i]),2),0,1,"R");
            if($detallecrm==1) {                                       
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"Producto",0,0,"L");
            $this->SetX($colu2[1]);
            $this->Cell(20,5,"Cantidad",0,0,"C");
            $this->SetX($colu2[2]);
            $this->Cell(20,5,"Temp.",0,0,"R");   
            $this->SetX($colu2[3]);
            $this->Cell(10,5,"Observaciones",0,1,"L");
            $this->SetFont("Arial","",8);
            for($d=0;$d<count($d_art[$i]);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,utf8_decode($d_art[$i][$d]),0,0,"L");
                $this->SetX($colu2[1]);
                $this->Cell(20,5,$d_can[$i][$d],0,0,"C");
                $this->SetX($colu2[2]);
                $this->Cell(20,5,$d_tem[$i][$d],0,0,"R");
                $this->SetX($colu2[3]);
                $this->Cell(20,5,$d_obs[$i][$d],0,1,"L");

                
            }                                                                              
            
        }            
            
        $this->Line(5, $this->GetY(), 290, $this->GetY());

        }
        $this->SetFont("Arial", "B", 8);
        $this->SetX($colu[7]);
        $this->Cell(20,5,number_format(array_sum($a_trem),2),0,0,"R");
        $this->SetX($colu[8]);
        $this->Cell(20,5,number_format($tf,2),0,0,"R");
        $this->SetX($colu[9]);
        $this->Cell(20,5,number_format(array_sum($a_trem)-$tf,2),0,1,"R");

    }
}   