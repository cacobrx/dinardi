<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_gas extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
//        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        //$this->Image("images/logomaral.png",5,5,40,20);

        $this->fact_dev( utf8_decode("Gastos"),0,180);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
//        $this->TituloRec("Gastos");
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
        $this->Cell(10,5,"Nro.",0,0,"C");        
        $this->SetX($colu[2]);
        $this->Cell(15,5,utf8_decode("Fecha"),0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(10,5,utf8_decode("Proveedor"),0,0,"L");
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Descriptores",0,0,"L");
        $this->SetX($colu[5]);
        $this->Cell(20,5,utf8_decode("Importe"),0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,"Vencimiento",0,0,"C");
        $this->SetX($colu[7]);
        $this->Cell(20,5,"Pagado",0,1,"C");



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $d_id;
        global $d_des1;
        global $d_des2;
        global $d_des3;
        global $d_des4;
        global $a_pro;
        global $a_imp;
        global $a_fecp;
        global $a_fecv;
        global $a_fec;
        global $a_num;
        global $colu;


        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {       
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$a_num[$i],0,0,"C");            
            $this->SetX($colu[2]);
            $this->Cell(15,5, $dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[3]);
            $this->Cell(15,5,utf8_decode($a_pro[$i]),0,0,"L");          
            $this->SetX($colu[4]);
            for($d=0;$d<count($d_id[$i]);$d++) {
                $this->Cell(20,5, utf8_decode($d_des1[$i][$d]."/ ".$d_des2[$i][$d]."/ ".$d_des3[$i][$d]."/ ".$d_des4[$i][$d]),0,0,"L");
            }                          
            $this->SetX($colu[5]);
            $this->Cell(20,5, number_format($a_imp[$i],2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5, $dsup->getFechaNormalCorta($a_fecv[$i]),0,0,"L");          
            $this->SetX($colu[7]);
            $this->Cell(20,5, $dsup->getFechaNormalCorta($a_fecp[$i]),0,1,"C");
            $this->Line(5, $this->GetY(), 290, $this->GetY());

        }

    }
}
