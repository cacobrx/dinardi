<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_rem_exp.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select * from adm_rem_exp where fecha>='$fechainiexp' and fecha<='$fechafinexp' order by id limit $limexp,".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_rem_exp_2($ssql);
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_exp=$adm->getExportador();
$a_des=$adm->getDestino();
$a_rem=$adm->getRemitente();
$d_can=$adm->getCantidad();
$d_des=$adm->getDescripcion();
$d_kgsb=$adm->getKgsbrutos();
$d_kgsn=$adm->getKgsneto();
$a_nro=$adm->getNumero();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=remexportacion.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Nro</th> ";
echo "<th>Fecha</th> ";
echo "<th>Exportador</th> ";
echo "<th>Destino</th> ";
echo "<th>Remitente</th>";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_nro[$i]."</td>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
        echo "<td>".utf8_encode($a_exp[$i])."</td>";  
        echo "<td>".utf8_encode($a_des[$i])."</td>";
        echo "<td>".utf8_encode($a_rem[$i])."</td>";
        echo "</tr>";    
}