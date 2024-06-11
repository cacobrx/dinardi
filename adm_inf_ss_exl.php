<?
//print_r($_POST);
require "user.php";
require_once "clases/globalson.php";
require_once "clases/planb_config.php";
require_once 'clases/adm_contable.php';
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($fechaini=="")
    $fechaini=date("Y-m-01");
if($fechafin=="")
    $fechafin=date("Y-m-d");
$primero=$glo->getGETPOST("primero");
if($primero==1) {
    $adm=new sumasysaldos($centrosel, $fechaini, $fechafin);
    $a_cta=$adm->getCodigo();
    $a_nom=$adm->getNombre();
    $a_deb=$adm->getDebitos();
    $a_cre=$adm->getCreditos();
    $a_let=$adm->getLetra();
    $a_esp=$adm->getEspacios();
    $a_sal=$adm->getSaldo();
}

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sumasysaldos.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Cuestas</th> ";
echo "<th>Debitos</th> ";
echo "<th>Creditos</th> ";
echo "<th>Saldos</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_esp);$i++) {

  echo "<tr>";
  echo "<td>".$a_esp[$i].$a_esp[$i].$a_cta[$i]." ".$a_nom[$i]."</td>";
  echo "<td>".number_format($a_deb[$i],2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($a_cre[$i],2,$cfg->getPuntodecimal(),"")."</td>";
  echo "<td>".number_format($a_sal[$i],2,$cfg->getPuntodecimal(),"")."</td>";
  echo "</tr>";
}