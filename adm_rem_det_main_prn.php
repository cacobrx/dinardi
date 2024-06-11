<?php
/*
 * creado el 18 ago. 2023 18:26:40
 * Usuario: gus
 * Archivo: adm_rem_det_main_prn
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'impresion/paisproductos.php';
require_once 'clases/adm_rem.php';
require_once 'clases/seleccion.php';
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$ssql="select adm_rem_det.*, adm_rem.fecha, adm_prv.paises, adm_rem.certificado from adm_rem_det inner join adm_rem on adm_rem_det.idrem=adm_rem.id inner join adm_prv on adm_rem.idprv=adm_prv.id";
$ssql.=" where adm_rem.fecha>='$fechainiinf' and adm_rem.fecha<='$fechafininf'";
if($paisinf>0) $ssql.=" and instr(adm_prv.paises,'|".$paisinf."|')>0";
$a_art=explode("|",$articulosselinf);
$condicionart="";
for($i=0;$i<count($a_art);$i++) {
    if($a_art[$i]!="")
        $condicionart.="adm_rem_det.idart=".$a_art[$i]." or ";
}
if($condicionart!="") $condicionart=" and (".substr($condicionart,0,strlen($condicionart)-4).")";
$ssql.=$condicionart;
$pais="TODOS";
if($paisinf>0) {
    $pais=$conx->getTextoValor($paisinf, "PAI");
}
//echo $ssql."<br>";

$adm=new adm_rem_det($ssql);
$a_idart=$adm->getIdart();
$a_art=$adm->getArticulo();
$a_pai=$adm->getPais();
$a_fec=$adm->getFecha();
$a_cer=$adm->getCertificado();
$a_kil=$adm->getKilos();
$aic=new articulossel($articulosselinf);
$cadenaart=$aic->getCadena();

$colu=array(5,30,60, 100,185);
$pdf=new paisproductos("P", "mm", "A4");
$pdf->AddPage();
$pdf->Detalle();
$pdf->Output();
