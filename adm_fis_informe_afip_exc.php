<?php
/*
 * Creado el 18/03/2016 21:38:16
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_informe_afip_exc
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
require_once 'planb_def.php';
require_once 'afip.php';
require_once 'clases/pdf_imprime.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$primerogen=$glo->getGETPOST("primerogen");
$numeroini=$glo->getGETPOST("numeroini");
$numerofin=$glo->getGETPOST("numerofin");
$TipoComp=$glo->getGETPOST("TipoComp");

$a_CbteFch=array();
$a_ImpNeto=array();
$a_ImpTotal=array();
$a_ImpIVA=array();

$adm=new informe_Afip($cfg->getFiscalpuntoventa(), $fechaini, $fechafin, $TipoComp, $cfg->getFiscalcuit());
$a_CbteFch=$adm->getCbteFch();
$a_DocTipo=$adm->getDocTipo();
$a_DocNro=$adm->getDocNro();
$a_CbteDesde=$adm->getCbteDesde();
$a_ImpTotal=$adm->getImpTotal();
$a_ImpNeto=$adm->getImpNeto();
$a_ImpIVA=$adm->getImpIVA();
$a_Resultado=$adm->getResultado();
$a_CodAutorizacion=$adm->getCodAutorizacion();
$a_EmisionTipo=$adm->getEmisionTipo();
$a_FchVto=$adm->getFchVto();
$a_FchProceso=$adm->getFchProceso();
$a_PtoVta=$adm->getPtoVta();
$a_CbteTipo=$adm->getCbteTipo();
$nombreemp=$cen->getNombre();
$telefonoemp=$cen->getTelefono();
$a_cliente=$adm->getCliente();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=afip.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Numero</th> ";
echo "<th>Numero CAE</th> ";
echo "<th>Venc. CAE</th> ";
echo "<th>Fec. Proceso</th> ";
echo "<th>Cliente</th>";
echo "<th>Total</th> ";
echo "</tr> ";  



for ($i=0;$i<count($a_CbteFch);$i++) {
    echo "<tr>";
    echo "<td>".substr($a_CbteFch[$i],6,2)."/".substr($a_CbteFch[$i],4,2)."/".substr($a_CbteFch[$i],0,4)."</td>";
    echo "<td>".$a_CbteDesde[$i]."</td>";
    echo "<td>".$a_CodAutorizacion[$i]."</td>";
    echo "<td>".substr($a_FchVto[$i],6,2)."/".substr($a_FchVto[$i],4,2)."/".substr($a_FchVto[$i],0,4)."</td>";
    echo "<td>".substr($a_FchProceso[$i],6,2)."/".substr($a_FchProceso[$i],4,2)."/".substr($a_FchProceso[$i],0,4)." ".substr($a_FchProceso[$i],8,2).":".substr($a_FchProceso[$i],10,2).":".substr($a_FchProceso[$i],10,2)."</td>";
    echo "<td>".$a_cliente[$i]."</td>";
    echo "<td>".number_format($a_ImpTotal[$i],2,',','')."</td>";
    echo "</tr>";
}
echo "<tr> ";
echo "<td></td> ";
echo "<td></td> ";
echo "<td></td> ";
echo "<td></td> ";
echo "<td></td> ";
echo "<td>TOTAL</td> ";
echo "<td>".number_format(array_sum($a_ImpTotal),2,',','')."</td> ";
echo "</tr> ";  
print "Comprobantes en AFIP";
?>
