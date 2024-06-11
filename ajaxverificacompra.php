<?php
/*
 * Creado el 07/08/2020 13:43:42
 * Autor: gus
 * Archivo: ajaxverificacompra.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$pto=$glo->getGETPOST("pto");
$nro=$glo->getGETPOST("nro");
$val=$glo->getGETPOST("val");
$fec=$glo->getGETPOST("fec");
$tip=$glo->getGETPOST("tip");
$let=$glo->getGETPOST("let");
$anomes=date("Ym", strtotime($fec));
$ssql="select * from adm_per where periodo='$anomes'";
if($conx->getCantidadReg($ssql)>0) {
    $rep=999;
    $ret=1;
} else {

    if($nro=="") $nro=0;
    if($pto=="") $pto=0;
    if($pto==0 or $nro==0) {
        $rep=1;
    } else {

        if($val!="") {
            $ssql="select * from adm_com where idprv=$val and ptovta=$pto and numero=$nro and tipocom=$tip and letra='$let'";
            $rep=$conx->getCantidadReg($ssql);
            $ssql="select * from adm_com where ptovta=$pto and numero=$nro and idprv!=$val and tipocom=$tip and letra='$let'";
            $ret=$conx->getCantidadReg($ssql);
        } else {
            $rep=0;
            $ret=0;
            $ssql="select * from adm_com where ptovta=$pto and numero=$nro and tipocom=$tip and letra='$let'";
            $ret=$conx->getCantidadReg($ssql);
        }
    }
}
if($rep!=0) $ret=0;
//echo $ssql;
$xml='<datos>';
$xml.='<valor>'.$rep.'</valor>';
$xml.='<valor>'.$ret.'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;   
