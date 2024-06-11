<?
/*
 * Creado el 07/07/2020 13:24:37
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_gas_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_gas.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'clases/adm_com_det.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select adm_gas.* from adm_gas inner join adm_com_det on adm_gas.id=adm_com_det.idgas where adm_gas.fecha>='$fechainigas' and adm_gas.fecha<='$fechafingas'";
$condicion="";
if($idprvgas>0) $condicion.="adm_gas.idprv=$idprvgas and ";
if($descriptor1gas>0)
    $condicion.="adm_com_det.descriptor1=$descriptor1gas and ";
if($descriptor2gas>0)
    $condicion.="adm_com_det.descriptor2=$descriptor2gas and ";
if($descriptor3gas>0)
    $condicion.="adm_com_det.descriptor3=$descriptor3gas and ";
if($descriptor4gas>0)
    $condicion.="adm_com_det.descriptor4=$descriptor4gas and ";

if($condicion!="") $condicion=" and ".substr($condicion,0,strlen($condicion)-5);

$ssql.="$condicion order by adm_gas.fecha, adm_gas.id";
$adm=new adm_gas_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_pro=$adm->getProveedor();
$a_det=$adm->getDet_detalle();
$a_imp=$adm->getImporte();
$a_fecv=$adm->getFechaven();
$d_id=$adm->getDet_id();
$d_des1=$adm->getDet_descriptor1des();
$d_des2=$adm->getDet_descriptor2des();
$d_des3=$adm->getDet_descriptor3des();
$d_des4=$adm->getDet_descriptor4des();
$a_cerrado=$adm->getCerrado();
$a_fecp=$adm->getFechapago();
$a_num=$adm->getNumero();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=gastos.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>Nro.</th> ";
echo "<th>Fecha</th> ";
echo "<th>Proveedor</th> ";
echo "<th>Descriptores</th> ";
echo "<th>Importe</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {
        echo "<tr>";
        echo "<td>".$a_id[$i]."</td>";
        echo "<td>".$a_num[$i]."</td>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";  
        echo "<td>".$a_pro[$i]."</td>";
        for($d=0;$d<count($d_id[$i]);$d++) {
            echo "<td>".$d_des1[$i][$d]."/ ".$d_des2[$i][$d]."/ ".$d_des3[$i][$d]."/ ".$d_des4[$i][$d]."</td>";
        }        
        echo "<td>".$a_imp[$i]."</td>";
        echo "</tr>";    
}