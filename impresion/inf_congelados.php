<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_congelados extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fechaini;
        global $fechafin;
       $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( utf8_decode("Congelados"),0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $this->SetFont("Arial","B",10);
        $this->SetXY(10, 20);
        $this->Cell(50, 5, "Fecha desde ".$dsup->getfechanormalcorta($fechaini)." Hasta".$dsup->getfechanormalcorta($fechafin));
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXY($colu[0],35);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,utf8_decode("Artículo"),0,0,"L");        
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Cajas",0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Kilos",0,1,"C");




    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_art;
        global $a_caj;
        global $a_kil;
        global $a_des4;
        global $a_fec;

        global $colu;
        $totalkilos=0;
        $totalcajas=0;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_fec);$i++) {
            $this->SetFont('Arial','',8);
            if(count($a_art[$i])>0) { 
                $this->SetX($colu[0]);
                $this->SetFont('Arial','B',8);
                $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,1,"C");            
                $this->SetFont('Arial','',8);
                for($d=0;$d<count($a_art[$i]);$d++) {            
                    $this->SetX($colu[1]);
                    $this->Cell(10,5,$a_art[$i][$d],0,0,"L");            
                    $this->SetX($colu[2]);
                    $this->Cell(20,5, $a_caj[$i][$d],0,0,"C");
                    $this->SetX($colu[3]);
                    $this->Cell(20,5,$a_kil[$i][$d],0,1,"C"); 
                    $this->Line(5, $this->GetY(), 205, $this->GetY());                   
                }
                $this->SetFont("Arial","B",8);
                $this->setX($colu[0]);
                $this->Cell(10,5,utf8_decode("Total del Día"),0,0,"L");
                $this->setX($colu[2]);
                $this->Cell(20,5, number_format(array_sum($a_caj[$i]),2),0,0,"C"); 
                $this->setX($colu[3]);
                $this->Cell(20,5, number_format(array_sum($a_kil[$i]),2),0,1,"C"); 
                $this->Line(5, $this->GetY(), 205, $this->GetY());                    
                $totalkilos+=array_sum($a_kil[$i]);
                $totalcajas+=array_sum($a_caj[$i]);
            }
        }
        $this->SetX($colu[0]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->setX($colu[2]);
        $this->Cell(20,5, number_format($totalcajas,2),0,0,"C"); 
        $this->setX($colu[3]);
        $this->Cell(20,5, number_format($totalkilos,2),0,1,"C"); 
        $this->Line(5, $this->GetY(), 205, $this->GetY());                    
    }  

}



class pdf_congelados_fec extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fechaini;
        global $fechafin;
       $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( utf8_decode("Congelados"),0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $this->SetFont("Arial","B",10);
        $this->SetXY(10, 20);
        $this->Cell(50, 5, "Fecha desde ".$dsup->getfechanormalcorta($fechaini)." Hasta ".$dsup->getfechanormalcorta($fechafin));
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXY($colu[0],35);
        $this->Cell(10,5,utf8_decode("Artículo"),0,0,"L");        
        $this->SetX($colu[1]);
        $this->Cell(20,5,"Cajas",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Kilos",0,1,"C");




    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_art;
        global $a_caj;
        global $a_kil;
        global $a_des4;

        global $colu;
        $totalkilos=0;
        $totalcajas=0;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_art);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5, utf8_decode($a_art[$i]),0,0,"L");            
            $this->SetX($colu[1]);
            $this->Cell(20,5, $a_caj[$i],0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(20,5,$a_kil[$i],0,1,"C"); 
            $this->Line(5, $this->GetY(), 205, $this->GetY());                   
        }
        $this->SetFont('Arial','B',8);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->setX($colu[1]);
        $this->Cell(20,5, number_format(array_sum($a_caj),2),0,0,"C"); 
        $this->setX($colu[2]);
        $this->Cell(20,5, number_format(array_sum($a_kil),2),0,1,"C"); 
        $this->Line(5, $this->GetY(), 205, $this->GetY());                    
    }  

}

