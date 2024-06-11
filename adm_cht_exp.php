<?
//session_start();
//print_r($_POST);
require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_cht.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_cht.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
if($limcht=="")
    $limcht=0;
if($chkfechacht=="" and $primerocht=="") {
    $chkfechacht=1;
    $primerocht=1;
}
$hoy=date("Y-m-d");
if($fechainicht=="")
    $fechainicht=date("Y-m-")."01";
if($fechafincht=="")
    $fechafincht=date("Y-m-d", strtotime("$hoy + 30 days"));
if($camposelcht=="")
    $camposelcht="id";
if($tipofechacht=="")
    $tipofechacht=1;
if($tipofechacht==1)
    $campofechacht="fechapago";
else
    $campofechacht="fechaorigen";


//$campofecha="id";
$campoorden="id";
//$ntex=strlen($campo);
$stot="select sum(importe) as totalimporte from adm_cht";
$ssql="select * from adm_cht";
$condicion="centro=$centrosel and ";
if($tipocht==1)
    $condicion.="tipo=1 and ";
if($tipocht==2)
    $condicion.="tipo=2 and ";
switch($filtrocht) {
    case 0: // en cartera
        $condicion.="(entregado='' or entregado is null) and fechaacr is null and ";
        break;
    case 1: // acreditados
        $condicion.="($campofechacht >='$fechainicht' and $campofechacht<='$fechafincht' and fechaacr is not null) and ";
        break;
    case 2: // entregados
        $condicion.="($campofechacht >='$fechainicht' and $campofechacht<='$fechafincht' and entregado!='') and ";
        break;
    case 3: // todos
        $condicion.="($campofechacht >='$fechainicht' and $campofechacht<='$fechafincht') and ";
        break;
}
if($campocht!="") {
    if($camposelcht=='id')
        $condicion.="$camposelcht=$campocht and ";
    else
        $condicion.="instr($camposelcht,'".$campocht."')>0 and ";
}
if($condicion!="") {
    $condicion=substr($condicion,0,strlen($condicion)-5);
    $ssql.=" where $condicion";
    $stot.=" where $condicion";
}
$ssql.=" order by $campoorden ";
$rs=$conx->getConsulta($stot);
//echo $stot."<br>";
$rre=mysqli_fetch_object($rs);
$total=$rre->totalimporte;
//echo $ssql."<br>";
$cht=new adm_cht_2($ssql);
$a_id=$cht->getId();
$a_fori=$cht->getFechaorigen();
$a_fven=$cht->getFechapago();
$a_ban=$cht->getBancodes();
$a_nro=$cht->getNrocheque();
$a_nom=$cht->getNombre();
$a_acr=$cht->getAcreditado();
$a_imp=$cht->getImporte();
$a_cli=$cht->getCliente();
$a_ent=$cht->getEntregado();
$a_dias=$cht->getDias();
$a_fea=$cht->getFechaacr();
$cantidadtotal=$cht->getMaxRegistros();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=chequesterceros.xls");
header("Pragma: no-cache");
header("Expires: 0"); 

echo "<table border=1> ";
echo "<tr> ";
echo "<th>ID</th> ";
echo "<th>F.Origen</th> ";
echo "<th>F.Vencimiento</th> ";
echo "<th>Dias</th> ";
echo "<th>Banco</th> ";
echo "<th>Nro.Cheque</th> ";
echo "<th>Nombre</th> ";
echo "<th>Cliente</th> ";
echo "<th>Entregado</th> ";
echo "<th>Fecha Acr.</th> ";
echo "<th>Importe</th> ";
echo "</tr> ";  
for($i=0;$i<count($a_id);$i++) {

  echo "<tr>";
  echo "<td>".$a_id[$i]."</td>";
  echo "<td>".$dsup->getFechaNormalCorta($a_fori[$i])."</td>";
  echo "<td>".$dsup->getFechaNormalCorta($a_fven[$i])."</td>";
  echo "<td>".$a_dias[$i]."</td>";
  echo "<td>".utf8_decode($a_ban[$i])."</td>";
  echo "<td>".$a_nro[$i]."</td>";
  echo "<td>".$a_nom[$i]."</td>";
  echo "<td>".$a_cli[$i]."</td>";
  echo "<td>".$a_ent[$i]."</td>";
  echo "<td>";
  if($a_fea[$i]!="") echo $dsup->getFechaNormalCorta ($a_fea[$i]);
  echo "</td>";
  echo "<td>".number_format($a_imp[$i],2,$cfg->getPuntodecimal(),"")."</td>";
  echo "</tr>";
}