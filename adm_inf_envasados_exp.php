<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'informes/envasados.php';
//require_once 'impresion/pdf_envasados.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");

$vta=new envasados($fechaini, $fechafin);
$a_kil=$vta->getKilos();
$a_des=$vta->getDescripcion();
$a_can=$vta->getCantidad();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=InformeEnvasados.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Cantidad</th> ";
echo "<th>Articulos</th> ";
echo "<th>Kilos</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_can);$i++) {
        echo "<tr>";
        echo "<td>". number_format($a_can[$i],0)."</td>";
        echo "<td>".$a_des[$i]."</td>";   
        echo "<td>". number_format($a_kil[$i],2)."</td>";
        echo "</tr>";    
}