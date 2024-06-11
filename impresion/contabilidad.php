<?php
/*
 * Creado el 12/07/2019 16:18:56
 * Autor: gus
 * Archivo: contabilidad.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_inf_ss extends pdf_function
{
// private variables
var $colonnes;
var $format;
var $angle=0;

function Header() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $nombreemp;
    global $telefonoemp;
    global $empresanom;
    global $fechaini;
    global $fechafin;
    global $colu;
 //   $this->addCliente( $nombreemp,$telefonoemp);
    //$this->Image("images/logomaral.png",5,5,40,20);
    
//    $this->fact_dev( "Sumas Y Saldos",0,100);
//$pdf->temporaire( $cen->getNombre() );
    $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//$pdf->addClient($cli->getId());
    $this->addPageNumber($this->PageNo());
    $this->SetFont("Arial","B",12);
    $this->SetXY(5,10);
    $this->Cell(20,5,$empresanom,0,1);
    $this->SetFont("Arial","",10);
    $this->SetXY(5,20);
    $this->Cell(20,5,"Sumas y Saldos desde ".date("d/m/Y", strtotime($fechaini))." hasta ".date("d/m/Y", strtotime($fechafin)),0,1);
    $r1=5;
    $r2=205;
    $y1=35;
    $y2=290;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
    $this->Ln(10);
    $this->SetFont("Arial","B",10);
    $this->setX($colu[0]);
    $this->Cell(10,5,"Cuentas",0,0,"L");
    $this->SetX($colu[1]);
    $this->Cell(20,5,"Debitos",0,0,"R");
    $this->SetX($colu[2]);
    $this->Cell(20,5,"Creditos",0,0,"R");
    $this->SetX($colu[3]);
    $this->Cell(20,5,"Saldos",0,1,"R");


    
}

function addDetalle() {
    require_once 'clases/datesupport.php';
    $dsup=new datesupport();
    global $cartel;

        global $a_esp;
        global $a_cta;
        global $a_nom;
        global $a_deb;
        global $a_cre;
        global $a_sal;
        global $a_let;
        global $a_esp;
        global $colu;

    $this->SetFont('Arial','',8);
    for($i=0;$i<count($a_esp);$i++) {
        if($a_let[$i]=="letra6")
            $this->SetFont("Arial","",10);
        else
            $this->SetFont("Arial","B",10);
        $this->SetX($colu[0]+$a_esp[$i]);
        $this->Cell(10,5,$a_cta[$i]." ".$a_nom[$i],0,0,"L");
        $this->SetX($colu[1]);
        $this->Cell(20,5,number_format($a_deb[$i],2),0,0,"R");
        $this->SetX($colu[2]);
        $this->Cell(20,5,  number_format($a_cre[$i],2),0,0,"R");
        $this->SetX($colu[3]);
        $this->Cell(20,5, number_format($a_sal[$i],2),0,1,"R");    
        
        $this->Line(5, $this->GetY(), 205, $this->GetY());
        
    }
 
}


}

class PDF_inf_mayor extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreemp;
        global $telefonoemp;
        global $colu;
        global $empresanom;
        global $fechainimay;
        global $fechafinmay;
     //   $this->addCliente( $nombreemp,$telefonoemp);
        //$this->Image("images/logomaral.png",5,5,40,20);

//        $this->fact_dev( "Libro Mayor",0,100);
    //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $this->SetFont("Arial","B",12);
        $this->SetXY(5,10);
        $this->Cell(20,5,$empresanom,0,1);
        $this->SetFont("Arial","",10);
        $this->SetXY(5,20);
        $this->Cell(20,5,"LIBRO MAYOR desde ".date("d/m/Y", strtotime($fechainimay))." hasta ".date("d/m/Y", strtotime($fechafinmay)),0,1);
        
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(15,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,"Asientos",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Descripcion",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Debe",0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Haber",0,0,"R");
        $this->SetX($colu[5]);
        $this->Cell(20,5,"Saldo",0,1,"R");



    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;
        global $a_cod;
        global $a_nom;
        global $a_deb;
        global $a_cre;
        global $a_sal;
        global $m_fec;
        global $m_des;
        global $m_asi;
        global $m_ent;
        global $m_sal;
        global $m_sdo;

        global $colu;

        $this->SetFont('Arial','',8);

        for($i=0;$i<count($a_cod);$i++) {
            $this->SetFont("Arial","B",8);
            $this->SetX($colu[0]);
            $this->Cell(10,5,"Cuenta:",0,0);
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_cod[$i],0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5, $a_nom[$i],0,0,"L");
            $this->SetX($colu[3]);
            $this->Cell(20,5, number_format($a_deb[$i],2),0,0,"R"); 
            $this->SetX($colu[4]);
            $this->Cell(20,5, number_format($a_cre[$i],2),0,0,"R"); 
            $this->SetX($colu[5]);
            $this->Cell(20,5, number_format($a_sal[$i],2),0,1,"R"); 
            for($m=0;$m<count($m_fec[$i]);$m++) {
                $this->SetFont('Arial','',8);
                $this->SetX($colu[0]);
                $this->Cell(15,5,$dsup->getFechaNormalCorta($m_fec[$i][$m]),0,0);
                $this->SetX($colu[1]);
                $this->Cell(10,5,$m_asi[$i][$m],0,0,"C");
                $this->SetX($colu[2]);
                $this->Cell(15,5,$m_des[$i][$m],0,0,"L");
                $this->SetX($colu[3]);
                $this->Cell(20,5,number_format($m_ent[$i][$m],2),0,0,"R");
                $this->SetX($colu[4]);
                $this->Cell(20,5,number_format($m_sal[$i][$m],2),0,0,"R");
                $this->SetX($colu[5]);
                $this->Cell(20,5,number_format($m_sdo[$i][$m],2),0,1,"R");


                $this->Line(5, $this->GetY(), 205, $this->GetY());

            }
        }

    }

}

class PDF_diario extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $nombreemp;
        global $telefonoemp;
        global $colu;
        global $empresanom;
        global $textodiario;
     //   $this->addCliente( $nombreemp,$telefonoemp);
        //$this->Image("images/logomaral.png",5,5,40,20);

//        $this->fact_dev( "Libro Mayor",0,100);
    //$pdf->temporaire( $cen->getNombre() );
//        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
    //$pdf->addClient($cli->getId());
//        $this->addPageNumber($this->PageNo());
        $this->SetFont("Arial","B",12);
        $this->SetXY(5,10);
        $this->Cell(20,5,$empresanom,0,1);
        $this->SetFont("Arial","",10);
        $this->SetX(5);
        $this->Cell(20,5, utf8_decode($textodiario),0,1);
        $this->SetX(5);
        $this->Cell(20,5,"LIBRO DIARIO",0,1);
        
        $this->Ln(5);
        $this->SetFont("Arial","B",8);
        $this->setX($colu[0]);
        $this->Cell(15,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,"Asientos",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(15,5,"Detalle",0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Debe",0,0,"R");
        $this->SetX($colu[4]);
        $this->Cell(20,5,"Haber",0,1,"R");

    }

    function addDetalle() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;
        global $a_fec;
        global $a_det;
        global $a_asi;
        global $a_debe;
        global $a_haber;
        global $d_nombre;
        global $d_codigo;
        global $d_tipo;
        global $d_importe;
        global $d_detalle;
        global $detallemov;

        global $colu;
        global $colud;

        $this->SetFont('Arial','',8);

        for($i=0;$i<count($a_fec);$i++) {
//            $this->SetFont('Arial','',8);
            $this->SetX($colu[0]);
            $this->Cell(20,5,date("d/m/Y", strtotime($a_fec[$i])),0,0);
            $this->SetX($colu[1]);
            $this->Cell(15,5,$a_asi[$i],0,0,"C");
            if($detallemov==0) {
                $this->SetX($colu[3]);
                $this->Cell(20,5, number_format($a_debe[$i],2),0,0,"R"); 
                $this->SetX($colu[4]);
                $this->Cell(20,5, number_format($a_haber[$i],2),0,0,"R"); 
                $this->SetX($colu[2]);
                $this->MultiCell(120,5, utf8_decode($a_det[$i]));
            } else {
                $this->SetX($colu[2]);
                $this->MultiCell(120,5, utf8_decode($a_det[$i]));
            }
            $this->Line(5, $this->GetY(), 205, $this->GetY());
            if($detallemov==1) {
                $this->SetFont('Arial','B',8);
                $this->SetX($colud[0]);
                $this->Cell(20,5,"Codigo",0,0);
                $this->SetX($colud[1]);
                $this->Cell(20,5,"Cuenta",0,0);
                $this->SetX($colud[2]);
                $this->Cell(20,5,"Detalle",0,0);
                $this->SetX($colud[3]);
                $this->Cell(20,5,"Debe",0,0,"R");
                $this->SetX($colud[4]);
                $this->Cell(20,5,"Haber",0,1,"R");
                for($m=0;$m<count($d_codigo[$i]);$m++) {
                    $this->SetFont('Arial','',8);
                    $this->SetX($colud[0]);
                    $this->Cell(20,5,$d_codigo[$i][$m],0,0);
                    $this->SetX($colud[1]);
                    $this->Cell(10,5,$d_nombre[$i][$m],0,0);
                    $this->SetX($colud[2]);
                    $this->Cell(15,5,$d_detalle[$i][$m],0,0);
                    if($d_tipo[$i][$m]==1)
                        $this->SetX($colud[3]);
                    else
                        $this->SetX($colud[4]);
                    $this->Cell(20,5,number_format($d_importe[$i][$m],2),0,1,"R");
//                    $this->Line(5, $this->GetY(), 205, $this->GetY());
                }
                $this->SetFont("Ariel","B",8);
                $this->SetX($colu[3]);
                $this->Cell(20,5, number_format($a_debe[$i],2),0,0,"R"); 
                $this->SetX($colu[4]);
                $this->Cell(20,5, number_format($a_haber[$i],2),0,1,"R"); 
                $this->Line(5, $this->GetY(), 205, $this->GetY());
                
            }
        }

    }

}
