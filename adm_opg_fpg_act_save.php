<?php
/*
 * Creado el 09/11/2018 14:51:15
 * Autor: gus
 * Archivo: adm_opg_fpg_act_save.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_opg1.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$usuario = $usr->getId();
$id = $glo->getGETPOST("id");
$idop=$glo->getGETPOST("idop");
$detalle = $glo->getGETPOST("detalle");
$importe = $glo->getGETPOST("importe");
$tipo=$glo->getGETPOST("tipo");
$tarea=$glo->getGETPOST("tarea");
$tt= explode("|", $tipo);
$idcht=$tt[1];
$tipo=0;
if($tt[0]!="t") { 
    $tipo=$tt[1];
    $idcht=0;
}
if ($tarea == "A") {
    $aud->regAud("O.PAGO - DETALLE DE PAGOS", $usr->getId(), "Ingresa Detalle de Pago: $detalle | $importe | $tipo", $centrosel);
    $ssql = "insert into adm_opg2 (centro, detalle, importe, tipopago, idcht, idop) values ($centrosel, '$detalle', $importe, ".$tt[1].", $idcht, $idop)";
} else {
    $aud->regAud("O.PAGO - DETALLE DE PAGOS", $usr->getId(), "Modifica Detalle de Pago: $detalle | $importe | $tipo", $centrosel);
    $ssql = "update adm_opg2 set detalle='$detalle', importe=$importe, tipopago=".$tt[1].", idcht=$idcht, fechamod='" . date("Y-m-d H:i:s") . "' where id=$id";
}
$conx->getConsulta($ssql);
//echo $ssql."<br>";
if($idcht>0 and $tarea=="A") {
    $opg1=new adm_opg1_1($idop);
    $ssql="update adm_cht set entregado='".$opg1->getProveedor()."' where id=$idcht";
    $conx->getConsulta($ssql);
}
//echo $ssql;
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_det.php" method="post">
            <input name="idop" id="idop" type="hidden" value="<?= $idop ?>" />
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
