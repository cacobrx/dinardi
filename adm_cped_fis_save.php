<?php
/*
 * Creado el 01/02/2019 11:02:53
 * Autor: gus
 * Archivo: adm_ser_fis_save.php
 * planbsistemas.com.ar
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'afip.php';
require_once 'clases/adm_cli.php';
require_once 'clases/adm_cped.php';
require_once 'clases/adm_cuo.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$cfg=new planb_config_1($centrosel);
$cpedid=$glo->getGETPOST("cpedid");
$id=$glo->getGETPOST("id");
$cped=new adm_cped_1($cped);
$cli=new adm_cli_1($cped->getIdcli());
//$cuo=new adm_cuo_1($id);
//$totaltotal=$cuo->getImporte();
$TipoComp="F";
$hoy=date("Y-m-d");
$conn=$conx->conectarBase();
$ssql="insert into adm_fis (fecha, idcli, tipo, ptovta, numero, total, centro, letra, idcped) values (";
$ssql.="'$hoy', ".$cped->getIdcli().", '$TipoComp', ".$cfg->getFiscalpuntoventa().", 0, $totaltotal, 1, 'C', $cpedid)";
$conx->consultaBase($ssql, $conn);
//echo $ssql."<br>";
$idfis=$conx->getLastId("adm_fis");

$detalle=$ser->getServicio()." MES ".substr($cuo->getFechaven(),5,2)."/".substr($cuo->getFechaven(),0,4);

$ssql="insert into adm_fis_det (centro, cantidad, detalle, precio, alicuota, idfis) values (";
$ssql.="1, 1, '$detalle', ".$cuo->getImporte().", 21, $idfis)";
//echo $ssql."<br>";
$conx->consultaBase($ssql, $conn);

?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_ser_det.php" method="post">
            <input name="serid" id="serid" type="hidden" value="<?= $serid?>" />
        </form>
        <script language="javascript">
            document.form1.submit()
        </script>
    </body>
</html>