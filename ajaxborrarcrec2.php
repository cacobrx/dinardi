<?php
/*
 * Creado el 03/10/2020 16:49:07
 * Autor: gus
 * Archivo: ajaxborrarcrec2.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_crec.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$val=$glo->getGETPOST("val");
$adm=new adm_crec2_1($val);
$idcrec=$adm->getIdcrec();
$ssql="delete from adm_crec2 where id=$val";
//$conx->getConsulta($ssql);
$aud->regAud("RECIBOS - Comprobantes", $usr->getId(), "Elimina comprobante a aplicar del recibo ".$adm->getIdcrec()." / ".$adm->getComprobante()." / ".$adm->getFecha(), $centrosel);
$xml='<datos>';
$xml.='<xml>'.$ssql.'</xml>';
$xml.='</datos>';
$conx->getConsulta($ssql);
header('Content-type: text/xml');
echo $xml;    
