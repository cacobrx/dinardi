<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'informes/informe5.php';
require_once 'impresion/pdf_eco.php';

$mesesa=array("ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");
$conx=new conexion();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$primero=$glo->getGETPOST("primero");
$ceroseco=$glo->getGETPOST("ceroseco");

$conn=$conx->conectarBase();
$ssql="select * from est_informe5 where iduser=".$usr->getId();
if($ceroseco!=1) {
    $ssql.=" and (total!=0 or total01!=0 or total02!=0 or total03!=0 or total04!=0 or total05!=0 or total06!=0";
    $ssql.=" or total07!=0 or total08!=0 or total08!=0 or total10!=0 or total11!=0 or total12!=0)";
}

$ssql.=" order by codigo";
$rs=$conx->consultaBase($ssql, $conn);
$r1=$conx->consultaBase($ssql, $conn);
$ttotal=array(0,0,0,0,0,0,0,0,0,0,0,0);     
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=cuentaeconomica.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Cuentas</th> ";
echo "<th>Totales</th> ";
echo "<th>ENE</th> ";
echo "<th>FEB</th> ";
echo "<th>MAR</th> ";
echo "<th>ABR</th> ";
echo "<th>MAY</th> ";
echo "<th>JUN</th> ";
echo "<th>JUL</th> ";
echo "<th>AGO</th> ";
echo "<th>SEP</th> ";
echo "<th>OCT</th> ";
echo "<th>NOV</th> ";
echo "<th>DIC</th> ";
echo "</tr> ";  
while($reg1=mysqli_fetch_object($r1)) { 

  echo "<tr>";
  echo "<td>".utf8_decode($reg1->descripcion)."</td>";
  echo "<td>".number_format($reg1->total,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total01,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total02,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total03,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total04,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total05,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total06,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total07,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total08,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total09,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total10,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total11,2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($reg1->total12,2,$cfg->getPuntodecimal(),"")."</td>";
    $ttotal[0]+=$reg1->total01;
    $ttotal[1]+=$reg1->total02;
    $ttotal[2]+=$reg1->total03;
    $ttotal[3]+=$reg1->total04;
    $ttotal[4]+=$reg1->total05;
    $ttotal[5]+=$reg1->total06;
    $ttotal[6]+=$reg1->total07;
    $ttotal[7]+=$reg1->total08;
    $ttotal[8]+=$reg1->total09;
    $ttotal[9]+=$reg1->total10;
    $ttotal[10]+=$reg1->total11;
    $ttotal[11]+=$reg1->total12;  

  echo "</tr>";
}
 

