<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_ela extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fecha;
        global $horaing;
        global $horaegr;
        global $empleados;
        global $observacion1;
        global $observacion2;
        global $turno;

        $this->SetFont("Arial","",10);
        $this->SetXY(10, 35);
        $this->Cell(100, 5,"Fecha: ".$dsup->getfechanormalcorta($fecha), 0, 1);
        $this->Cell(100, 5,"Hora de Ingreso: ".$dsup->getFechaHoraNormal($horaing)." Hora egreso: ".$dsup->getFechaHoraNormal($horaegr)." Sector: ".utf8_decode($turno), 0, 1);
        $this->Cell(10, 5, "Empleados: ".$empleados,0,1);
        $this->Cell(10, 5, utf8_decode("Contaminantes Fisicos en algún lote: ".$observacion1),0,1);
        $this->Cell(10, 5, utf8_decode("Color, olor no conforme: ".$observacion2),0,1);
        
        
        
        
        
        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        $this->addPageNumber($this->PageNo());
        $this->TituloRec(utf8_decode("Orden de Producción - ELABORACIÓN"));
        $r1=5;
        $r2=290;
        $y1=60;
        $y2=205;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXY($colu[0],61);
        $this->Cell(10,5,"Articulo",0,0,"L");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha ingreso",0,0,"C");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Proveedor",0,0,"L");  
        $this->setX($colu[3]);
        $this->Cell(10,5,"Kg Descarte",0,0,"R");          
        $this->setX($colu[4]);
        $this->Cell(20,5,"Kg Final",0,1,"R");           

    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $d_id;
        global $d_fec;
        global $d_art;
        global $p_prv;
        global $d_kgd;
        global $d_kgf;
        global $colu;
    

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($d_id);$i++) {
            $prov="";
            for($p=0;$p<count($p_prv[$i]);$p++) {
                $prov.=$p_prv[$i][$p]." /";
            }
            $this->SetX($colu[0]);
            $this->Cell(10,5,$d_art[$i],0,0,"L");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($d_fec[$i]),0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(10,5, utf8_decode($prov),0,0,"L"); 
            $this->SetX($colu[3]);
            $this->Cell(10,5,$d_kgd[$i],0,0,"R");             
            $this->SetX($colu[4]);
            $this->Cell(20,5,$d_kgf[$i],0,1,"R"); 
            $this->Line(5, $this->GetY(), 290, $this->GetY());
        }
        $this->SetFont("Arial", "B", 8);
        $this->SetX($colu[0]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->SetX($colu[4]);
        $this->Cell(20,5,number_format(array_sum($d_kgf),2),0,1,"R"); 
    }
 }
 
 class elaboracion_prn extends pdf_function {
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
        $this->addPageNumber($this->PageNo());
        $this->TituloRec(utf8_decode("Elaboración"));
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",8);
        $this->setX($colu[0]);
        $this->Cell(20,5,"Fecha",0,0,"C");
        $this->SetX($colu[1]);
        $this->Cell(30,5,"Hora Ingreso / Egreso",0,0,"C");
        $this->SetX($colu[2]);
        $this->Cell(30,5,"Hora Ingreso / Egreso",0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(20,5,"Empleados",0,1,"C");       



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
        global $a_hin1;
        global $a_heg1;
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
            $this->Cell(20,5,$dsup->getfechanormalcorta($a_fec[$i]),0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(30,5,$a_hin[$i]." / ".$a_heg[$i],0,0,"C");
            $this->SetX($colu[2]);
            $this->Cell(30,5,$a_hin1[$i]." / ".$a_heg1[$i],0,0,"C");
            $this->SetX($colu[3]);
            $this->Cell(20,5, $a_emp[$i],0,1,"C");
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
                for($d=0;$d<count($a_art[$i]);$d++) {
                    $prove="";
                    for($p=0;$p<count($a_prv[$i][$d]);$p++) {
                        $prove.=$a_prv[$i][$d][$p]." /";
                    }
                    if($prove!="") $prove=substr($prove,0,strlen($prove)-3);
                    $this->SetX($colu2[0]);
                    $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fin[$i][$d]),0,0,"C");
                    $this->SetX($colu2[1]);
                    $this->Cell(10,5, utf8_decode($prove),0,0,"L");
                    $this->SetX($colu2[2]);
                    $this->Cell(10,5, utf8_decode($a_art[$i][$d]),0,0,"C");                
                    $this->SetX($colu2[3]);
                    $this->Cell(20,5, number_format($a_kgd[$i][$d],2),0,0,"R");
                    $this->SetX($colu2[4]);
                    $this->Cell(20,5, number_format($a_kgf[$i][$d],2),0,1,"R");
                }
                $this->SetFont("Arial","B",8);
                $this->SetX($colu2[0]);
                $this->Cell(10,5,"TOTAL",0,0);
                $this->SetX($colu2[3]);
                $this->Cell(20,5, number_format(array_sum($a_kgd[$i]),2),0,0,"R");
                $this->SetX($colu2[4]);
                $this->Cell(20,5, number_format(array_sum($a_kgf[$i]),2),0,1,"R");


            }   
            $this->Line(5, $this->GetY(), 205, $this->GetY());
        }
//        $this->Line(5, $this->GetY(), 205, $this->GetY());

    }
    
}
      