<?php
/*
 * creado el 13 ago. 2021 14:25:57
 * Usuario: facu
 * Archivo: ajaxsaverem
 */

require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$val=$glo->getGETPOST("val");
$ssql="select * from adm_rem where id=$val";
$rs=$conx->getConsulta($ssql);
$reg=mysqli_fetch_object($rs);
$control=0;
if($reg->controlado==0) $control=1;
$ssql="update adm_rem set controlado=$control where id=$val";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$xml='<datos>';
$xml.='<valor>'.$control.'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;   

?>
