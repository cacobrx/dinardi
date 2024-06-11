<?php
/*
 * Creado el 15/08/2020 14:36:17
 * Autor: gus
 * Archivo: adm_inf_compras_dia_exp.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$a_fecha= unserialize($glo->getGETPOST("a_fecha"));
$a_prov= unserialize($glo->getGETPOST("a_prov"));
$a_art= unserialize($glo->getGETPOST("a_art"));
$a_can= unserialize($glo->getGETPOST("a_can"));
$a_neto= unserialize($glo->getGETPOST("a_neto"));
$a_iva= unserialize($glo->getGETPOST("a_iva"));
$a_imp= unserialize($glo->getGETPOST("a_imp"));
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=comprasdiarias.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Producto</th> ";
echo "<th>Cantidad</th> ";
echo "<th>Precio</th> ";
echo "<th>Neto</th>";
echo "<th>IVA</th> ";
echo "<th>Total</th> ";
echo "</tr> ";  



for ($i=0;$i<count($a_fecha);$i++) {
    echo "<tr>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fecha[$i])."</td>";
    echo "<td>".utf8_decode($a_prov[$i])."</td>";
    echo "<td>".utf8_decode($a_art[$i])."</td>";
    echo "<td>".number_format($a_can[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>";
    if($a_can[$i]>0) echo number_format($a_neto[$i]/$a_can[$i]*100,2,$cfg->getPuntodecimal(),"");
    echo "</td>";
    echo "<td>".number_format($a_neto[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_iva[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_imp[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";
}
