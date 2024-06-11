<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_env extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fechainienv;
        global $fechafinenv;
       
        
        
        $r1=5;
        $r2=290;
        $y1=5;
        $y2=40;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');          
        $this->Line(80, 5, 80, 40);
        $this->Line(210, 5, 210, 40);
        
        $this->SetFont("Arial","B",16);
        $this->SetXY(10, 10);
        $this->Cell(80,10,"Dinardi",0,1);
        $this->Cell(80,10,"Menudencias S.A.",0,1);
        
        $this->SetFont("Arial","B",16);
        $this->SetXY(120, 10);
        $this->Cell(80,10,"Registro General",0,1);
        $this->SetX(95);
        $this->SetFont("Arial","",16);
        $this->Cell(80,10,"ORDEN DE PRODUCCION - ENVASADO",0,1);
        
        
        $this->SetFont("Arial","",14    );
        $this->SetXY(230, 10);
        $this->Cell(80,10,"RGL - 31",0,1);
        $this->SetX(230);
        $this->Cell(80,10,utf8_decode("Versión 04"),0,1);
        $this->SetX(230);
        $this->Cell(80,10,utf8_decode("Fecha de alta: "),0,1);
        
        $this->SetFont("Arial","",10);
        $this->SetXY(10, 40);
        $this->Cell(100, 5,"Fecha: ".$dsup->getfechanormalcorta($fechainienv)." hasta ".$dsup->getFechaNormalCorta($fechafinenv), 0, 0);
        $this->SetXY(140, 40);
        $this->Cell(100, 5,utf8_decode("Túnel: "),0,0);
        
        
        
        
//        
//        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
//        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//        $this->addPageNumber($this->PageNo());
//        $this->TituloRec(utf8_decode("Orden de Producción - ELABORACIÓN"));
  
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXY($colu[0],45);
        $this->Cell(60,5,utf8_decode("Artículo"),1,0,"L");
        $this->setX($colu[1]);
        $this->Cell(10,5,utf8_decode("T° 1"),1,0,"L");
        $this->setX($colu[2]);
        $this->Cell(10,5,utf8_decode("T° 2"),1,0,"L");  
        $this->setX($colu[3]);
        $this->Cell(10,5,utf8_decode("T° 3"),1,0,"R");          
        $this->setX($colu[4]);
        $this->Cell(20,5,"F. Ingreso",1,0,"C");           
        $this->setX($colu[5]);
        $this->Cell(85,5,utf8_decode("Proveedor"),1,0,"C");  
        $this->setX($colu[6]);
        $this->Cell(20,5,utf8_decode("Kg Desc."),1,0,"C");          
        $this->setX($colu[7]);
        $this->Cell(25,5,utf8_decode("Lote"),1,0,"C");          
        $this->setX($colu[8]);
        $this->Cell(15,5,"Cajas",1,0,"C");           
        $this->setX($colu[9]);
        $this->Cell(20,5,"Kilos",1,0,"R");           
        $this->setX($colu[10]);
        $this->Cell(10,5,"Tunel",1,1,"C");           


       

    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_ida;
        global $a_idp;
        global $a_idp1;
        global $a_idp2;
        global $a_kgd;
        global $a_t1;
        global $a_t2;
        global $a_t3;
        global $a_lot;
        global $a_can;
        global $a_kil;
        global $a_tun;
        
        global $colu;
    

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
            $prov=$a_idp[$i];
            if(trim($a_idp1[$i])!="") $prov.=" /".$a_idp1[$i];
            if(trim($a_idp2[$i])!="") $prov.=" /".$a_idp2[$i];
            $this->setX($colu[0]);
            $this->Cell(60,5, utf8_decode($a_ida[$i]),1,0,"L");
            $this->setX($colu[1]);
            $this->Cell(10,5,utf8_decode($a_t1[$i]."°C"),1,0,"C");
            $this->setX($colu[2]);
            $this->Cell(10,5,utf8_decode($a_t2[$i]."°C"),1,0,"C");  
            $this->setX($colu[3]);
            $this->Cell(10,5,utf8_decode($a_t3[$i]."°C"),1,0,"C");          
            $this->setX($colu[4]);
            $this->Cell(20,5,$dsup->getFechaNormalCorta($a_fec[$i]),1,0,"C");           
            $this->setX($colu[5]);
            $this->Cell(85,5,utf8_decode($prov),1,0,"L");  
            $this->setX($colu[6]);
            $this->Cell(20,5,number_format($a_kgd[$i],2),1,0,"R");          
            $this->setX($colu[7]);
            $this->Cell(25,5,$a_lot[$i],1,0,"C");           
            $this->setX($colu[8]);
            $this->Cell(15,5,number_format($a_can[$i],0),1,0,"C");          
            $this->setX($colu[9]);
            $this->Cell(20,5,number_format($a_kil[$i],2),1,0,"R");          
            $this->setX($colu[10]);
            $this->Cell(10,5,$a_tun[$i],1,1,"C");          

        }
        $this->SetFont("Arial","B",8);   
        $this->SetX($colu[7]);
        $this->Cell(20,5,"TOTAL",0,0);
        $this->setX($colu[8]);
        $this->Cell(15,5,number_format(array_sum($a_can),0),0,0,"C");          
        $this->setX($colu[9]);
        $this->Cell(20,5,number_format(array_sum($a_kil),2),0,1,"R");          
        
        
        
        $this->setXY(10,180);
        $this->Cell(70,5,utf8_decode("Temperatura antes de envasar < 10 C°"),0,0,"L");

        $this->setX(200);        
        $this->Cell(70,5,utf8_decode("Responsable"),0,0,"L");

    }
 }
      