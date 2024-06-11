<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_crem_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_crem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$limmax=$cfg->getLimmax();
//$limmax=5;
$ssql="select * from adm_crem where fecha>='$fechainicrem' and fecha<='$fechafincrem'";
if($clientecrem>0) $ssql.=" and idcli=$clientecrem";
$ssql.=" order by fecha, id";
//echo $ssql;
$adm=new adm_crem_2($ssql);
    
$a_id=$adm->getId();
$a_cli=$adm->getCliente();
$a_tot=$adm->getTotal();
$a_fec=$adm->getFecha();
$a_pat=$adm->getPatente();
$a_fece=$adm->getFechaentrega();
$d_can=$adm->getDet_cantidad();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=remitosdeclientes.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Fecha</th> ";
echo "<th>Fec.Entrega</th> ";
echo "<th>Cliente</th> ";
echo "<th>Patente</th> ";
echo "<th>Total Kilos</th> ";
echo "<th>Total</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";  
        echo "<td>".$dsup->getFechaNormalCorta($a_fece[$i])."</td>";
        echo "<td>".$a_cli[$i]."</td>";
        echo "<td>".$a_pat[$i]."</td>";
        echo "<td>".number_format(array_sum($d_can[$i]),2,$cfg->getPuntodecimal(),"")."</td>";
        echo "<td>".number_format($a_tot[$i],2,$cfg->getPuntodecimal(),"")."</td>";        
        echo "</tr>";    
}
?>