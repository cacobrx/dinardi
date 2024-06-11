<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_band.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_band where fecha>='$fechainiband' and fecha<='$fechafinband'"; 
if($proveedorband>0)
    $ssql.=" and idprv=$proveedorband";
$ssql.=" order by fecha limit $limband,".$cfg->getLimmax();

$adm=new adm_band_2($ssql);
    
$a_id=$adm->getId();
$a_art=$adm->getArticulo();
$a_fec=$adm->getFecha();
$a_prv=$adm->getProveedor();
$a_hie=$adm->getHielodes();
$a_tem=$adm->getTemperatura();
$a_tun=$adm->getTunel();
$a_cnn=$adm->getControldes();
$a_con=$adm->getContaminantedes();
$a_kgr=$adm->getKgrechazo();
$a_kg=$adm->getKg();



header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=bandejas.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Fecha</th> ";
echo "<th>Articulo</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Temperatura</th> ";
echo "<th>Hielo</th> ";
echo "<th>Control org</th> ";
echo "<th>Contaminantes</th> ";
echo "<th>Kg Rechazo</th> ";
echo "<th>Kg</th> ";

echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {

        
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";  
        echo "<td>".$a_art[$i]."</td>";
        echo "<td>".$a_prv[$i]."</td>";
        echo "<td>".$a_tem[$i]."</td>";

        echo "<td>".$a_hie[$i]."</td>";  
        echo "<td>".$a_cnn[$i]."</td>";
        echo "<td>".$a_con[$i]."</td>";
        echo "<td>".$a_kgr[$i]."</td>";        
        echo "<td>".$a_kg[$i]."</td>";        
    
        echo "</tr>";    
}