<?

require('pdf_function.php');
class PDF_fis_iva extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;


    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cartel1;
        global $cfg;
        global $colu;
        global $cuitemp;
        global $tneto;
        global $tiva21;
        global $texe;
        global $tngr;
        global $tiva10;
        global $tiva;
        global $tret;
        global $tper;
        global $numerolistado;
        global $cartel;
        //echo $numerolistado;
        //$cartel="RENDICIÓN DE CAJA";
        $this->SetFont("Arial","",10);        
        $this->SetY(10);
//        $pag=$this->PageNo()+$numerolistado;        
//        $this->Cell(10,5,$pag,0,1);
        $this->SetX(220);        
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
        $this->Cell(10,5,"IVA",0,0,"L");
        $this->SetX($colu[4]);
        $this->Cell(5,5,"Doc",0,0,"C");
        $this->SetX($colu[5]);
        $this->Cell(15,5,utf8_decode("Número"),0,0,"C");
        $this->SetX($colu[6]);
        $this->Cell(15,5,"Neto Gravado",0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(15,5,"IVA",0,0,"R");
        $this->SetX($colu[8]);
        $this->Cell(15,5,"Exento",0,0,"R");
        $this->SetX($colu[9]);
        $this->Cell(15,5,"Int./No Alc.",0,0,"R");
        $this->SetX($colu[10]);
        $this->Cell(15,5,"Retenciones",0,0,"R");
        $this->SetX($colu[11]);
        $this->Cell(15,5,"Percepciones",0,0,"R");
        $this->SetX($colu[12]);
        $this->Cell(15,5,"Total",0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->SetFont('Arial','',6);
        $this->SetX($colu[2]);
        $this->Cell(100,5,"Totales",0,0);
        $this->SetX($colu[6]);
        $this->Cell(15,5,number_format($tneto,2),0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(15,5,number_format($tiva,2),0,0,"R");
        $this->SetX($colu[8]);
        $this->Cell(15,5,number_format($texe,2),0,0,"R");
        $this->SetX($colu[9]);
        $this->Cell(15,5,number_format($tngr,2),0,0,"R");
        $this->SetX($colu[10]);
        $this->Cell(15,5,number_format($tret,2),0,0,"R");
        $this->SetX($colu[11]);
        $this->Cell(15,5,number_format($tper,2),0,0,"R");
        $this->SetX($colu[12]);
        $this->Cell(15,5,number_format($tneto+$tiva21+$tiva10+$texe+$tngr+$tret+$tper,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        
        
    }



    function addDetalle() {
        global $colu;
        global $a_fec;
        global $a_com;
        global $a_comd;
        global $a_let;
        global $a_pto;
        global $a_nro;
        global $a_cli;
        global $a_cuit;
        global $a_civa;
        global $a_neto10;
        //print_r($a_neto10);
        global $a_neto21;
        global $a_neto;
        global $a_iva;
        global $a_iva10;
        global $a_iva21;
        global $a_exe;
        global $a_ngr;
        global $a_riv;
        global $a_iib;
        global $a_gan;
        global $a_sus;
        global $a_imi;
        global $a_nrocuit;
        global $a_per;
        global $a_total;
        
        
        global $tneto;
        global $tiva21;
        global $texe;
        global $tngr;
        global $tiva10;
        global $tret;
        global $tper;
        
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        //$this->SetY(40);
        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_fec);$i++) {
            if($a_com[$i]=="F" or $a_com[$i]=="D" or $a_com[$i]=="G" or $a_com[$i]=="I") {
                $tneto+=$a_neto10[$i]+$a_neto21[$i];
                $tiva10+=$a_iva10[$i];
                $tiva21+=$a_iva21[$i];
                $texe+=$a_exe[$i];
                $tngr+=$a_ngr[$i];
                $tper+=$a_per[$i];
                $tret+=$a_riv[$i]+$a_iib[$i]+$a_sus[$i]+$a_gan[$i]+$a_imi[$i];
                $signo="";
            } else {
                $tn=$a_neto10[$i]+$a_neto21[$i];
                $tneto-=$tn;
                $tiva10-=$a_iva10[$i];
                $tiva21-=$a_iva21[$i];
                $tper-=$a_per[$i];
                $signo="-";
            }
            $this->SetX($colu[0]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(100,5, $a_comd[$i]."-".$a_let[$i]."-".substr("0000",0,4-strlen($a_pto[$i])).$a_pto[$i]."-".substr("00000000",0,8-strlen($a_nro[$i])).$a_nro[$i],0,0);
            $this->SetX($colu[2]);
            $this->Cell(80,5,substr(utf8_decode($a_cli[$i]),0,45),0,0);
            $this->SetX($colu[3]);
            $this->Cell(80,5,$a_civa[$i],0,0);
            $this->SetX($colu[4]);
            $this->Cell(5,5,"CUIT",0,0,"C");
            $this->SetX($colu[5]);
            $this->Cell(15,5,$a_nrocuit[$i],0,0,"C");
            $this->SetX($colu[6]);
            $this->Cell(15,5,$signo.number_format($a_neto[$i],2),0,0,"R");
            $this->SetX($colu[7]);
            $this->Cell(15,5,$signo.number_format($a_iva[$i],2),0,0,"R");
            $this->SetX($colu[8]);
            $this->Cell(15,5,"",0,0,"R");
            $this->SetX($colu[9]);
            $this->Cell(15,5,$signo.number_format($a_ngr[$i],2),0,0,"R");
            $this->SetX($colu[10]);
            $this->Cell(15,5,"",0,0,"R");
            $this->SetX($colu[11]);
            $this->Cell(15,5,$signo.number_format($a_per[$i],2),0,0,"R");
            $this->SetX($colu[12]);
            $this->Cell(15,5,$signo.number_format($a_neto[$i]+$a_iva[$i]+$a_per[$i]+$a_ngr[$i],2),0,1,"R");
            $this->line(5,$this->GetY(),295,$this->GetY());
            
        }
        $this->SetX($colu[1]);
        $this->Cell(100,5,"TOTAL",0,0);
        $this->SetX($colu[6]);
        $this->Cell(15,5,number_format($tneto,2),0,0,"R");
        $this->SetX($colu[7]);
        $this->Cell(15,5,number_format($tiva21+$tiva10,2),0,0,"R");
        $this->SetX($colu[8]);
        $this->Cell(15,5,number_format($texe,2),0,0,"R");
        $this->SetX($colu[9]);
        $this->Cell(15,5,number_format($tngr,2),0,0,"R");
        $this->SetX($colu[10]);
        $this->Cell(15,5,number_format($tret,2),0,0,"R");
        $this->SetX($colu[11]);
        $this->Cell(15,5,number_format($tper,2),0,0,"R");
        $this->SetX($colu[12]);
        $this->Cell(15,5,number_format($tneto+$tiva21+$tiva10+$texe+$tngr+$tret+$tper,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->SetFillColor(200,200,200);

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
        $this->SetX($colu[0]);
        $this->line(5,$this->GetY(),295,$this->GetY());
        $this->Cell(10,5,"TOTALES",0,0);
        $this->SetX($colu[3]);
        $this->Cell(20,5,number_format($tiva10+$tiva21,2),0,1,"R");
        $this->line(5,$this->GetY(),295,$this->GetY());
        
    }
}