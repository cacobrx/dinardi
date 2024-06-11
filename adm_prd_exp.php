<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prd.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_prd";
if($textoprd!="") {
    $ssql.=" where instr(upper(descripcion), '".strtoupper($textoprd)."')>0";
}
$ssql.=" order by descripcion, id limit $limprd,".$cfg->getLimmax();
$adm=new adm_prd_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_est=$adm->getEstadoproductodes();
$a_kil=$adm->getKilosxanimal();
$a_pre=$adm->getPrecioventa();
$a_cod=$adm->getCodigoproducto();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=articulosdeventa.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Descripción</th> ";
echo "<th>Codigo</th> ";
echo "<th>Estado</th> ";
echo "<th>Precio</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".($a_des[$i])."</td>";  
        echo "<td>".$a_cod[$i]."</td>";
        echo "<td>".$a_est[$i]."</td>";
        echo "<td>".number_format($a_pre[$i],2,$cfg->getPuntodecimal(),"")."</td>";
        echo "</tr>";    
}