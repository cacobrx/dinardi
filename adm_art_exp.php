<?php
/*
 * Creado el 19/05/2018 16:36:11
 * Autor: gus
 * Archivo: adm_art_exp.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_art.php';
require_once 'impresion/adm_art_prn.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_art";
if($textoart!="") {
    $ssql.=" where instr(upper(descripcion), '".strtoupper($textoart)."')>0";
}
$ssql.=" order by descripcion, id";
//echo $ssql;
$adm=new adm_art_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_pre=$adm->getPrecio();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Productos.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Descripcion</th> ";
echo "<th>Precio</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".utf8_decode($a_des[$i])."</td>";  
        echo "<td>".number_format($a_pre[$i],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "</tr>";    
}
?>

