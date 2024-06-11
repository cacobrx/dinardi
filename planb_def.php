<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$conx=new conexion();
$meses=array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$numeromeses=array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
$anos=array();
$hoy=date("Y-m-d");
$ini=date("Y", strtotime("$hoy + 3 years"));
$fin=date("Y", strtotime("$hoy - 3 years"));
for($a=$ini; $a>$fin; $a=$a-1) {
    array_push($anos, $a);
}
$def_letras=array("A","B","C","X");
$def_comprobantes=array("Factura", "N/Credito", "N/Debito", "Recibo");
$def_comprobantes_cod=array(1,2,3,4);
$clientesnocontar="";
$clientesreales="";


//if($clientesreales!="")
    //$clientesreales=substr($clientesreales,0,strlen($clientesreales)-5);
//$clientesnocontar="adm_cli.estado!=7 and adm_cli.estado!=10 and adm_cli.estado!=20 and adm_cli.estado!=3 and adm_cli.estado!=5 and adm_cli.estado!=6";
?>
