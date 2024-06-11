<?php
/*
 * creado el 15/08/2016 17:26:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: ajaxdescriptor2
 */

require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
$conx = new conexion();
$glo = new globalson();
$val=$glo->getGETPOST("val");
$caj=$glo->getGETPOST("caj");
//$ssql="select * from adm_clasif where tipodep='DESN1' and dependencia=$val and caja=$caj order by texto";
$ssql="select * from adm_clasif where tipodep='DESN1' and dependencia=$val order by texto";
//echo $ssql;
$rs=$conx->getConsulta($ssql);
$xml='<datos>';
while($reg=  mysqli_fetch_object($rs)) {
    $xml.='<valor>'.$reg->id.'</valor>';
    $xml.='<valor>'.$reg->texto.'</valor>';
}
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;   
?>