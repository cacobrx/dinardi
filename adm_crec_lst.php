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
require_once 'clases/adm_rec1.php';
require_once 'clases/pdf_crec_lst.php';
require_once 'clases/conexion.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$lim=$glo->getGETPOST("lim");
$hoy=date("Y-m-d");


$stot="select sum(adm_rec2.importe) as totalimporte from adm_rec2, adm_rec1 where (adm_rec1.fecha between '$fechainicrec' and '$fechafincrec') and adm_rec1.id=adm_rec2.idrec and adm_rec1.centro=$centrosel";
$ssql="select * from adm_rec1 where (fecha between '$fechainicrec' and '$fechafincrec') and adm_rec1.centro=$centrosel";
if($textocrec!="") {
    $ntex=strlen($campo);
    $stot.=" and instr(cliente,'$campo')>0";
    $ssql.=" and instr(cliente,'$campo')>0";
}

if($clientecrec>0) {
    $ssql.=" and idcli=$clientecrec";
    $stot.=" and idcli=$clientecrec";
}

$ssql.=" order by fecha";
//echo $ssql."<br>";
//echo $stot."<br>";
if($conx->getCantidadReg($stot)>0) {
    $rs=$conx->getConsulta($stot);

    $rre=mysqli_fetch_object($rs);
    $total=$rre->totalimporte;
} else
    $total=0;   
//$total=0;
//echo $ssql."<br>";
$rec=new adm_rec1_2($ssql);
$a_id=$rec->getId();
$a_fec=$rec->getFecha();
$a_cli=$rec->getCliente();
$a_imp=$rec->getImporte();
$a_con=$rec->getConcepto();
$cartel="Recibos desde ".date("d/m/Y", strtotime($fechainicrec))." hasta ".date("d/m/Y", strtotime($fechafincrec));
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
$pdf=new pdf_crec_lst("P", "mm", "A4");
$pdf->AddPage();
$cartel="Listado de Recibos";
$pdf->addDetalle();
$pdf->Output();
?>
