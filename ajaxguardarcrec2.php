<?php
/*
 * Creado el 03/10/2020 16:14:35
 * Autor: gus
 * Archivo: ajaxguardarcrec2.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_fis.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$val=$glo->getGETPOST("val");
$idcrec=$glo->getGETPOST("idcrec");
$fis=new adm_fis_1($val);
$clave=$sup->generateKey();
$ssql="select * from adm_crec2 where idfis=$val and clave='$clave'";
if($conx->getCantidadReg($ssql)==0) {
    $ssql="insert into adm_crec2 (idcrec, idfis, importe, importepago, clave) values ($idcrec, $val, ".$fis->getTotal().", ".$fis->getTotal().", '$clave')";
    $conx->getConsulta($ssql);
}
$xml='<datos>';
$xml.='<xml>'.$ssql.'</xml>';
$xml.='</datos>';
$ssql="select sum(importepago) as tt from adm_crec2 where idcrec=$idcrec";
$conx->getConsulta($ssql);
$tt=mysqli_fetch_object($reg->tt);
$ssql="update adm_crec1 set total=$tt where id=$idcrec";
$conx->getConsulta($ssql);
header('Content-type: text/xml');
echo $xml;    
