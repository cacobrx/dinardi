<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_cped_main.php
 * planbsistemas.com.ar
 */


require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_ela.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_ela where fecha>='$fechainiela' and fecha<='$fechafinela'";
$ssql.=" order by fecha";
$adm=new adm_ela_2($ssql);
    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_hin=$adm->getHoraing();
$a_heg=$adm->getHoraegr();
$a_emp=$adm->getEmpleados();
$a_prv=$adm->getDet_proveedor();
$a_art=$adm->getDet_articulo();
$a_fin=$adm->getDet_fechaing();
$a_kgd=$adm->getDet_kgdescarte();
$a_kgf=$adm->getDet_kilos();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=elaboracion.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Fecha</th> ";
echo "<th>Hora ingreso</th> ";
echo "<th>Hora Egreso</th> ";
echo "<th>Empleados</th> ";

echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";  
        echo "<td>".$a_hin[$i]."</td>";
        echo "<td>".$a_heg[$i]."</td>";
        echo "<td>".$a_emp[$i]."</td>";        
    
        echo "</tr>";    
}
?>