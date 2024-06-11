<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class pdf_rem_exp2 extends pdf_function {
    // private variables
    var $colonnes;
    var $format;
    var $angle=0;

    function Header() {

    }
//
    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/support.php';
        $dsup=new datesupport();
        $sup=new support();
        global $cfg;
        global $colu;
        global $carteltarea;
        global $patente;
        global $adm;
        global $fecha;
        global $exportador;
        global $buque;
        global $destino;
        global $remitente;
        global $agenciapre;
        global $precinto;
        global $nro;
        global $contenedor;
        global $giro;
        global $procedencia;
        global $ptovta;
        global $numero;
        global $transportista;
        global $balanza;
        global $cuit;
        global $certificado;
        global $serie;
        global $fiscal;
        global $nro2;
        global $patenteca;      
        global $d_can;
        global $d_kgsb;        
        global $d_kgsn;     
        global $cartel;
        
        
        global $d_des;        
        global $cantidaddet;
        global $canttotal;
        global $totalrec;
        
        
        //$this->fact_dev( utf8_decode($carteltarea),0,125);
        //$this->addDate( $dsup->getFechaNormalCorta(date("Y-m-d")));
        //$this->addPageNumber($this->PageNo());
        
        for($c=0;$c<3;$c++) {
            $this->AddPage();
            switch ($c) {
                case 0:
                    $ccopia="ORIGINAL";
                    break;
                case 1:
                    $ccopia="DUPLICADO";
                    break;
                case 2:
                    $ccopia="TRIPLICADO";
                    break;
            }
            $r1=5;
            $r2=205;
            $y1=5;
            $y2=50;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
            $this->Image("images/logodd.png",5,5,23,15);
            $this->SetXY(28, 10);
            $this->SetFont("Arial","B",16);
            $this->Cell(50,5,"Dinardi Menudencias S.A.",0,1,"L");
            $this->SetXY(30, 17);
            $this->SetFont("Arial","",10);        
            $this->Cell(50,5,"Venta de Subproductos Ganaderos",0,2,"L");
            $this->Line(30, 17, 87, 17);        
            $this->SetFont("Arial","B",8);        
            $this->SetXY(10,25);
            $this->Cell(50,5,"RUTA 41       Km 64,400",0,1,"L");        
            $this->Cell(50,5,"2325 440380 - 443620",0,1,"L");        
            $this->Cell(50,5,utf8_decode("6270 San Andrés de Giles (B)"),0,1,"L");
            $this->SetFont("Arial","",8); 
            $this->Cell(50,5,"IVA RESPONSABLE INSCRIPTO",0,1,"L");        


            $this->Line(102, 5, 102, 15);
            $this->setXY(100,16);
            $this->SetFont("Arial","B",18);
            $this->Cell(5,5,"R",0,1,"C");
            $this->setXY(100,20);        
            $this->SetFont("Arial","",7);        
            $this->Cell(5,5,utf8_decode("CODIGO N°11"),0,1,"C");
            $this->Line(102, 24, 102, 50);        
            $this->SetFont("Arial","",7);          
            $this->SetXY(130, 5);
            $this->Cell(5,5,utf8_decode("DOCUMENTO NO VÁLIDO COMO FACTURA"),0,1,"L");


            $this->SetFont("Arial","B",12);          
            $this->SetXY(125, 10);
            $this->Cell(5,5,utf8_decode("REMITO DE EXPORTACIÓN"),0,1,"L");

            $this->SetFont("Arial","B",10);          
            $this->SetXY(135, 15);
            $this->Cell(5,5,utf8_decode("N° ").$sup->Addzeros($ptovta,4)."-".$sup->AddZeros($numero, 8),0,1,"L");

            $this->SetFont("Arial","",10);          

            $this->Line(135, 22, 168, 22);      
            $this->Line(135, 26, 168, 26);      
            $this->Line(135, 22, 135, 33);      
            $this->Line(168, 22, 168, 33);   
            $this->Line(135, 33, 168, 33); 
            $this->Line(146, 22, 146, 33);
            $this->Line(157, 22, 157, 33);


            $this->SetXY(135, 22);
            $this->Cell(11,4,utf8_decode("Día"),0,1,"C");
            $this->SetXY(135, 27);        
            $this->Cell(11,4,substr($dsup->getFechaNormalCorta($fecha),0,2),0,1,"C");

            $this->SetXY(146, 22);
            $this->Cell(11,4,utf8_decode("Mes"),0,1,"C");
            $this->SetXY(146, 27);        
            $this->Cell(11,4,substr($dsup->getFechaNormalCorta($fecha),3 ,2),0,1,"C");

            $this->SetXY(157, 22);
            $this->Cell(11,4,utf8_decode("Año"),0,1,"C");
            $this->SetXY(157, 27);        
            $this->Cell(11,4,substr($dsup->getFechaNormalCorta($fecha),6,4),0,1,"C");

            $this->SetFont("Arial","",8);        
            $this->SetXY(125,35);
            $this->Cell(50,5,"CUIT: 33-71247515-9",0,1,"L");  
            $this->SetXY(125,39);        
            $this->Cell(50,5,"INGRESOS BRUTOS: 33-71247515-9",0,1,"L");        
            $this->SetXY(125,43);
            $this->Cell(50,5,"INICIO DE ACTIVIDADES: 09/12",0,1,"L");        



            $this->SetFont("Arial","",10);
            $this->setXY(5,50);
            $this->Cell(10,5,"Exportador:",0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Buque:"),0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Destino:"),0,1,"L");        
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Remitente:"),0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("P.E Nro:"),0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Precinto Nro:"),0,1,"L");        
            $this->setXY(102,50);
            $this->Cell(10,5,"Procedencia:",0,1,"L");
            $this->setXY(102,55);
            $this->Cell(10,5,"Giro:",0,1,"L");
            $this->setXY(102,60);
            $this->Cell(10,5,"Contenedor:",0,1,"L");  
            $this->setXY(102,65);
            $this->Cell(10,5,"Precinto Agencia Nro:",0,1,"L");          

            $this->SetFont("Arial","B",10); 
            $this->setXY(25,50);
            $this->Cell(10,5,$exportador,0,1,"L");
            $this->SetX(17);         
            $this->Cell(10,5,$buque,0,1,"L");   
            $this->SetX(19);         
            $this->Cell(10,5,$destino,0,1,"L");           
            $this->SetX(23);         
            $this->Cell(10,5,$remitente,0,1,"L");   
            $this->SetX(19);         
            $this->Cell(10,5,$nro,0,1,"L"); 
            $this->SetX(27);         
            $this->Cell(10,5,$precinto,0,1,"L");         
            $this->setXY(124,50);
            $this->Cell(10,5,$procedencia,0,1,"L");
            $this->setXY(110,55);
            $this->Cell(10,5,$giro,0,1,"L");
            $this->setXY(123,60);
            $this->Cell(10,5,$contenedor,0,1,"L");
            $this->setXY(138,65);
            $this->Cell(10,5,$agenciapre,0,1,"L");
    //        
    //        $this->SetX(130);
    //        $this->Cell(70,7,"Fecha de Entrega: ".$dsup->getFechaNormalCorta($adm->getFechaentrega()),1,0,"C");


            $r1=5;
            $r2=205;
            $y1=50;
            $y2=80;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
            $r1=5;
            $r2=205;
            $y1=82;
            $y2=235;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');  
            $r1=5;
            $r2=205;
            $y1=222;
            $y2=228;
            $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D'); 
            $this->Line(32, 222, 32, 235);
            $this->Line(168, 222, 168, 235);
            $this->Line(138, 222, 138, 235);       
            $this->SetXY(8, 223);
            $this->SetFont("Arial","B",10);         
            $this->Cell(25, 4, "Total Bultos");
            $this->SetXY(138, 223);
            $this->Cell(30, 4, "Total Kgs.Brutos");
            $this->SetXY(170, 223);
            $this->Cell(30, 4, "Total Kgs.Netos");  
            $this->setXY(15,230);        
            $this->Cell(10,5,number_format(array_sum($d_can),0));
            $this->setXY(145,230);;
            $this->Cell(20,5,number_format(array_sum($d_kgsb),3));
            $this->setXY(178,230);
            $this->Cell(20,5,number_format(array_sum($d_kgsn),3));             
            $this->SetFont("Arial","",12);
            $this->setXY(5,240);
            $this->Cell(10,5,"Empresa Transportista:",0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("CUIT:"),0,1,"L");
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Patente Camion:"),0,1,"L");        
            $this->SetX(5);         
            $this->Cell(10,5,utf8_decode("Balanza:"),0,1,"L");      
            $this->setXY(112,240);
            $this->Cell(10,5,"Certificado Sanitario:",0,1,"L");
            $this->setXY(112,245);
            $this->Cell(10,5,"Serie:",0,1,"L");
            $this->setXY(112,250);
            $this->Cell(10,5,"Nro:",0,1,"L");  
            $this->setXY(112,255);
            $this->Cell(10,5,"Fiscal:",0,1,"L");  

            $this->SetFont("Arial","B",10); 
            $this->setXY(48,240);
            $this->Cell(10,5,$transportista,0,1,"L");
            $this->SetX(18);         
            $this->Cell(10,5,$cuit,0,1,"L");   
            $this->SetX(38);         
            $this->Cell(10,5,$patenteca,0,1,"L");           
            $this->SetX(23);         
            $this->Cell(10,5,$balanza,0,1,"L");   
            $this->setXY(153,240);         
            $this->Cell(10,5,$certificado,0,1,"L"); 
            $this->setXY(124,245);
            $this->Cell(10,5,$serie,0,1,"L");         
            $this->setXY(121,250);
            $this->Cell(10,5,$nro2,0,1,"L");
            $this->setXY(125,255);
            $this->Cell(10,5,$fiscal,0,1,"L");

            $this->SetX(5);
            $this->Cell(10,5,$ccopia,0,1);

            $this->Ln(10);
            $this->SetFont("Arial","B",10);
            $this->setXy($colu[0], 83);
            $this->Cell(10,5,"Cantidad",0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(15,5,utf8_decode("Descripción"),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(20,5,utf8_decode("Kilos Brutos"),0,0,"C");
            $this->SetX($colu[3]);
            $this->Cell(20,5,utf8_decode("Kilos Neto"),0,1,"C");           


    //        require_once 'clases/datesupport.php';
    //        $dsup=new datesupport();
    //        global $cartel;

    //        global $d_can;
    //        global $d_kgsb;        
    //        global $d_kgsn;     
    //        global $d_des;        
    //        global $cantidaddet;
    //        global $canttotal;
    //        global $totalrec;
    //        global $colu;

            $this->SetFont('Arial','',8);
            for($i=0;$i<count($d_can);$i++) {          
                $this->setX($colu[0]);
                $this->Cell(10,5,$d_can[$i],0,0,"C");       
                $this->SetX($colu[1]);
                $this->Cell(15,5, utf8_decode($d_des[$i]),0,0,"L"); 
                $this->SetX($colu[2]);
                $this->Cell(20,5,number_format($d_kgsb[$i],3),0,0,"C");
                $this->SetX($colu[3]);
                $this->Cell(20,5,number_format($d_kgsn[$i],3),0,1,"C");      

                 $this->Line(5, $this->GetY(), 205, $this->GetY());
            }       
        }
    }
}