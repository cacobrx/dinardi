<?php
/*
 * creado el 20 may. 2021 16:17:43
 * Usuario: gus
 * Archivo: adm_inf_eco_mensual_exp
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'informes/informe5.php';
require_once 'planb_def.php';
require_once 'impresion/eco_mensual.php';

$mesesa=array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$ceroseco=$glo->getGETPOST("ceroseco");
$anoeco=$glo->getGETPOST("anoeco");
$meseco=$glo->getGETPOST("meseco");
$cad=$glo->getGETPOST("cad");
//print_r($cad);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=cuentaeconomica".$anoeco.$meseco.".xls");
header("Pragma: no-cache");
header("Expires: 0"); 
echo "<table border=1> ";

echo "<tr>";
echo "<td>Cuenta</td>";
echo "<td>Importe</td>";
echo "</tr>";

$tots=0;
$tote=0;
$cad1=explode("@",$cad);
for($i=0;$i<count($cad1);$i++) {
    $cad2=explode("|",$cad1[$i]);
    $asal=$cad2[1];
    $anom=$cad2[0];
    $aesp=$cad2[2];
    if($asal>0 and strlen($aesp)==2) $tote+=$asal;
    if($asal<0 and strlen($aesp)==2) $tots+=$asal;
    echo "<tr>";
    echo "<td>".utf8_decode($anom);
    echo "<td>".number_format($asal,2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";
}    
echo "<tr>";
echo "<td>Ingresos</td>";
echo "<td>".number_format($tote,2,$cfg->getPuntodecimal(),"")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Egresos</td>";
echo "<td>".number_format($tots,2,$cfg->getPuntodecimal(),"")."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Total</td>";
echo "<td>".number_format($tote+$tots,2,$cfg->getPuntodecimal(),"")."</td>";
echo "</tr>";
echo "</table>";
