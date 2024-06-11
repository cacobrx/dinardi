<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/congelados.php';
require_once 'clases/support.php';
require_once 'impresion/inf_congelados.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$informe=$glo->getGETPOST("informe");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$primero=$glo->getGETPOST("primero");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
$idart=$glo->getGETPOST("idart");
$idprv=$glo->getGETPOST("idprv");

$inf=new congelados($fechaini, $fechafin, $idart, $idprv);
$a_art=$inf->getArticulo();
$a_caj=$inf->getCajas();
$a_kil=$inf->getKilos();
$a_fec=$inf->getFecha();
$totalcajas=$inf->getTotalcajas();
$totalkilos=$inf->getTotalkilos();


header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=informe_congelados.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Articulo</th> ";
echo "<th>Cajas</th> ";
echo "<th>Kilos</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_fec);$i++) {
    if(count($a_art[$i])>0) { 
    echo "<tr>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>"; 
    echo "<td></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "</tr>";
    echo "<tr>";
    for($d=0;$d<count($a_art[$i]);$d++) {
    echo "<td></td>";
        
        echo "<td>".$a_art[$i][$d]."</td>";
        echo "<td>".$a_caj[$i][$d]."</td>";
        echo "<td>".number_format($a_kil[$i][$d],2,$cfg->getPuntodecimal(),"")."</td>";
        
    echo "</tr>";    
    }
}
}