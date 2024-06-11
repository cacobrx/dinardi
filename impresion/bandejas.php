<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_band extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        global $colu;
        global $fechainiband;
        global $fechafinband;
       
        
        
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
        $this->Cell(80,10,"ORDEN DE PRODUCCION - BANDEJAS",0,1);
        
        
        $this->SetFont("Arial","",14    );
        $this->SetXY(230, 10);
        $this->Cell(80,10,"RGL - 31",0,1);
        $this->SetX(230);
        $this->Cell(80,10,utf8_decode("Versión 04"),0,1);
        $this->SetX(230);
        $this->Cell(80,10,utf8_decode("Fecha de alta: "),0,1);
        
        $this->SetFont("Arial","",10);
        $this->SetXY(10, 40);
        $this->Cell(100, 5,"Fecha: ".$dsup->getfechanormalcorta($fechainiband)." hasta ".$dsup->getFechaNormalCorta($fechafinband), 0, 0);
        $this->SetXY(140, 40);
        $this->Cell(100, 5,"Responsable de control: ",0,0);
        
        
        
        
//        
//        $this->addCliente( $cfg->getEmpresa(), $cfg->getTelefono());
//        $this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
//        $this->addPageNumber($this->PageNo());
//        $this->TituloRec(utf8_decode("Orden de Producción - ELABORACIÓN"));
  
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setXY($colu[0],45);
        $this->Cell(30,5,"Fecha Ingreso",1,0,"C");
        $this->setX($colu[1]);
        $this->Cell(60,5,"Articulo",1,0,"L");
        $this->setX($colu[2]);
        $this->Cell(60,5,"Proveedor",1,0,"L");  
        $this->setX($colu[3]);
        $this->Cell(15,5,"KG",1,0,"R");          
        $this->setX($colu[4]);
        $this->Cell(15,5,"Hielo",1,0,"C");           
        $this->setX($colu[5]);
        $this->Cell(15,5,utf8_decode("T°"),1,0,"C");  
        $this->setX($colu[6]);
        $this->Cell(20,5,utf8_decode("Túnel"),1,0,"C");          
        $this->setX($colu[7]);
        $this->Cell(20,5,"Ctrl Organ",1,0,"R");           
        $this->setX($colu[8]);
        $this->Cell(25,5,utf8_decode("Cont Físicos"),1,0,"R");          
        $this->setX($colu[9]);
        $this->Cell(25,5,"KG Rechazo",1,1,"R"); 

       

    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_art;
        global $a_prv;
        global $a_kgr;
        global $a_hie;
        global $a_tem;
        global $a_tun;
        global $a_kg;
        global $a_cnn;
        global $a_con;
        
        global $colu;
    

        $this->SetFont('Arial','',8);
        for($i=0;$i<count($a_id);$i++) {
        if($a_hie[$i]==1)
            $a_hie[$i]="Si";
        else 
            $a_hie[$i]="No";
        if($a_cnn[$i]==1)
            $a_cnn[$i]="Si";
        else 
            $a_cnn[$i]="No";
        if($a_con[$i]==1)
            $a_con[$i]="Si";
        else 
            $a_con[$i]="No";            
            $this->setX($colu[0]);
            $this->Cell(30,5,$dsup->getFechaNormalCorta($a_fec[$i]),1,0,"C");
            $this->setX($colu[1]);
            $this->Cell(60,5,$a_art[$i],1,0,"L");
            $this->setX($colu[2]);
            $this->Cell(60,5,$a_prv[$i],1,0,"L");  
            $this->setX($colu[3]);
            $this->Cell(15,5,$a_kg[$i],1,0,"R");          
            $this->setX($colu[4]);
            $this->Cell(15,5,$a_hie[$i],1,0,"C");           
            $this->setX($colu[5]);
            $this->Cell(15,5,utf8_decode($a_tem[$i]."°C"),1,0,"C");  
            $this->setX($colu[6]);
            $this->Cell(20,5,$a_tun[$i],1,0,"C");          
            $this->setX($colu[7]);
            $this->Cell(20,5,$a_cnn[$i],1,0,"R");           
            $this->setX($colu[8]);
            $this->Cell(25,5,$a_con[$i],1,0,"R");          
            $this->setX($colu[9]);
            $this->Cell(25,5,$a_kgr[$i],1,1,"R"); 
        }
        $this->SetFont("Arial","B",6);        
        $this->setXY(10,160);
        $this->Cell(70,5,"Control",1,0,"C");
        $this->setX(80);
        $this->Cell(75,5,utf8_decode("Límite critico"),1,0,"C");
        $this->setX($colu[3]);
        $this->Cell(130,5,"Acciones Correctivas",1,1,"C");           
        $this->SetFont("Arial","",6.5);        
        $this->setX(10);
        $this->Cell(70,5,utf8_decode("Temperatura de mercadería"),1,0,"L");
        $this->setX(80);
        $this->Cell(75,5,utf8_decode("< 10°C"),1,0,"L");
        $this->setX($colu[3]);
        $this->Cell(130,5,utf8_decode("Enviar a cámara hasta alcanzar la temperatura establecida (10°C)"),1,1,"L");           
        $this->setX(10);
        
        $this->Cell(70,5,utf8_decode("Control visual"),1,0,"L");
        $this->setX(80);
        $this->Cell(75,5,"Ausencia de contaminantes",1,0,"L");
        $this->setX($colu[3]);
        $this->Cell(130,5,"Retirar el contaminante. Colocar el cartel 'cartel rojo' de producto no conforme. Llamar al jefe de Planta/Calidad/Encargados",1,1,"L");           
        $this->Cell(70,5,utf8_decode("Control Organoleptico"),1,0,"L");
        $this->setX(80);
        $this->Cell(75,5,"Olor/Color caracteristico de mercaderia fresca",1,0,"L");
        $this->setX($colu[3]);
        $this->Cell(130,5,"Identificar producto no conforme. Llamar al jefe de Planta/Calidad/Encargados",1,1,"L");           
    }
 }
      