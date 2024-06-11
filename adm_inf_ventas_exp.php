<?php
/*
 * Creado el 03/10/2019 13:49:57
 * Autor: gus
 * Archivo: adm_inf_ventas_exp.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/ventas.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$informe=$glo->getGETPOST("informe");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$idcli=$glo->getGETPOST("idcli");
$idart=$glo->getGETPOST("idart");
$orden=$glo->getGETPOST("orden");
$primero=$glo->getGETPOST("primero");
if($orden=="") $orden=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($informe==1)
    $inf=new inf_ventas($fechaini, $fechafin, $orden, $idcli, $idart);
else {
    $inf=new inf_ventas_cli($fechaini, $fechafin, $orden, $idcli, $idart);
    $a_por=$inf->getPorcentaje();
    $a_per=$inf->getPercepcioniibb();
    $a_tot=$inf->getTotal();
}
$a_art=$inf->getArticulo();
$a_imp=$inf->getImporte();
$a_can=$inf->getCantidad();
$a_net=$inf->getNeto();
$a_iva=$inf->getIva();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=informe_ventas.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Descripcion</th> ";
echo "<th>Cantidad</th> ";
echo "<th>Neto</th> ";
echo "<th>Iva</th> ";
echo "<th>Importe</th> ";
if($informe==2) { 
    echo "<th>%</th>";
    echo "<th>Perc.IIBB</th>";
    echo "<th>Total</th>";
}
echo "</tr> ";  
for($i=0;$i<count($a_art);$i++) {
    echo "<tr>";
    echo "<td>".utf8_decode($a_art[$i])."</td>";  
    echo "<td>".number_format($a_can[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_net[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_iva[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_imp[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    if($informe==2) {
        echo "<td>".number_format($a_por[$i],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "<td>".number_format($a_per[$i],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "<td>".number_format($a_tot[$i],2,$cfg->getPuntodecimal(),"")."</td>";
        
    }
    echo "</tr>";    
}
