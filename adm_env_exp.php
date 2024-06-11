<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_env.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_env where fechaing>='$fechainienv' and fechaing<='$fechafinenv'"; 
if($proveedorenv>0)
    $ssql.=" and (idprv=$proveedorenv or idprv1=$proveedorenv or idprv2=$proveedorenv)";
if($articuloenv>0)
    $ssql.=" and idart=$articuloenv";
if($tunelenv!="") $ssql.=" and tunel=$tunelenv";

$ssql.=" order by fechaing";
//echo $ssql;
$adm=new adm_env_2($ssql);
    
$a_id=$adm->getId();
$a_art=$adm->getArticulo();
$a_t3=$adm->getTenvasado3();
$a_fec=$adm->getFechaing();
$a_prv=$adm->getProveedor();
$a_prv1=$adm->getProveedor1();
$a_prv2=$adm->getProveedor2();
$a_kgd=$adm->getKgdescarte();
$a_lot=$adm->getLote();
$a_can=$adm->getCantidad();
$a_kil=$adm->getKilos();
$a_tun=$adm->getTunel();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=envasado.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Fecha</th> ";
echo "<th>Articulo</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Temp Envasado</th> ";
echo "<th>Kg Descarte</th> ";
echo "<th>Lote</th> ";
echo "<th>Cantidad</th> ";
echo "<th>Kilos</th> ";
echo "<th>Tunel</th> ";

echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
    echo "<tr>";
    echo "<td>".$a_id[$i]."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";  
    echo "<td>".$a_art[$i]."</td>";
    echo "<td>".$a_prv[$i]."</td>";
    echo "<td>".$a_prv1[$i]."</td>";
    echo "<td>".$a_prv2[$i]."</td>";
    echo "<td>".$a_t3[$i]."</td>";        
    echo "<td>".number_format($a_kgd[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "<td>".$a_lot[$i]."</td>";
    echo "<td>".number_format($a_can[$i],0,$cfg->getPuntodecimal(),"")."</td>";        
    echo "<td>".numbet_format($a_kil[$i],2,$cfg->getPuntodecimal(),"")."</td>";        
    echo "<td>".$a_tun[$i]."</td>";        

    echo "</tr>";    
}
