<?php
/*
 * Creado el 10/12/2019 16:01:52
 * Autor: gus
 * Archivo: adm_rem_vertotal.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_rem.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
//$limmax=5;

$ssql="select * from adm_rem where fecha>='$fechainirem' and fecha<='$fechafinrem'";
if($proveedorrem>0) $ssql.=" and idprv=$proveedorrem";
if($faenarem==1) $ssql.=" and faena=1";
if($sincomprasrem==1) $ssql.=" and idcom=0";
if($seleccionrem==1) $ssql.=" and seleccion=1";


$totaltodo=0;
$ottalkilos=0;
$adm=new adm_rem_2($ssql);
$ttt=$adm->getDet_total();
$kkk=$adm->getCrm_cantidad();
$totaltodo=0;
$totalkilos=0;
for($i=0;$i<count($ttt);$i++) {
    //print_r($ttt[$i]);
    $totaltodo+=array_sum($ttt[$i]);
    $totalkilos+=array_sum($kkk[$i]);
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_rem_main.php" method="post">
            <input name="totaltodo" id="totaltodo" type="hidden" value="<?= $totaltodo?>" />
            <input name="totalkilos" id="totalkilos" type="hidden" value="<?= $totalkilos?>" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

