<?php
/*
 * Creado el 07/08/2020 13:58:27
 * Autor: gus
 * Archivo: ajaxletraproveedor.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
//require_once 'clases/adm_prv.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$val=$glo->getGETPOST("val");
$ssql="select * from adm_prv where id=$val";
$rs=$conx->getConsulta($ssql);
$reg=mysqli_fetch_object($rs);
$letra="C";
if($reg->condiva==3) $letra="A";
if($reg->condiva==1) $letra="X";
//echo $ssql;
$xml='<datos>';
$xml.='<valor>'.$letra.'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;   
