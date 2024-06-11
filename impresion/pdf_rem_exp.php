<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_rem_exp extends pdf_function {
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
        $this->TituloRec(utf8_decode("Remitos de Expotación"));
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Nro.",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Exportador",0,0,"L");  
        $this->setX($colu[3]);
        $this->Cell(10,5,"Destino",0,0,"L");          
        $this->setX($colu[4]);
        $this->Cell(10,5,"Remitente",0,1,"L");                  


    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_nro;
        global $a_fec;
        global $a_exp;
        global $a_des;
        global $a_rem;        
        global $d_can;
        global $d_des;
        global $d_kgsb;
        global $d_kgsn;
        global $colu;
        global $colu2;      
        global $a_trem;
        global $detalleexp;    
//        print_r($d_can);      
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {           
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_nro[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_exp[$i],0,0,"L");          
            $this->SetX($colu[3]);
            $this->Cell(10,5,$a_des[$i],0,0,"L"); 
            $this->SetX($colu[4]);
            $this->Cell(10,5,$a_rem[$i],0,1,"L");               
            if($detalleexp==1) {                                       
                $this->SetFont("Arial","B",8);
                $this->SetX($colu2[0]);
                $this->Cell(10,5,"Cantidad",0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(20,5,utf8_decode("Descripción"),0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(20,5,"Kgs Brutos",0,0,"C");   
                $this->SetX($colu2[3]);
                $this->Cell(20,5,"Kgs Netos",0,1,"C");
                $this->SetFont("Arial","",8);
                for($d=0;$d<count($d_can[$i]);$d++) {
                    $this->SetX($colu2[0]);
                    $this->Cell(10,5,$d_can[$i][$d],0,0,"C");
                    $this->SetX($colu2[1]);
                    $this->Cell(20,5,$d_des[$i][$d],0,0,"L");
                    $this->SetX($colu2[2]);
                    $this->Cell(20,5,$d_kgsb[$i][$d],0,0,"C");
                    $this->SetX($colu2[3]);
                    $this->Cell(20,5,$d_kgsn[$i][$d],0,1,"C");
                }                                                                                                                                        
                $this->Line(5, $this->GetY(), 205, $this->GetY()); 
                
                $this->SetFont("Arial", "B", 8);
                $this->SetX($colu[0]);
                $this->Cell(20,5,array_sum($d_can[$i]),0,0,"C");
                $this->SetX($colu2[2]);
                $this->Cell(20,5,number_format(array_sum($d_kgsb[$i]),3),0,0,"C");
                $this->SetX($colu2[3]);
                $this->Cell(20,5,number_format(array_sum($d_kgsn[$i]),3),0,1,"C");
            }
            $this->Line(5, $this->GetY(), 205, $this->GetY()); 
        }        
    }
}   