<?php
/*
 * creado el 20 may. 2021 15:45:57
 * Usuario: gus
 * Archivo: eco_mensual
 */

require_once 'pdf_function.php';

class eco_mensual extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;
    
    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $anoeco;
        global $meseco;
        $this->SetFont("Arial","",10);
        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        $this->addPageNumber($this->PageNo());
        $this->TituloRec(utf8_decode("Cuenta Ecómica Mensual $meseco / $anoeco"));
        $r1=5;
        $r2=205;
        $y1=60;
        $y2=295;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXY($colu[0],61);
        $this->Cell(10,5,"Cuenta",0,0,"L");
        $this->setX($colu[1]);
        $this->Cell(20,5,"Importe",0,1,"R");           

    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $colu;
        global $ceroseco;
        global $cad;
    

        $this->SetFont('Arial','',8);
        $tots=0;
        $tote=0;
        $cad1=explode("@",$cad);
        for($i=0;$i<count($cad1);$i++) {
            $cad2=explode("|",$cad1[$i]);
//            print_r($cad2);
            $asal=$cad2[1];
            $anom=$cad2[0];
            $aesp=$cad2[2];
//            echo "ll: ".strlen($cad2[2])."<br>";
            if($asal>0 and strlen($aesp)==2) $tote+=$asal;
            if($asal<0 and strlen($aesp)==2) $tots+=$asal;
            
            $this->SetX($colu[0]+strlen($aesp));
            $this->Cell(10,5, utf8_decode($anom),0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(20,5,number_format($asal,2),0,1,"R"); 
            $this->Line(5, $this->GetY(), 205, $this->GetY());
        }
        $this->SetFont("Arial", "B", 8);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"Ingresos",0,0);
        $this->SetX($colu[1]);
        $this->Cell(20,5,number_format($tote,2),0,1,"R"); 
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        $this->SetX($colu[0]);
        $this->Cell(10,5,"Egresos",0,0);
        $this->SetX($colu[1]);
        $this->Cell(20,5,number_format($tots,2),0,1,"R"); 
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        $this->SetX($colu[0]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->SetX($colu[1]);
        $this->Cell(20,5,number_format($tote+$tots,2),0,1,"R"); 
        $this->Line(5, $this->GetY(), 205, $this->GetY());
    }
}
