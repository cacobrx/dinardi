<?php
/*
 * Creado el 07/10/2019 21:27:16
 * Autor: gus
 * Archivo: adm_inf_compras_exp.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'informes/compras.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
$idprv=$glo->getGETPOST("idprv");
$idart=$glo->getGETPOST("idart");
$orden=$glo->getGETPOST("orden");
$informe=$glo->getGETPOST("informe");
$primero=$glo->getGETPOST("primero");
$solofaena=$glo->getGETPOST("solofaena");
$sinfaena=$glo->getGETPOST("sinfaena");
if($sinfaena=="") $sinfaena=0;
if($solofaena=="") $solofaena=0;

if($orden=="") $orden=1;
if($fechaini=="") $fechaini=date("Y-m-01");
if($fechafin=="") $fechafin=date("Y-m-d");
if($informe==1)
    $inf=new inf_compras($fechaini, $fechafin, $orden, $idprv, $idart, $solofaena, $sinfaena);
else
    $inf=new inf_compras_prv($fechaini, $fechafin, $orden, $idprv, $idart, $solofaena, $sinfaena);
$a_art=$inf->getArticulo();
$a_imp=$inf->getImporte();
$a_can=$inf->getCantidad();
$a_net=$inf->getNeto();
$a_iva=$inf->getIva();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=informe_compras.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
if($informe==1)
    echo "<th>Articulo</th> ";
else
    echo "<th>Proveedor</th>";
echo "<th>Cantidad</th> ";
echo "<th>Neto</th> ";
echo "<th>Iva</th> ";
echo "<th>Total</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_art);$i++) {
    echo "<tr>";
    echo "<td>".utf8_decode($a_art[$i])."</td>";  
    echo "<td>".number_format($a_can[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_net[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_iva[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".number_format($a_imp[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";    
}
