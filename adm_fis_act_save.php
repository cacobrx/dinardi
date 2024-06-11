<?
/*
 * Creado el 14/05/2014 14:52:58
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_fis_act_save.php
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);

$id=$glo->getGETPOST("id");
$idcli=$glo->getGETPOST("idcli");
$totaltotal=$glo->getGETPOST("totaltotal");
$tipo=$glo->getGETPOST("tipo");
$letra=$glo->getGETPOST("letra");
$ptovta=$glo->getGETPOST("ptovta");
$numero=$glo->getGETPOST("numero");
$fecha=$glo->getGETPOST("fecha");
$tipopago=$glo->getGETPOST("tipopago");
$docreferencia=$glo->getGETPOST("docreferencia");
$cantd=$glo->getGETPOST("cantd");
$importepago=$glo->getGETPOST("importepago");
$numerocae=$glo->getGETPOST("numerocae");
$fechacae=$glo->getGETPOST("fechacae");
$fechaperini=$glo->getGETPOST("fechaperini");
$fechaperfin=$glo->getGETPOST("fechaperfin");
$fechapago=$glo->getGETPOST("fechapago");
$idped=$glo->getGETPOST("idped");
$totaltotal=$glo->getGETPOST("totaltotal");
$percepcioniibb=$glo->getGETPOST("percepcioniibb");
$porcentajeiibb=$glo->getGETPOST("porcentajeiibb");
$nogravado=$glo->getGETPOST("nogravado");
$netocf21=$glo->getGETPOST("netocf21");
$netocf10=$glo->getGETPOST("netocf10");
$netori21=$glo->getGETPOST("netori21");
$netori10=$glo->getGETPOST("netori10");
$ivacf21=$glo->getGETPOST("ivacf21");
$ivacf10=$glo->getGETPOST("ivacf10");
$ivari21=$glo->getGETPOST("ivari21");
$ivari10=$glo->getGETPOST("ivari10");
if($totaltotal=="") $totaltotal=0;
if($netocf10=="") $netocf10=0;
if($netocf21=="") $netocf21=0;
if($netori10=="") $netori10=0;
if($netori21=="") $netori21=0;
if($ivacf10=="") $ivacf10=0;
if($ivacf21=="") $ivacf21=0;
if($ivari10=="") $ivari10=0;
if($ivari21=="") $ivari21=0;
if($nogravado=="") $nogravado=0;
if($porcentajeiibb=="") $porcentajeiibb=0;
if($percepcioniibb=="") $percepcioniibb=0;
if($idped=="") $idped=0;
if($docreferencia=="")
    $docreferencia=0;
if($tipopago=="")
    $tipopago=0;
if($importepago=="") $importepago=0;
if($numero=="") $numero=0;
$tarea=$glo->getGETPOST("tarea");
if($totaltotal=="")
    $totaltotal=0;
if($tarea=="A") {
    $aud->regAud("Comprobantes",$usr->getId(),"Ingresa Comprobante:  $tipo $letra $ptovta $numero $idcli",$centrosel);
    $ssql="insert into adm_fis (centro, idcli, fecha, tipo, letra, ptovta, numero, tipopago, docreferencia, numerocae, idped, total, percepcioniibb, netocf21, netocf10, netori21, netori10, ivacf21, ivacf10, ivari21, ivari10, porcetajeiibb, fechapago, imortepago, nogravado) values (";
    $ssql.="$centrosel, $idcli, '$fecha', '$tipo', '$letra', $ptovta, $numero, $tipopago, $docreferencia, '$numerocae', $idped, $totaltotal, $percepcioniibb, $netocf21, $netocf10, $netori21, $netori10, $ivacf21, $ivacf10, $ivari21, $ivari10, $porcentajeiibb, '$fechapago', $importepago, $nogravado)";
} else {
    $aud->regAud("Comprobantes",$usr->getId(),"Modifica Comprobante: $tipo $letra $ptovta $numero $idcli",$centrosel);
    $ssql="update adm_fis set idcli=$idcli, fecha='$fecha', tipo='$tipo', letra='$letra', ptovta=$ptovta, numero=$numero, docreferencia=$docreferencia, tipopago=$tipopago, numerocae='$numerocae', idped=$idped, total=$totaltotal, percepcioniibb=$percepcioniibb, netocf21=$netocf21, netocf10=$netocf10, netori21=$netori21, netori10=$netori10, ivacf21=$ivacf21, ivacf10=$ivacf10, ivari21=$ivari21, ivari10=$ivari10, porcentajeiibb=$porcentajeiibb, importepago=$importepago, nogravado=$nogravado, fechamod='".date("Y-m-d H:m:s")."' where id=$id";
        
}
//echo $ssql."<br>";
$conx->getConsulta($ssql);
if($tarea=="A") {
    $idfis=$conx->getLastId("adm_fis");
} else {
    $idfis=$id;
    $ssql="delete from adm_fis_det where idfis=$idfis";
    $conx->getConsulta($ssql);
}
if($fechacae!="") {
    $ssql="update adm_fis set fechacae='$fechacae' where id=$idfis";
    $conx->getConsulta($ssql);
}
if($fechaperfin!="") {
    $ssql="update adm_fis set fechaperini='$fechaperini' where id=$idfis";
    $conx->getConsulta($ssql);
}
if($fechaperfin!="") {
    $ssql="update adm_fis set fechaperfin='$fechaperfin' where id=$idfis";
    $conx->getConsulta($ssql);
}
if($fechapago!="")
    $ssql="update adm_fis set fechapago='$fechapago' where id=$idfis";
else
    $ssql="update adm_fis set fechapago=NULL where id=$idfis";
$conx->getConsulta($ssql);

$tot=0;

for($i=0;$i<$cantd;$i++) {
    $det_cantidad="det_cantidad$i";
    $det_detalle="det_detalle$i";
    $det_precio="det_precio$i";
    $det_total="det_total$i";
    $det_alicuota="det_alicuota$i";
    $$det_cantidad=$glo->getGETPOST($det_cantidad);
    $$det_detalle=$glo->getGETPOST($det_detalle);
    $$det_precio=$glo->getGETPOST($det_precio);
    $$det_alicuota=$glo->getGETPOST($det_alicuota);
    $ssql="insert into adm_fis_det (centro, cantidad, detalle, precio, idfis, alicuota) values (";
    $ssql.=$centrosel.", ".$$det_cantidad.", '".$$det_detalle."', ".$$det_precio.", $idfis, ".$$det_alicuota.")";
//    echo $ssql."<br>";
    $conx->getConsulta($ssql);
    $tot+=$$det_precio*$$det_cantidad;
}

?>
<html>
<body>
<form name="form1" id="form1" action="adm_fis_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
