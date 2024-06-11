<?php
/*
 * Creado el 15/09/2015 13:37:21
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_citi
 */

require_once 'user.php';
//require_once 'clases/conexion.php';
//require_once 'clases/globalson.php';
//require_once 'clases/auditoria.php';
require_once 'clases/adm_com.php';
require_once 'clases/support.php';
$sup=new support();
//$aud = new registra_auditoria();
//$conx = new conexion();
//$glo = new globalson();
$ssql="select * from adm_com where centro=$centrosel and fecha>='$fechainicom' and fecha<='$fechafincom' and letra!='X'";
//$ssql.=" and numero=199";
$ssql.=" order by fecha, id";
$adm=new adm_com_2($ssql);
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_let=$adm->getLetra();
$a_com=$adm->getTipocomabr();
$a_pto=$adm->getPtovta();
$a_num=$adm->getNumero();
$a_prv=$adm->getProveedor();
$a_cuit=$adm->getIvaprov();
$a_neto21=$adm->getNeto21();
$a_neto10=$adm->getNeto10();
$a_neto27=$adm->getNeto27();
$a_iva21=$adm->getIva21();
$a_iva10=$adm->getIva10();
$a_iva27=$adm->getIva27();
$a_pri=$adm->getPeriva();
$a_rti=$adm->getRetiva();
$a_prb=$adm->getPerretiibb();
$a_exe=$adm->getExento();
$a_ngr=$adm->getNogravado();
$a_fev=$adm->getFechaven();
$a_imi=$adm->getImpinternos();
$a_mov=$adm->getMovimiento();
$a_tot=$adm->getTotaltotal();
$a_cdc=$adm->getCodigocomprobante();

$cad="";
$cadiva="";
for($i=0;$i<count($a_id);$i++) {
    
    $prv=$sup->SanearCaracteres($a_prv[$i]);
    //echo "2: ".$prv."<br>";
    switch ($a_let[$i]) {
        case "A":
            switch ($a_com[$i]) {
                case "FC": // fc
                    $tipocomprobante=1;
                    break;
                case "NC": // nc
                    $tipocomprobante=3;
                    break;
                case "ND": // nd
                    $tipocomprobante=2;
                    break;
            }
            break;
        case "B":
            switch ($a_com[$i]) {
                case "FC": // fc
                    $tipocomprobante=6;
                    break;
                case "NC": // nc
                    $tipocomprobante=8;
                    break;
                case "ND": // nd
                    $tipocomprobante=7;
                    break;
            }
            break;
        case "C":
            switch ($a_com[$i]) {
                case "FC": // fc
                    $tipocomprobante=11;
                    break;
                case "NC": // nc
                    $tipocomprobante=13;
                    break;
                case "ND": // nd
                    $tipocomprobante=12;
                    break;
            }
            break;
    }
    
    $tipocomprobante=$sup->AddZeros($tipocomprobante, 3);
    
    $totaltotal=$a_tot[$i]*100;
    if($a_let[$i]=="A") {
        $nogravado=$a_ngr[$i]*100;
    } else {
        $nogravado=0;
    }
    $exento=$a_exe[$i]*100;
    $retencioniva=$a_rti[$i]*100;
    $percepcioniva=$a_pri[$i]*100;
    $percepcioniibb=$a_prb[$i]*100;
    $impuestosinternos=$a_imi[$i]*100;
    $creditofiscal=$a_iva10[$i]+$a_iva21[$i]+$a_iva27[$i];
    $creditofiscal=$creditofiscal*100;
    $caniva=0;
    if($a_iva10[$i]>0)
        $caniva++;
    if($a_iva21[$i]>0)
        $caniva++;
    if($a_iva27[$i]>0)
        $caniva++;
//    echo "exe: ".$a_exe[$i]." | $caniva<br>";
//    if($caniva==0 and ($a_let[$i]!="C" or $a_exe[$i]>0)) $caniva=1;
//    echo "iva: $caniva<br>";
//    if($totaltotal<0)
//        $cad.="-".$sup->AddZeros (abs($totaltotal), 14);
//    else
    if($caniva>0) {
        $cad.=date("Ymd", strtotime($a_fec[$i]));
        $cad.=$tipocomprobante;
        $cad.=$sup->AddZeros($a_pto[$i], 5);
        $cad.=$sup->AddZeros($a_num[$i], 20);
        $cad.=$sup->AddSpaces("", 16);
        $cad.=$sup->AddZeros($a_cdc[$i], 2);
        $cad.=$sup->AddZeros($a_cuit[$i], 20);
        $cad.=$sup->AddSpaces($prv, 30);
        
        $cad.=$sup->AddZeros (abs($totaltotal), 15);

        $cad.=$sup->AddZeros($nogravado, 15);
        $cad.=$sup->AddZeros($exento, 15);
        $cad.=$sup->AddZeros($percepcioniva+$retencioniva, 15);
        $cad.=$sup->AddZeros("", 15);
        $cad.=$sup->AddZeros($percepcioniibb, 15);
        $cad.=$sup->AddZeros("", 15);
        $cad.=$sup->AddZeros($impuestosinternos, 15);
        $cad.="PES"; // 17
        //$cad.=$sup->AddZeros(1, 10); // 18
        $cad.="0001000000";
        $cad.=$caniva;
        $cad.=" ";
        $cad.=$sup->AddZeros($creditofiscal, 15); // 21
        $cad.=$sup->AddZeros("", 15); // 22
        $cad.=$sup->AddZeros("", 11); // 23
        $cad.=$sup->AddSpaces("", 30); // 24
        $cad.=$sup->AddZeros("", 15); // 25
        $cad.="\r\n";
    }
}
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"citi_compras.txt\";" );
header("Content-Transfer-Encoding: binary");
print $cad;

?>
