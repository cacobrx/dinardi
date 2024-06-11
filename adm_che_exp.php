<?php
/*
 * Creado el 07/04/2019 21:06:42
 * Autor: gus
 * Archivo: adm_che_exp.php
 * planbsistemas.com.ar
 */

require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_che.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_che.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
$hoy=date("Y-m-d");
if($tipofechache==1)
    $campofecha="fechapago";
else
    $campofecha="fechaorigen";

$condicion="";
switch($filtroche) {
case 1:
    $condicion.="$campofecha>='$fechainiche' and $campofecha<='$fechafinche' and fechadeb is not null and ";
    break;
case 2:
    $condicion.="$campofecha>='$fechainiche' and $campofecha<='$fechafinche' and ";
    break;
default:
    $condicion.="fechadeb is null and ";
    break;
}
if($campoche!="")
    $condicion.="(instr(nrocheque,'$campoche')>0 or instr(upper(destinatario), '".strtoupper($campoche)."')>0 or instr(upper(referencia), '".strtoupper($campoche)."')>0) and ";
if($tipoche>0)
    $condicion.="tipo=$tipoche and ";
if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$stot="select sum(importe) as totalimporte from adm_che $condicion";
$ssql="select * from adm_che $condicion";

$rs=$conx->getConsulta($stot);
$rre=mysqli_fetch_object($rs);
$total=$rre->totalimporte;
//echo $ssql."<br>";
$che=new adm_che_2($ssql);
$a_id=$che->getId();
$a_fori=$che->getFechaorigen();
$a_fven=$che->getFechapago();
$a_ban=$che->getBancodes();
$a_nro=$che->getNrocheque();
$a_des=$che->getDestinatario();
$a_acr=$che->getAcreditado();
$a_imp=$che->getImporte();
$a_fed=$che->getFechadeb();
$a_ref=$che->getReferencia();

$cantidadtotal=$che->getMaxRegistros();
//
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=chequespropios.xls");
header("Pragma: no-cache");
header("Expires: 0"); 


echo "<table border='1'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>F.Origen</th>";
echo "<th>F.Vencimiento</th>";
echo "<th>F.Debito</th>";
echo "<th>Banco</th>";
echo "<th>Nro.Cheque</th>";
echo "<th>Destinatario</th>";
echo "<th>Referencia</th>";
echo "<th>Importe</th>";
echo "</tr>";
for($i=0;$i<count($a_id);$i++) {
    echo "<tr>";
    echo "<td>".$a_id[$i]."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fori[$i])."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fven[$i])."</td>";
    echo "<td>".$dsup->getFechaNormalCorta($a_fed[$i])."</td>";
    echo "<td>".$a_ban[$i]."</td>";
    echo "<td>".$a_nro[$i]."</td>";
    echo "<td>".$a_des[$i]."</td>";
    echo "<td>".$a_ref[$i]."</td>";
    echo "<td>".number_format($a_imp[$i],2,$cfg->getPuntodecimal(),"")."</td>";
    echo "</tr>";
}
echo "</table>";

?>
