<?php
/*
 * creado el 18 ago. 2023 19:00:13
 * Usuario: gus
 * Archivo: adm_rem_det_exp
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'impresion/paisproductos.php';
require_once 'clases/adm_rem.php';
require_once 'clases/seleccion.php';
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$ssql="select adm_rem_det.*, adm_rem.fecha, adm_prv.paises, adm_rem.certificado from adm_rem_det inner join adm_rem on adm_rem_det.idrem=adm_rem.id inner join adm_prv on adm_rem.idprv=adm_prv.id";
$ssql.=" where adm_rem.fecha>='$fechainiinf' and adm_rem.fecha<='$fechafininf'";
if($paisinf>0) $ssql.=" and instr(adm_prv.paises,'|".$paisinf."|')>0";
$a_art=explode("|",$articulosselinf);
$condicionart="";
for($i=0;$i<count($a_art);$i++) {
    if($a_art[$i]!="")
        $condicionart.="adm_rem_det.idart=".$a_art[$i]." or ";
}
if($condicionart!="") $condicionart=" and (".substr($condicionart,0,strlen($condicionart)-4).")";
$ssql.=$condicionart;
$pais="TODOS";
if($paisinf>0) {
    $pais=$conx->getTextoValor($paisinf, "PAI");
}
//echo $ssql."<br>";

$adm=new adm_rem_det($ssql);
$a_idart=$adm->getIdart();
$a_art=$adm->getArticulo();
$a_pai=$adm->getPais();
$a_fec=$adm->getFecha();
$a_cer=$adm->getCertificado();
$a_kil=$adm->getKilos();

    
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=trazabilidad.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border=1> ";
echo "<tr> ";
echo "<th>Fecha</th> ";
echo "<th>Certificado</th> ";
echo "<th>Articulo</th> ";
echo "<th>Pais</th> ";
echo "<th>Kilos</th>";
echo "</tr> ";  
for($i=0;$i<count($a_art);$i++) {
        echo "<tr>";
        echo "<td>".$dsup->getFechaNormalCorta($a_fec[$i])."</td>";
        echo "<td>".$a_cer[$i]."</td>";
        echo "<td>".utf8_encode($a_art[$i])."</td>";  
        echo "<td>".utf8_encode($a_pai[$i])."</td>";
        echo "<td>".number_format($a_kil[$i],2,",","")."</td>";
        echo "</tr>";    
}

