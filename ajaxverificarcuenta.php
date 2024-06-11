<?php
/*
 * Creado el 19/06/2020 10:00:31
 * Autor: gus
 * Archivo: ajaxverificarcuenta.php
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
$id=$glo->getGETPOST("id");
$val=$glo->getGETPOST("val");
$ssql="select * from adm_cta where codigo='$val' and id!=$id";
//echo $ssql;
$xml='<datos>';
$xml.='<valor>'.$conx->getCantidadReg($ssql).'</valor>';
$xml.='<valor>'.$ssql.'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;   
?>
