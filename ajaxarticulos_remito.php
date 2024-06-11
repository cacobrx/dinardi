<?php
/*
 * Creado el 15/01/2019 11:41:53
 * Autor: gus
 * Archivo: ajaxarticulo_remito.php
 * planbsistemas.com.ar
 */

require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/adm_prv_pre.php';
$conx = new conexion();
$glo = new globalson();
$val=$glo->getGETPOST("val");
$prov=$glo->getGETPOST("prov");
$art=new adm_prv_pre_1($prov, $val);
$xml='<datos>';
$xml.='<valor>'.number_format($art->getPreciofinal(),5,".","").'</valor>';
$xml.='<valor>'.number_format($art->getAlicuota(),2,".","").'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;    
?>

