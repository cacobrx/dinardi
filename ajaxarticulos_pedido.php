<?php
/*
 * Creado el 15/01/2019 11:41:53
 * Autor: gus
 * Archivo: ajaxarticulo_remito.php
 * planbsistemas.com.ar
 */

require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/adm_cli_pre.php';
$conx = new conexion();
$glo = new globalson();
$val=$glo->getGETPOST("val");
$cli=$glo->getGETPOST("cli");
$art=new adm_cli_pre_1($cli, $val);
$xml='<datos>';
$xml.='<valor>'.number_format($art->getPreciofinal(),5,".","").'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;    
?>

