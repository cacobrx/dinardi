<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_env_lst extends pdf_function {
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
        $this->TituloRec("Elaboracion");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,"Hora Ingreso",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Hora Fin",0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"Empleados",0,1,"L");       



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_cli.php';
        $dsup=new datesupport();
        global $cartel;
        
        global $a_id;
        global $a_fec;
        global $a_hin;
        global $a_heg;
        global $a_emp;
        global $a_prv;
        global $a_art;
        global $a_fin;
        global $a_kgd;
        global $a_kgf;
        global $verdetalleela;
        global $colu2;
        global $colu;
        
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
        $this->SetX($colu[0]);
        $this->Cell(10,5,$dsup->getfechanormalcorta($a_fec[$i]),0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(15,5,$a_hin[$i],0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5,$a_heg[$i],0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(15,5, $a_emp[$i],0,1,"C");
            if($verdetalleela==1) {                                       
            $this->SetFont("Arial","B",8);
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"Fecha",0,0,"C");
            $this->SetX($colu2[1]);
            $this->Cell(15,5, utf8_decode("Proveedor"),0,0,"L");
            $this->SetX($colu2[2]);
            $this->Cell(10,5, utf8_decode("Articulo"),0,0,"C");            
            $this->SetX($colu2[3]);
            $this->Cell(20,5,"Kg Descarte",0,0,"R");
            $this->SetX($colu2[4]);
            $this->Cell(20,5,"Kg Final",0,1,"R");   
            $this->SetFont("Arial","",8);           
            for($d=0;$d<count($a_art);$d++) {
                $this->SetX($colu2[0]);
                $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fin[$i][$d]),0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(10,5,$a_prv[$i][$d],0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(10,5,$a_art[$i][$d],0,0,"C");                
                $this->SetX($colu2[3]);
                $this->Cell(20,5, number_format($a_kgd[$i][$d],2),0,0,"R");
                $this->SetX($colu2[4]);
                $this->Cell(20,5, number_format($a_kgf[$i][$d],2),0,1,"R");
            }
                
            }   
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        }
         $this->Line(5, $this->GetY(), 205, $this->GetY());

    }
    
}