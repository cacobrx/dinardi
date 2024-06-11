<?php
/*
 * Creado el 08/12/2020 13:48:57
 * Autor: gus
 * Archivo: ajaxseleccionrem.php
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
$s=$glo->getGETPOST("s");
$ssql="update adm_rem set seleccion=$s where id=$val";
$conx->getConsulta($ssql);
$xml='<datos>';
$xml.='<valor>'.$s.'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;
