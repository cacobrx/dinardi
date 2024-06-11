<?php
/*
 * creado el 10 ene. 2022 13:13:21
 * Usuario: gus
 * Archivo: adm_trans_exp
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/movbancarios.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$tipo=$glo->getGETPOST("tipo");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($tipo=="") $tipo=0;

$inf=new movbancarios($fechaini, $fechafin, $tipo);
$a_fec=$inf->getFecha();
$a_det=$inf->getDetalle();
$a_imp=$inf->getImporte();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=movbancarios.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Detalle</th> ";
echo "<th>Importe</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_fec);$i++) {
    echo "<tr>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
    echo "<td>". utf8_decode($a_det[$i])."</td>";  
    echo "<td>".number_format($a_imp[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";    
}
