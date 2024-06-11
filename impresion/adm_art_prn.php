<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class art extends pdf_function {
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

        $this->fact_dev( utf8_decode("ARTÍCULOS"),0,125);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
        $this->TituloRec("PRODUCTOS");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,utf8_decode("Descripción"),0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5,utf8_decode("Rubro"),0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(10,5,utf8_decode("Tipo Envalaje"),0,0,"L");
        $this->SetX($colu[4]);
        $this->Cell(10,5,utf8_decode("Cantidad"),0,0,"C");
        $this->SetX($colu[5]);
        $this->Cell(10,5,utf8_decode("Envasado"),0,0,"L");
        $this->SetX($colu[6]);
        $this->Cell(20,5,"Precio",0,1,"R");



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_des;
        global $a_pre;
        global $a_rub;
        global $a_tip;
        global $a_env;
        global $a_can;
        global $colu;

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5, utf8_decode($a_des[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(15,5, utf8_decode($a_rub[$i]),0,0,"L");          
            $this->SetX($colu[3]);
            $this->Cell(15,5, utf8_decode($a_tip[$i]),0,0,"C");          
            $this->SetX($colu[4]);
            $this->Cell(10,5, utf8_decode($a_can[$i]),0,0,"R");          
            $this->SetX($colu[5]);
            if($a_env[$i]==1) {
                $this->Cell(15,5, "Si",0,0,"L");    
            } else {
                $this->Cell(15,5, "No",0,0,"L");                    
            }
            $this->SetX($colu[6]);
            $this->Cell(20,5, number_format($a_pre[$i],2),0,1,"R");
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }

    }
}
