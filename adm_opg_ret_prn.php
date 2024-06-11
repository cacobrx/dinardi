<?php
/*
 * Creado el 05/11/2018 11:51:09
 * Autor: gus
 * Archivo: adm_opg_ret_prn.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_opg1.php';
require_once 'impresion/retencioniibb.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$idop=$glo->getGETPOST("idop");
$nret=1;
$ssql="select * from adm_opg1 order by numeroret desc";
if($conx->getCantidadReg($ssql)>0) {
    $rr=$conx->getConsulta($ssql);
    $rrr=mysqli_fetch_object($rr);
    $nret=$rrr->numeroret;
    $nret++;
}
$ssql="update adm_opg1 set numeroret=$nret where id=$idop and numeroret=0";
$conx->getConsulta($ssql);

$adm=new adm_opg1_1($idop);
$pdf = new retencioniibb('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->addDetalle();
$pdf->Output();

?>
