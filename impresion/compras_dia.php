<?php
/*
 * Creado el 15/08/2020 13:13:18
 * Autor: gus
 * Archivo: compras_dia.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class compras_dia extends pdf_function {
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
        global $informe;
        global $colu;
        $this->addCliente( $nombreemp,$telefonoemp);
        $this->fact_dev(utf8_decode("Informe de Compras x Día"), 0,125);
        $this->SetXY(10, 25);
        $this->SetFont("Arial","B",9);        
        $this->Cell(30, 5, "Fecha desde ".$dsup->getfechanormalcorta($fechaini)." hasta ".$dsup->getfechanormalcorta($fechafin) );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        $this->addPageNumber($this->PageNo());
        $r1=5;
        $r2=290;
        $y1=35;
        $y2=205;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",8);
        $this->SetX($colu[0]);
        $this->Cell(20,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(20,5,"Proveedor",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Producto",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Kilos",0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Precio",0,0,"R");
        $this->SetX($colu[5]);
        $this->Cell(20,5,"Neto",0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,"Iva",0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(20,5,"Total",0,1,"R");


    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        
        global $a_art;
        global $a_can;
        global $a_imp;
        global $a_neto;
        global $a_iva;
        global $a_fecha;
        global $a_prov;
        
        global $colu;

        $this->SetFont('Arial','',8);
        $ttot=0;
        for($i=0;$i<count($a_art);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(20,5, $dsup->getFechaNormalCorta($a_fecha[$i]),0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(20,5, utf8_decode($a_prov[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(20,5, utf8_decode($a_art[$i]),0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(20,5,$a_can[$i],0,0,"R");
            $this->SetX($colu[4]);
            if($a_can[$i]>0)
                $this->Cell(20,5,number_format($a_neto[$i]/$a_can[$i],2),0,0,"R");
            $this->SetX($colu[5]);
            $this->Cell(20,5,number_format($a_neto[$i],2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,number_format($a_iva[$i],2),0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5,number_format($a_imp[$i],2),0,1,"R");
            $this->line(5,$this->GetY(),290,$this->GetY());
        }
        $this->SetFont("Arial", "B", "8");
        $this->SetX($colu[0]);
        $this->Cell(20,5,"TOTAL",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format(array_sum($a_can),2),0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,number_format(array_sum($a_neto)/array_sum($a_can),2),0,0,"R");
        $this->SetX($colu[5]);
        $this->Cell(20,5,number_format(array_sum($a_neto),2),0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,number_format(array_sum($a_iva),2),0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(20,5,number_format(array_sum($a_imp),2),0,0,"R");
    }
}
