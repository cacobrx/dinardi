<?php
/*
 * creado el 18 ago. 2023 18:29:47
 * Usuario: gus
 * Archivo: paisproductos
 */

require_once 'pdf_function.php';

class paisproductos extends pdf_function {
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
        global $fechafininf;
        global $fechainiinf;
        global $pais;
        global $cadenaart;
        global $colu;
        $this->addCliente( "DINARDI MENUDENCIAS S.A.",$telefonoemp);
        $this->fact_dev(utf8_decode("Productos / País $pais"), 0,125);
        $this->SetXY(5, 15);
        $this->SetFont("Arial","B",9);        
        $this->MultiCell(150, 5, "Fecha desde ".$dsup->getfechanormalcorta($fechainiinf)." hasta ".$dsup->getfechanormalcorta($fechafininf)." - Productos: $cadenaart");
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
        $this->Cell(20,5,"Fecha",0,0,"L");
        $this->SetX($colu[1]);
        $this->Cell(20,5,"Certificado",0,0,"R");
        $this->SetX($colu[2]);
        $this->Cell(20,5,"Articulos",0,0,"R");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Pais",0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Kilos",0,1,"R");


    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        
        global $a_idart;
        global $a_art;
        global $a_pai;
        global $a_fec;
        global $a_cer;
        global $a_kil;
        global $colu;

        $this->SetFont('Arial','',8);
        $ttot=0;
        for($i=0;$i<count($a_art);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(20,5,$a_cer[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(20,5, utf8_decode($a_art[$i]),0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(20,5,$a_pai[$i],0,0,"L");
            $this->SetX($colu[4]);
            $this->Cell(20,5,number_format($a_kil[$i],2),0,1,"R");
            $this->line(5,$this->GetY(),205,$this->GetY());
        }
        $this->SetFont("Arial", "B", "8");
        $this->SetX($colu[0]);
        $this->Cell(20,5,"TOTAL",0,0,"L");
        $this->SetX($colu[4]);
        $this->Cell(20,5,number_format(array_sum($a_kil),2),0,0,"R");
    }
}
