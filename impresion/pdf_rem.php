<?php
/*
 * Creado el 19/05/2018 16:10:18
 * Autor: gus
 * Archivo: adm_art_prn.php
 * planbsistemas.com.ar
 */

require_once 'pdf_function.php';

class PDF_rem extends pdf_function {
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
        $this->TituloRec("REMITOS");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha",0,0,"L");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Proveedor",0,0,"L");     
        $this->setX($colu[3]);
        $this->Cell(20,5,"Patente",0,0,"C");
        $this->SetX($colu[4]);
        $this->Cell(5,5,"F",0,0,"C");
        $this->SetX($colu[5]);
        $this->Cell(10,5,"Cm",0,0,"C");
        $this->SetX($colu[6]);
        $this->Cell(20,5,"Cantidad",0,0,"C");
        $this->SetX($colu[7]);
        $this->Cell(20,5,"Total",0,1,"R");        



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_des;
        global $a_pat;
        global $a_com;
        global $a_ff;
        global $colu;
        global $colu2;
        global $detallerem;
        global $d_can;
        global $d_art;  
        global $d_des;
        global $d_uni;
        global $d_ani;
        global $c_can;
        global $d_pre;
        global $d_tot;   
        global $a_faena;
        global $c_art;
        global $c_uni;
      
        

        $this->SetFont('Arial','',8);
        $tot=0;
        $totkil=0;
        for($i=0;$i<count($a_id);$i++) {
            $tot+=array_sum($d_tot[$i]);
            if($a_faena[$i]==1)
                $totkil+=array_sum($d_can[$i]);
            else
                $totkil+=array_sum($c_can[$i]);
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,$a_des[$i],0,0,"L");                        
            $this->SetX($colu[3]);
            $this->Cell(20,5,$a_pat[$i],0,0,"C");
            $this->SetX($colu[4]);
            if($a_ff[$i]==1) $this->Cell(5,5,"**",0,0,"C");
            $this->SetX($colu[5]);
            $this->Cell(10,5,$a_com[$i],0,0,"C");
            $this->SetX($colu[6]);
            $this->Cell(20,5,array_sum($d_can[$i]),0,0,"C");
            $this->SetX($colu[7]);
            $this->Cell(20,5,array_sum($d_tot[$i]),0,1,"R");  
//            print_r($d_tot);
//            echo "Ddd";
//            echo $detallerem;
            if($detallerem==1) {                                       
                $this->SetFont("Arial","B",8);            
                $this->SetX($colu2[0]);
                $this->Cell(10,5,"Producto",0,0,"C");
                $this->SetX($colu2[1]);
                $this->Cell(15,5,"Unidad",0,0,"L");
                $this->SetX($colu2[2]);
                $this->Cell(20,5,"Cantidad",0,0,"C");
                $this->SetX($colu2[3]);
                $this->Cell(20,5,"Can.Ctrol",0,0,"C");   
                $this->SetX($colu2[4]);
                $this->Cell(20,5,"Dif.",0,0,"C");   
                $this->SetX($colu2[5]);
                $this->Cell(20,5,"Precio.",0,0,"R");   
                $this->SetX($colu2[6]);
                $this->Cell(20,5,"Total",0,1,"R");

                $this->SetFont("Arial","",8);
                for($d=0;$d<count($d_can[$i]);$d++) {                
                    $this->SetX($colu2[0]);
                    $this->Cell(10,5, utf8_decode($d_art[$i][$d])." ".utf8_decode($d_des[$i][$d]),0,0,"L");
                    $this->SetX($colu2[1]);
                    $this->Cell(10,5,$d_uni[$i][$d],0,0,"L");
                    $this->SetX($colu2[2]);
                    if($d_can[$i][$d]==-1) {                                                             
                        $this->cell(10,5," ",0,0,"C");
                    } else {
                        $this->Cell(20,5,$d_can[$i][$d],0,0,"C");    
                    } 
                    $this->SetX($colu2[3]);
                    if($c_can[$i][$d]==-1) {                                                             
                        $this->cell(10,5," ",0,0,"C");
                    } else {
                        $this->Cell(20,5,$c_can[$i][$d],0,0,"C");    
                    } 
                    $this->SetX($colu2[4]);
                    if($d_can[$i][$d]==-1) {
                        $this->cell(10,5," ",0,0,"C");
                    } else {
                        $dif= floatval($c_can[$i][$d])-floatval($d_can[$i][$d]);
                        $this->Cell(20,5,number_format($dif,3),0,0,"C");    
                    }                         
                    $this->SetX($colu2[5]);
                    $this->Cell(20,5,number_format($d_pre[$i][$d],2),0,0,"R");                
                    $this->SetX($colu2[6]);
                    $this->Cell(20,5,number_format($d_tot[$i][$d],2),0,1,"R");
                }
                if($a_faena[$i]==1) {
                    for($d=0;$d<count($c_can[$i]);$d++) {
                        $this->SetX($colu2[0]);
                        $this->Cell(10,5, "+".utf8_decode($c_art[$i][$d]),0,0);
                        $this->SetX($colu2[1]);
                        $this->Cell(10,5,$c_uni[$i][$d],0,0);
                        $this->SetX($colu2[3]);
                        $this->Cell(20,5,$c_can[$i][$d],0,1,"C");
                    }
                }
            }
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }
        $this->SetFont("Arial", "B", 8);
        $this->SetX($colu[6]);
        $this->Cell(20,5,$totkil,0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->SetX($colu[7]);
        $this->Cell(20,5, number_format($tot,2),0,0,"R");
    }
}

class PDF_rem2 extends pdf_function {
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
        $this->TituloRec("REMITOS DETALLADOS");
        $r1=5;
        $r2=205;
        $y1=35;
        $y2=290;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');    
        $this->Ln(10);
        $this->SetFont("Arial","B",10);
        $this->setX($colu[0]);
        $this->Cell(10,5,"ID",0,0,"C");
        $this->setX($colu[1]);
        $this->Cell(10,5,"Fecha",0,0,"L");
        $this->setX($colu[2]);
        $this->Cell(10,5,"Proveedor",0,0,"L");     
        $this->setX($colu[3]);
        $this->Cell(20,5,"Patente",0,0,"C");
        $this->SetX($colu[4]);
        $this->Cell(5,5,"F",0,0,"C");
        $this->SetX($colu[5]);
        $this->Cell(10,5,"Cm",0,0,"C");
        $this->SetX($colu[6]);
        $this->Cell(20,5,"Cantidad",0,0,"C");
        $this->SetX($colu[7]);
        $this->Cell(20,5,"Total",0,1,"R");        



    }

    function Detalle() {
        require_once 'clases/datesupport.php';
        require_once 'clases/adm_rem.php';
        $dsup=new datesupport();
        global $cartel;

        global $a_id;
        global $a_fec;
        global $a_des;
        global $a_pat;
        global $a_com;
        global $a_ff;
        global $colu;
        global $colu2;
        global $detallerem;
        global $d_can;
        global $d_art;  
        global $d_des;
        global $d_uni;
        global $d_ani;
        global $c_can;
        global $d_pre;
        global $d_pre2;
        global $d_tot;   
        global $a_faena;
        global $c_art;
        global $c_uni;
        
//        print_r($d_can);
//        print_r($c_can);
//        print_r($a_faena);
      
        

        $this->SetFont('Arial','',8);
        $tot=0;
        $totkil=0;
        for($i=0;$i<count($a_id);$i++) {
            if($a_faena[$i]==1)
                $totkil+=array_sum($d_can[$i]);
            else
                $totkil+=array_sum($c_can[$i]);
            
//            $tot+=array_sum($d_tot[$i]);
            $this->SetX($colu[0]);
            $this->Cell(10,5,$a_id[$i],0,0,"C");
            $this->SetX($colu[1]);
            $this->Cell(10,5,$dsup->getFechaNormalCorta($a_fec[$i]),0,0,"L");
            $this->SetX($colu[2]);
            $this->Cell(10,5,utf8_decode($a_des[$i]),0,0,"L");                        
            $this->SetX($colu[3]);
            $this->Cell(20,5, utf8_decode($a_pat[$i]),0,0,"C");
            $this->SetX($colu[4]);
            if($a_ff[$i]==1) $this->Cell(5,5,"**",0,0,"C");
            $this->SetX($colu[5]);
            $this->Cell(10,5,$a_com[$i],0,0,"C");
            $this->SetX($colu[6]);
            $this->Cell(20,5,array_sum($d_can[$i]),0,0,"C");
            $this->SetX($colu[7]);
            $this->Cell(20,5,array_sum($d_tot[$i]),0,1,"R");  
//            print_r($d_tot);
//            echo "Ddd";
//            echo $detallerem;
            $this->SetFont("Arial","B",8);            
            $this->SetX($colu2[0]);
            $this->Cell(10,5,"Producto",0,0,"C");
            $this->SetX($colu2[3]);
            $this->Cell(15,5,"Unidad",0,0,"L");
//            $this->SetX($colu2[2]);
//            $this->Cell(20,5,"Cantidad",0,0,"C");
            $this->SetX($colu2[4]);
            $this->Cell(20,5,"Cantidad",0,0,"C");   
//            $this->SetX($colu2[4]);
//            $this->Cell(20,5,"Dif.",0,0,"C");   
            $this->SetX($colu2[5]);
            $this->Cell(20,5,"Precio.",0,0,"R");   
            $this->SetX($colu2[6]);
            $this->Cell(20,5,"Total",0,1,"R");

            $this->SetFont("Arial","",8);
            $subtotal=0;
            $totalconiva=0;
            for($d=0;$d<count($d_can[$i]);$d++) {                
                $this->SetX($colu2[0]);
                $this->Cell(10,5, utf8_decode($d_art[$i][$d])." ".utf8_decode($d_des[$i][$d]),0,0,"L");
                $this->SetX($colu2[3]);
                $this->Cell(10,5,$d_uni[$i][$d],0,0,"L");
//                $this->SetX($colu2[2]);
//                if($d_can[$i][$d]==-1) {                                                             
//                    $this->cell(10,5," ",0,0,"C");
//                } else {
//                    $this->Cell(20,5,$d_can[$i][$d],0,0,"C");    
//                } 
                $this->SetX($colu2[4]);
                if($c_can[$i][$d]==-1) {                                                             
                    $this->cell(10,5," ",0,0,"C");
                } else {
                    if($a_faena[$i]==1)
                        
                        $this->Cell(20,5,$d_can[$i][$d],0,0,"C");    
                    else 
                        $this->Cell(20,5,$c_can[$i][$d],0,0,"C");    
                } 
//                $this->SetX($colu2[4]);
//                if($d_can[$i][$d]==-1) {
//                    $this->cell(10,5," ",0,0,"C");
//                } else {
//                    $dif= floatval($c_can[$i][$d])-floatval($d_can[$i][$d]);
//                    $this->Cell(20,5,number_format($dif,3),0,0,"C");    
//                }                         
                $this->SetX($colu2[5]);
                $this->Cell(20,5,number_format($d_pre[$i][$d],2),0,0,"R");                
                $this->SetX($colu2[6]);
                if($a_faena[$i]==1) {
                    $this->Cell(20,5,number_format($d_pre[$i][$d]*$d_can[$i][$d],2),0,1,"R");
                    $subtotal+=$d_pre[$i][$d]*$d_can[$i][$d];
                    $totalconiva+=$d_pre2[$i][$d]*$d_can[$i][$d];
                    $tot+=$d_pre2[$i][$d]*$d_can[$i][$d];
                } else {
                    $this->Cell(20,5,number_format($d_pre[$i][$d]*$c_can[$i][$d],2),0,1,"R");
                    $subtotal+=$d_pre[$i][$d]*$c_can[$i][$d];
                    $totalconiva+=$d_pre2[$i][$d]*$c_can[$i][$d];
                    $tot+=$d_pre2[$i][$d]*$c_can[$i][$d];
                }
            }
            $this->Line($colu2[5], $this->GetY(), 205, $this->GetY());
            $this->SetX($colu2[5]);
            $this->Cell(20,5,"Neto",0,0);
            $this->SetX($colu2[6]);
            $this->Cell(20,5,number_format($subtotal,2),0,1,"R");
            $this->SetX($colu2[5]);
            $this->Cell(20,5,"IVA",0,0);
            $this->SetX($colu2[6]);
            $this->Cell(20,5,number_format($totalconiva-$subtotal,2),0,1,"R");
            $this->SetX($colu2[5]);
            $this->Cell(20,5,"Total Remito",0,0);
            $this->SetX($colu2[6]);
            $this->Cell(20,5,number_format($totalconiva,2),0,1,"R");
            
//            if($a_faena[$i]==1) {
//                for($d=0;$d<count($c_can[$i]);$d++) {
//                    $this->SetX($colu2[0]);
//                    $this->Cell(10,5, "+".utf8_decode($c_art[$i][$d]),0,0);
//                    $this->SetX($colu2[1]);
//                    $this->Cell(10,5,$c_uni[$i][$d],0,0);
//                    $this->SetX($colu2[3]);
//                    $this->Cell(20,5,$c_can[$i][$d],0,1,"C");
//                }
//            }
            
            $this->Line(5, $this->GetY(), 205, $this->GetY());

        }
        $this->SetFont("Arial", "B", 8);
        $this->SetX($colu[6]);
        $this->Cell(20,5,$totkil,0,0,"C");
        $this->SetX($colu[3]);
        $this->Cell(10,5,"TOTAL",0,0);
        $this->SetX($colu[7]);
        $this->Cell(20,5, number_format($tot,2),0,0,"R");
    }
}