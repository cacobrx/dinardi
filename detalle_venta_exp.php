<?php
/*
 * Creado el 25/06/2020 13:16:39
 * Autor: gus
 * Archivo: detalle_venta_exp.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_fis.php';
$dsup = new datesupport();
$conx = new conexion();
$sup = new support();
$glo = new globalson();
$cfg=new planb_config_1($centrosel);

$ssql="select * from adm_fis where fecha>='2020-01-01' and fecha<='2020-05-31' order by fecha, id";
$adm=new adm_fis_2($ssql);
$d_id=$adm->getDet_id();
$d_idart=$adm->getDet_idart();
$d_articulo=$adm->getDet_articulo();
$d_can=$adm->getDet_cantidad();
$d_pre=$adm->getDet_precio();
$d_imp=$adm->getDet_importe();
$a_fecha=$adm->getFecha();
$a_cliente=$adm->getCliente();
$a_com=$adm->getTipo();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=detalle_ventas.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Cliente</th> ";
echo "<th>Articulo</th> ";
echo "<th>Cantidad</th> ";
echo "<th>Precio</th> ";
echo "<th>Importe</th> ";
echo "</tr> ";  



for ($i=0;$i<count($a_com);$i++) {
    for($j=0;$j<count($d_can[$i]);$j++) {
        if($a_com[$i]=="C") {
            $d_pre[$i][$j]=$d_pre[$i][$j]*-1;
            $d_imp[$i][$j]=$d_imp[$i][$j]*-1;
            $d_can[$i][$j]=$d_can[$i][$j]*-1;
        }

        echo "<tr>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fecha[$i])."</td>";
        echo "<td>".$a_cliente[$i]."</td>";
        echo "<td>".$d_articulo[$i][$j]."</td>";
        echo "<td>".number_format($d_can[$i][$j],0,",","")."</td>";
        echo "<td>".number_format($d_pre[$i][$j],2,',','')."</td>";
        echo "<td>".number_format($d_imp[$i][$j],2,',','')."</td>";
        echo "</tr>";
    }
}


?>
