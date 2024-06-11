<?php
/*
 * Creado el 17/12/2018 11:03:26
 * Autor: gus
 * Archivo: adm_rem_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_rem.php';
require_once 'impresion/pdf_rem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select adm_rem.* from adm_rem inner join adm_prv on adm_rem.idprv=adm_prv.id where adm_rem.fecha>='$fechainirem' and adm_rem.fecha<='$fechafinrem'";
if($proveedorrem>0) $ssql.=" and adm_rem.idprv=$proveedorrem";
if($faenarem==1) $ssql.=" and adm_rem.faena=1";
if($sincomprasrem==1) $ssql.=" and adm_rem.idcom=0";
if($seleccionrem==1) $ssql.=" and adm_rem.seleccion=1";
if($certificadorem!="") $ssql.=" and adm_rem.certificado='".$certificadorem."'";
if($paisrem>0) $ssql.=" and instr(adm_prv.paises,'|".$paisrem."|')>0";

//echo $ssql;
$adm=new adm_rem_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getProveedor();
$a_pre=$adm->getTotal();
$a_fec=$adm->getFecha();
$d_id=$adm->getDet_id();
$a_pat=$adm->getPatente();
$a_com=$adm->getIdcom();
$a_ff=$adm->getFaenac();
$d_art=$adm->getDet_articulo();
$d_des=$adm->getDet_descripcion();
$d_imp=$adm->getDet_importe();
$d_pre=$adm->getDet_precio();
$d_tot=$adm->getDet_total();
$d_can=$adm->getDet_cantidad();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=remitos.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Fecha</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Patente</th> ";
echo "<th>F</th>";
echo "<th>CM</th>";
echo "<th>Kilos</th>";
echo "<th>Total</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
        echo "<td>".utf8_encode($a_des[$i])."</td>";  
        echo "<td>".$a_pat[$i]."</td>";
        echo "<td>".$a_ff[$i]."</td>";
        echo "<td>".$a_com[$i]."</td>";
        echo "<td>".number_format(array_sum($d_can[$i]),2,$cfg->getPuntodecimal(),"")."</td>";
        echo "<td>".number_format(array_sum($d_tot[$i]),2,$cfg->getPuntodecimal(),"")."</td>";
        echo "</tr>";    
}