<?php
/*
 * Creado el 25/03/2020 18:22:40
 * Autor: gus
 * Archivo: iva_compras.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_com_iva extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;


    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel;
        global $emp;
        global $colu;
        global $cuitemp;
        global $tneto;
        global $tiva21;
        global $tiva27;
        global $texe;
        global $tngr;
        global $tiva10;
        global $tret;
        global $triva;
        global $tpiva;
        global $tpiibb;
        global $timi;
        global $numerolistado;
        global $cfg;
        global $tiva;
        global $tiva17;
        //echo $numerolistado;
        //$cartel="RENDICIÓN DE CAJA";
        $this->SetFont("Arial","B",12);
        $this->SetXY(5,5);
        $this->Cell(10,5,$cartel,0,1);
        $this->SetFont("Arial","BI",12);
        $this->SetX(5);
        $this->Cell(100,5, $cfg->getFiscalnombre(),0,0);
        $this->SetFont("Arial","",10);
        $this->SetX(275);
        $pag=$this->PageNo();
        $this->Cell(10,5,$pag,0,1);
        $this->SetX(5);
        $this->SetFont("Arial","",10);
        $this->Cell(100,5,$cfg->getFiscaldireccion()." ".$cfg->getFiscalciudad(),0,1);
        $this->SetX(5);
        $this->Cell(100,5,"C.U.I.T: ".$cfg->getFiscalcuit(),0,1);
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->SetFont("Arial","B",8);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(10,5,"Comprob.",0,0,"L");
        $this->SetX($colu[2]);
        $this->Cell(10,5,utf8_decode("Razón Social"),0,0,"L");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"CUIT",0,0,"L");
        $this->SetX($colu[4]);
        $this->Cell(5,5,"C.I.",0,0,"C");
        $this->SetX($colu[5]);
        $this->Cell(20,5,"Neto Gravado",0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,"IVA",0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(20,5,"Exentos",0,0,"R");        
        $this->SetX($colu[8]);
        $this->Cell(20,5,"Int/No Alc.",0,0,"R");
        $this->SetX($colu[9]);
        $this->Cell(20,5,"Retenciones",0,0,"R");
        $this->SetX($colu[10]);
        $this->Cell(20,5,"Percepciones",0,0,"R");
        $this->SetX($colu[11]);
        $this->Cell(20,5,"Total",0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->SetFont('Arial','',6);
        $this->SetX($colu[2]);
        $this->Cell(100,5,"Transporte",0,0);
        $this->SetX($colu[5]);
        $this->Cell(20,5,number_format($tneto,2),0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,number_format($tiva,2),0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(20,5,number_format($texe),0,0,"R");
        $this->SetX($colu[8]);
        $this->Cell(20,5,number_format($tngr+$timi,2),0,0,"R");        
        $this->SetX($colu[9]);
        $this->Cell(20,5,number_format($triva,2),0,0,"R");
        $this->SetX($colu[10]);
        $this->Cell(20,5,number_format($tpiibb+$tpiva,2),0,0,"R");
        $this->SetX($colu[11]);
        $this->Cell(20,5,number_format($tneto+$tiva+$texe+$tngr+$tpiva+$tpiibb+$triva+$tret,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        
        
    }



    function addDetalle() {
        global $colu;
        global $a_fec;
        global $a_com;
        global $a_let;
        global $a_pto;
        global $a_num;
        global $a_prv;
        global $a_cuit;
        global $a_civa;
        global $a_neto10;
        global $a_neto21;
        global $a_neto27;
        global $a_neto17;
        global $a_iva10;
        global $a_iva21;
        global $a_iva27;
        global $a_iva17;
        global $a_diva;
        global $a_dimp;
        global $a_exe;
        global $a_ngr;
        global $a_pri;
        global $a_rti;
        global $a_prb;
        
        global $tneto;
        global $tiva;
        global $tiva21;
        global $tiva27;
        global $texe;
        global $tngr;
        global $tiva10;
        global $triva;
        global $tpiva;
        global $tpiibb;
        global $timi;
        global $tiva17;
        global $tret;
        
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        //$this->SetY(40);
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_num);$i++) {
            if($a_com[$i]=="FC" or $a_com[$i]=="ND") {
                $tneto+=$a_neto10[$i]+$a_neto21[$i]+$a_neto27[$i]+$a_neto17[$i];
                $tiva+=$a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i]+$a_iva17[$i];
                $tiva10+=$a_iva10[$i];
                $tiva21+=$a_iva21[$i];
                $tiva27+=$a_iva27[$i];
                $texe+=$a_exe[$i];
                $tngr+=$a_ngr[$i];
                $triva+=$a_rti[$i];
                $tpiva+=$a_pri[$i];
                $tpiibb+=$a_prb[$i];
                $signo="";
            } else {
                $tr=$a_rti[$i]+$a_pri[$i]+$a_prb[$i];
                $tn=$a_neto10[$i]+$a_neto21[$i]+$a_neto27[$i]+$a_neto17[$i];
                $ti=$a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i]+$a_iva17[$i];
                $tneto-=$tn;
                $tiva-=$ti;
                $tiva10-=$a_iva10[$i];
                $tiva21-=$a_iva21[$i];
                $tiva21-=$a_iva27[$i];
                $tiva17-=$a_iva17[$i];
                $texe-=$a_exe[$i];
                $tngr-=$a_ngr[$i];
                $triva-=$a_rti[$i];
                $tpiva-=$a_pri[$i];
                $tpiibb-=$a_prb[$i];
                $signo="-";
                
            }
            $this->SetX($colu[0]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(100,5, $a_com[$i]."-".$a_let[$i]."-".substr("0000",0,4-strlen($a_pto[$i])).$a_pto[$i]."-".substr("00000000",0,8-strlen($a_num[$i])).$a_num[$i],0,0);
            $this->SetX($colu[2]);
            $this->Cell(80,5,substr(utf8_decode($a_prv[$i]),0,34),0,0);
            $this->SetX($colu[3]);
            $this->Cell(80,5,$a_cuit[$i],0,0);
            $this->SetX($colu[4]);
            $this->Cell(5,5,$a_civa[$i],0,0,"C");
            $this->SetX($colu[5]);
            $this->Cell(20,5,$signo.number_format($a_neto10[$i]+$a_neto21[$i]+$a_neto27[$i]+$a_neto17[$i],2),0,0,"R");
            //$this->Cell(10,5,number_format($netcf10+$netcf21+$netri10+$netri21,2),0,0,"R");
            $this->SetX($colu[6]);
            $this->Cell(20,5,$signo.number_format($a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i]+$a_iva17[$i],2),0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(20,5,$signo.number_format($a_exe[$i],2),0,0,"R");
            $this->SetX($colu[8]);
            $this->Cell(20,5,$signo.number_format($a_ngr[$i],2),0,0,"R");            
            //$this->Cell(10,5,number_format($ivacf10+$ivacf21+$ivari10+$ivari21,2),0,0,"R");
            $this->SetX($colu[9]);
            $this->Cell(20,5,$signo.number_format($a_rti[$i],2),0,0,"R");
            $this->SetX($colu[10]);
            $this->Cell(20,5,$signo.number_format($a_pri[$i]+$a_prb[$i],2),0,0,"R");
            $this->SetX($colu[11]);
            $this->Cell(20,5,$signo.number_format($a_neto10[$i]+$a_neto21[$i]+$a_iva21[$i]+$a_neto27[$i]+$a_iva10[$i]+$a_iva27[$i]+$a_exe[$i]+$a_ngr[$i]+$a_rti[$i]+$a_prb[$i]+$a_pri[$i]+$a_iva17[$i]+$a_neto17[$i],2),0,1,"R");
            //$this->Cell(10,5,number_format($netcf10+$netcf21+$netri10+$netri21+$ivacf10+$ivacf21+$ivari10+$ivari21,2),0,1,"R");
            $this->line(5,$this->GetY(),295,$this->GetY());
            
        }
        $this->SetX($colu[1]);
        $this->Cell(100,5,"TOTAL",0,0);
        $this->SetX($colu[5]);
        $this->Cell(20,5,number_format($tneto,2),0,0,"R");
        $this->SetX($colu[6]);
        $this->Cell(20,5,number_format($tiva,2),0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(20,5,number_format($texe),0,0,"R");
        $this->SetX($colu[8]);
        $this->Cell(20,5,number_format($tngr+$timi,2),0,0,"R");        
        $this->SetX($colu[9]);
        $this->Cell(20,5,number_format($triva,2),0,0,"R");
        $this->SetX($colu[10]);
        $this->Cell(20,5,number_format($tpiibb+$tpiva,2),0,0,"R");
        $this->SetX($colu[11]);
        $this->Cell(20,5,number_format($tneto+$tiva+$texe+$tngr+$tpiva+$tpiibb+$triva,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->SetFillColor(200,200,200);
        $this->ln(3);
        $this->SetX($colu[0]);
        $this->Cell(275,5,"Detalle de percepciones sufridas por el impuesto",0,1,"L", true);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"Impuesto al valor agregado",0,0);
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format($tpiva,2),0,1,"R");
        $this->SetX($colu[0]);
        $this->Cell(10,5,"Impuesto al los ingresos brutos",0,0);
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format($tpiibb,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->SetX($colu[0]);
        $this->Cell(10,5,"TOTALES",0,0);
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format($tpiibb+$tpiva,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        
        $this->ln(3);
        $this->SetX($colu[0]);
        $this->Cell(275,5,"Detalle de IVA por alicuotas",0,1,"L", true);
        if($tiva10>0) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,"10.5000%",0,0);
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format($tiva10,2),0,1,"R");
        }
        if($tiva21>0) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,"21.0000%",0,0);
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format($tiva21,2),0,1,"R");
        }
        if($tiva27>0) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,"27.0000%",0,0);
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format($tiva27,2),0,1,"R");
        }
        if($tiva17>0) {
            $this->SetX($colu[0]);
            $this->Cell(10,5,"17.3350%",0,0);
            $this->SetX($colu[3]);
            $this->Cell(20,5,number_format($tiva17,2),0,1,"R");
        }
        $this->SetX($colu[0]);
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->Cell(10,5,"TOTALES",0,0);
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format($tiva10+$tiva21+$tiva27+$tiva17,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        
    }
}
?>