<?php
/*
 * Creado el 06/02/2021 19:05:11
 * Autor: gus
 * Archivo: ajaxcodigolote.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_art.php';
require_once 'clases/adm_prv.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$art=$glo->getGETPOST("art");
$prv=$glo->getGETPOST("prv");
$fec=$glo->getGETPOST("fec");
$aaa=new adm_art_1($art);
$ppp=new adm_prv_cod($prv);
$cod=$aaa->getCodigodinardi().date("dmY", strtotime($fec)).$ppp->getCodigo();
$xml='<datos>';
$xml.='<valor>'.$cod.'</valor>';
$xml.='<valor>'.$aaa->getCodigodinardi().'</valor>';
$xml.='<valor>'.date("dmY", strtotime($fec)).'</valor>';
$xml.='<valor>'.$ppp->getCodigo().'</valor>';
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;    
