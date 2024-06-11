<?php
/*
 * Creado el 03/10/2019 13:41:14
 * Autor: gus
 * Archivo: ventas.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_inf_ventas extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        global $nombreemp;
        global $telefonoemp;
        global $fechafin;
        global $fechaini;
        global $colu;
        global $nombre;
        global $informe;
        $this->addCliente( $nombreemp,$telefonoemp);
        $this->SetXY(10, 15);
        $this->Cell(30, 5, $nombre,0,0,"L");        
        $this->fact_dev("Informe de Ventas", 0,125);
        $this->SetXY(10, 25);
        $this->SetFont("Arial","B",8);        
        $this->Cell(30, 5, "Fecha desde ".$dsup->getfechanormalcorta($fechaini)." hasta ".$dsup->getfechanormalcorta($fechafin) );

        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",8);
        $this->SetX($colu[0]);
        $this->Cell(20,5,"Descripcion",0,0,"L");
        if($informe==1) {
            $this->SetX($colu[4]);
            $this->Cell(20,5,"Cantidad",0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(20,5,"Neto",0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,"Iva",0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5,"Total",0,1,"R");
        } else {
            $this->SetX($colu[1]);
            $this->Cell(20,5,"Cantidad",0,0,"R");
            $this->SetX($colu[2]);
            $this->Cell(20,5,"Neto",0,0,"R");
            $this->SetX($colu[3]);
            $this->Cell(20,5,"Iva",0,0,"R");
            $this->SetX($colu[4]);
            $this->Cell(20,5,"Importe",0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(20,5,"%",0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,"Perc.IIBB",0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5,"Total",0,1,"R");
            
        }


    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        
        global $a_art;
        global $a_can;
        global $a_imp;
        global $a_net;
        global $a_iva;
        global $a_per;
        global $a_por;
        global $a_tot;
        global $informe;
        global $colu;

        $this->SetFont('Arial','',8);
        $ttot=0;
        for($i=0;$i<count($a_art);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(20,5, utf8_decode($a_art[$i]),0,0,"L");
            if($informe==1) {
                $this->SetX($colu[4]);
                $this->Cell(20,5,number_format($a_can[$i],2),0,0,"R");
                $this->SetX($colu[5]);
                $this->Cell(20,5,number_format($a_net[$i],2),0,0,"R");
                $this->SetX($colu[6]);
                $this->Cell(20,5,number_format($a_iva[$i],2),0,0,"R");
                $this->SetX($colu[7]);
                $this->Cell(20,5,number_format($a_imp[$i],2),0,1,"R");
            } else {
                $this->SetX($colu[1]);
                $this->Cell(20,5,number_format($a_can[$i],2),0,0,"R");
                $this->SetX($colu[2]);
                $this->Cell(20,5,number_format($a_net[$i],2),0,0,"R");
                $this->SetX($colu[3]);
                $this->Cell(20,5,number_format($a_iva[$i],2),0,0,"R");
                $this->SetX($colu[4]);
                $this->Cell(20,5,number_format($a_imp[$i],2),0,0,"R");
                $this->SetX($colu[5]);
                $this->Cell(20,5,number_format($a_por[$i],2),0,0,"R");
                $this->SetX($colu[6]);
                $this->Cell(20,5,number_format($a_per[$i],2),0,0,"R");
                $this->SetX($colu[7]);
                $this->Cell(20,5,number_format($a_tot[$i],2),0,1,"R");
                
            }
            $this->line(5,$this->GetY(),205,$this->GetY());
        }
        $this->SetFont("Arial", "B", "8");
        $this->SetX($colu[0]);
        $this->Cell(20,5,"TOTAL",0,0,"L");
        if($informe==1) {
            $this->SetX($colu[4]);
            $this->Cell(20,5,number_format(array_sum($a_can),2),0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(20,5,number_format(array_sum($a_net),2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,number_format(array_sum($a_iva),2),0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5,number_format(array_sum($a_imp),2),0,0,"R");
        } else {
            $this->SetX($colu[1]);
            $this->Cell(20,5,number_format(array_sum($a_can),2),0,0,"R");
            $this->SetX($colu[2]);
            $this->Cell(20,5,number_format(array_sum($a_net),2),0,0,"R");
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format(array_sum($a_iva),2),0,0,"R");
            $this->SetX($colu[4]);
            $this->Cell(20,5,number_format(array_sum($a_imp),2),0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(20,5,number_format(array_sum($a_por),2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,number_format(array_sum($a_per),2),0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5,number_format(array_sum($a_tot),2),0,0,"R");
            
        }
    }
}
