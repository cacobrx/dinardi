<?php
// * Autor: gus
// * Archivo: pdf_com.php
// * planbsistemas.com.ar
// */

require_once 'pdf_function.php';

class PDF_opg extends pdf_function {
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
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
//        $this->Titulo("LISTADO DE PRODUCTOS", 0);
        $this->TituloRec("Ordenes de Pagos de Proveedores");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->SetX($colu[0]);
        $this->Cell(5,5,"ID",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(5,5,"T",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(15,5,"Proveedor",0,0,"L");    
        $this->SetX($colu[4]);
        $this->Cell(15,5,"Concepto",0,0,"L");
        $this->SetX($colu[5]);
        $this->Cell(20,5,"Importe.",0,1,"R");    

    }  


    function Detalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;

        global    $a_id;
        global    $a_fec;
        global    $a_con;
        global    $a_tip;
        global    $a_imp;
        global    $a_pro;
        global    $colu;
                   
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(5,5,$a_id[$i],0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(5,5,substr($a_tip[$i],0,1),0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[3]);
            $this->Cell(15,5,substr($a_pro[$i],0,30),0,0,"L"); 
            $this->SetX($colu[5]);
            $this->Cell(20,5,number_format($a_imp[$i],2),0,0,"R"); 
            $this->SetX($colu[4]);
            $this->MultiCell(60,5,$a_con[$i],0);            
            
            $this->Line(5, $this->GetY(), 205, $this->getY());


        }

    }
}