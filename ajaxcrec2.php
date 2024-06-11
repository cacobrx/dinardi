<?php
/*
 * Creado el 03/10/2020 13:49:22
 * Autor: gus
 * Archivo: ajaxcrec2.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$val=$glo->getGETPOST("val");
$conn=$conx->conectarBase();

$f_id=array();
$f_com=array();
$f_imp=array();
$ssql="select * from adm_fis where idcli=$val order by fecha";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    $ssql="select * from adm_crec2 where idfis=".$reg->id;
    if($conx->getCantidadRegA($ssql, $conn)==0) {
        array_push($f_id,$reg->id);
        $importe=$reg->total;
        array_push($f_com,$reg->tipo.$reg->letra."-".$sup->AddZeros($reg->ptovta, 4)."-".$sup->AddZeros($reg->numero, 8)." --> $importe");
        array_push($f_imp,$importe);
    }
}
$xml='<datos>';
$xml.='<valor>'.count($f_id).'</valor>';
for($i=0;$i<count($f_id);$i++) {
    $xml.='<valor>'.$f_id[$i]."|".$f_com[$i].'</valor>';
}
$xml.='</datos>';
header('Content-type: text/xml');
echo $xml;    
