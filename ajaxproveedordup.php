<?php
/*
 * Creado el 25/08/2020 11:17:34
 * Autor: gus
 * Archivo: ajaxproveedorsup.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$val=$glo->getGETPOST("val");
$tarea=$glo->getGETPOST("tarea");
$anterior=$glo->getGETPOST("anterior");
if($tarea=="A") 
    $ssql="select * from adm_prv where cuit='$val'";
else
    $ssql="Select * From adm_prv where cuit='$val' and cuit!='$anterior'";
$xml='<datos>';
$xml.='<valor>'.$conx->getCantidadReg($ssql).'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;   

