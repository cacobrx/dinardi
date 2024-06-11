<?php
/*
 * Creado el 07/08/2019 22:11:00
 * Autor: gus
 * Archivo: prv_saldos.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class prv_saldos extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $fechafin;
        global $nombreemp;
        global $telelofonoemp;
        global $colu;
        global $fechafin;
        $cartel="Cuenta Corriente al ".$dsup->getFechaNormalCorta($fechafin);
        $this->addCliente( $nombreemp,$telelofonoemp);
        $this->fact_dev("SALDO DE PROVEEDORES");
        //$pdf->temporaire( $cen->getNombre() );
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        //$pdf->addClient($cli->getId());
        $this->addPageNumber($this->PageNo());
        $this->SetX(10);
        $this->SetFont("Arial","B",12);

        $cartel="Saldos al ".$dsup->getFechaNormalCorta($fechafin);
        $this->SetXY(10,25);
        $this->SetFont('Arial','B',12);
        $this->Cell(50,5,$cartel,0,1);


        $r1=5;
        $r2=205;
        $y1=35;
        $y2=275;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->SetFont('Arial','B',10);
        $this->SetY(35);
        
        $this->SetX($colu[0]);
        $this->Cell(10,5,"Proveedor",0,0);
        $this->SetX($colu[1]);
        $this->Cell(30,5,"Compras",0,0,"R");
        $this->SetX($colu[2]);
        $this->Cell(30,5,"Pagos",0,0,"R");
        $this->SetX($colu[3]);
        $this->Cell(30,5,"Saldo",0,1,"R");



    }


    function addDetalle() {
        require_once 'clases/datesupport.php';
        global $i_dir;
        global $i_prv;
        global $i_fac;
        global $i_rec;
        global $i_sal;
        global $colu;
        $dsup=new datesupport();
        global $totaldebe;
        global $totalhaber;
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($i_prv);$i++) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,$i_prv[$i],0);
            $this->SetX($colu[1]);
            $this->Cell(30,5,number_format($i_fac[$i],2),0,0,"R");
            $this->SetX($colu[2]);
            $this->Cell(30,5,number_format($i_rec[$i],2),0,0,"R");
            $this->SetX($colu[3]);
            $this->Cell(30,5,number_format($i_sal[$i],2),0,1,"R");
            $this->line(5,$this->GetY(),205,$this->GetY());
            
        }
        $this->SetFont('Arial','B',10);
        $this->SetX($colu[0]);
        $this->Cell(20,5,"Saldo Final",0,0);
        $this->SetX($colu[1]);
        $this->Cell(30,5,number_format(array_sum($i_fac),2),0,0,'R');
        $this->SetX($colu[2]);
        $this->Cell(30,5,number_format(array_sum($i_rec),2),0,0,'R');
        $this->SetX($colu[3]);
        $this->Cell(30,5,number_format(array_sum($i_sal),2),0,1,'R');

    }

    function addSaldoFinal($total) {
        $r1=150;
        $r2=200;
        $y1=245;
        $y2=270;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'DF');    
        $this->SetY(250);
        $this->SetX(150);
        $this->SetFont('Arial','B',15);

        $this->Cell(50,5,"Saldo Final",'','',"C");
        $this->Ln(10);
        $this->SetX(150);
        $this->Cell(50,5,"$".number_format($total,2),'','',"C");

    }


}
?>