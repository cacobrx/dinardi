<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/adm_cta.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';

$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$ssql="select * from adm_cta where centro=$centrosel";
if($textocta!="") 
    $ssql.=" and (instr(upper(nombre),'".strtoupper($textocta)."')>0 or instr(codigo,'$textocta')>0)";
$ssql.=" order by codigo";
//echo $ssql."<br>";
$cta=new adm_cta_2($ssql);
$a_id=$cta->getId();
$a_nom=$cta->getNombre();
$a_tip=$cta->getTipodes();
$a_cod=$cta->getCodigo();
$a_del=$cta->getOkborrar();
$cantidadtotal=$cta->getMaxRegistros();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=plancuentas.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Codigo</th> ";
echo "<th>Nombre</th> ";
echo "<th>Tipo</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {

  echo "<tr>";
  echo "<td>".$a_cod[$i]."</td>";
  echo "<td>".utf8_decode($a_nom[$i])."</td>";
  echo "<td>".$a_tip[$i]."</td>";
  echo "</tr>";
}