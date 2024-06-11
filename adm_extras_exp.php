<?php
/*
 * Creado el 21/01/2016 13:21:45
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_desc_extras
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_extras.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$idpersel=$glo->getGETPOST("idpersel");
$ssql="select * from adm_extras where fecha>='$fechainiext' and fecha<='$fechafinext'";
if($empleadoext>0)
    $ssql.=" and idper=$empleadoext";
$ssql.=" order by fecha, id limit $limext,".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_extras_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_idd=$adm->getIdper();
$a_nom=$adm->getPersona();
$a_imp=$adm->getImporte();
$a_per=$adm->getPersona();
$cantidadtotal=$adm->getMaxRegistros();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Extras Empleados.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Fecha</th> ";
echo "<th>Empleados</th> ";
echo "<th>Importe</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {

  echo "<tr>";
   echo "<td>".$a_id[$i]."</td>";
  echo "<td>".$dsup->getfechanormalcorta($a_fec[$i])."</td>";
  echo "<td>".$a_per[$i]."</td>";
  echo "<td>".number_format($a_imp[$i],2,",","")."</td>";
  echo "</tr>";
}