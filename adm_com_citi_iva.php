<?php
/*
 * Creado el 29/09/2015 13:44:13
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_citi_iva
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
//$ssql="select * from adm_com where centro=$centrosel and fecha>='$fechainicom' and fecha<='$fechafincom' order by fecha, id";
$ssql="select * from adm_com where centro=$centrosel and fecha>='$fechainicom' and fecha<='$fechafincom' and letra!='X' order by fecha, id";

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
    $cad.=date("Ymd", strtotime($a_fec[$i]));
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
    $neto21=$a_neto21[$i]*100;
    $iva21=$a_iva21[$i]*100;
//    echo "tipocomprobante: $tipocomprobante<br>";
    if($neto21>0) {
        $cadiva.=$tipocomprobante;
        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
        $cadiva.=$sup->AddZeros($a_num[$i], 20);
        $cadiva.=$sup->AddZeros($a_cdc[$i], 2);
        $cadiva.=$sup->AddZeros($a_cuit[$i], 20);
        $cadiva.=$sup->AddZeros($neto21, 15);
        $cadiva.=$sup->AddZeros(5, 4);
        $cadiva.=$sup->AddZeros($iva21, 15);
        $cadiva.="\r\n";
    }
    $neto10=$a_neto10[$i]*100;
    $iva10=$a_iva10[$i]*100;
    if($neto10>0) {
        $cadiva.=$tipocomprobante;
        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
        $cadiva.=$sup->AddZeros($a_num[$i], 20);
        $cadiva.=$sup->AddZeros($a_cdc[$i], 2);
        $cadiva.=$sup->AddZeros($a_cuit[$i], 20);
        $cadiva.=$sup->AddZeros($neto10, 15);
        $cadiva.=$sup->AddZeros(4, 4);
        $cadiva.=$sup->AddZeros($iva10, 15);
        $cadiva.="\r\n";
    }
    $neto27=$a_neto27[$i]*100;
    $iva27=$a_iva27[$i]*100;
    if($neto27>0) {
        $cadiva.=$tipocomprobante;
        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
        $cadiva.=$sup->AddZeros($a_num[$i], 20);
        $cadiva.=$sup->AddZeros($a_cdc[$i], 2);
        $cadiva.=$sup->AddZeros($a_cuit[$i], 20);
        $cadiva.=$sup->AddZeros($neto27, 15);
        $cadiva.=$sup->AddZeros(6, 4);
        $cadiva.=$sup->AddZeros($iva27, 15);
        $cadiva.="\r\n";
    }
//    if($neto21==0 and $neto10==0 and $neto27==0) {
//        $cadiva.=$tipocomprobante;
//        $cadiva.=$sup->AddZeros($a_pto[$i], 5);
//        $cadiva.=$sup->AddZeros($a_num[$i], 20);
//        $cadiva.=$sup->AddZeros($a_cdc[$i], 2);
//        $cadiva.=$sup->AddZeros($a_cuit[$i], 20);
//        $cadiva.=$sup->AddZeros($a_ngr[$i], 15);
//        $cadiva.=$sup->AddZeros(6, 4);
//        $cadiva.=$sup->AddZeros(0, 15);
//        $cadiva.="\r\n";
//    }
}
header("Content-Description: File Transfer"); 
header("Content-Type: application/force-download"); 
header("Content-Disposition: attachment; filename=\"citi_compras_alicuotas.txt\";" );
header("Content-Transfer-Encoding: binary");
print $cadiva;

