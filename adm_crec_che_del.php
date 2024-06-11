<?php
/*
 * Creado el 22/08/2019 11:51:49
 * Autor: gus
 * Archivo: adm_crec_che_del.php
 * planbsistemas.com.ar
 */

require("user.php");
require_once("clases/conexion.php");
require_once("clases/globalson.php");
require_once("clases/auditoria.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'clases/adm_che.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$canti=$glo->getGETPOST("canti");
$cantc=$glo->getGETPOST("cantc");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$cantf=$glo->getGETPOST("cantf");
$fecha=$glo->getGETPOST("fecha");
$idcli=$glo->getGETPOST("idcli");
$idcht=$glo->getGETPOST("idcht");
$concepto=$glo->getGETPOST("concepto");
$urlmain=$glo->getGETPOST("urlmain");
$url=$glo->getGETPOST("url");
$importe=$glo->getGETPOST("importe");
for($i=0;$i<$canti;$i++) {
    $detallepago="detallepago$i";
    $detalle="detalle$i";
    $importedet="importedet$i";
    $$detallepago=$glo->getGETPOST($detallepago);
    $$detalle=$glo->getGETPOST($detalle);
    $$importedet=$glo->getGETPOST($importedet);
}
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$cht=new tmp_che_1($idcht);
//$cli=new adm_cli_1($idcli);
//$cliente=$cli->getApellido()." ".$cli->getNombre();
$aud->regAud("ADM Cheques Terceros",$usr->getId(),"Elimina cheque: ".$cht->getNrocheque()." (".$cht->getNrocheque()." (".$cht->getImporte().")",$centrosel);
$ssql="delete from tmp_che where id=$idcht";
$conx->getConsulta($ssql);
//$che_idcht=$conx->getLastId("adm_cht");
//echo $ssql."<br>";
?>
<html>
<body>
<form name="form1" id="form1" action="adm_crec_act.php" method="post">
<input name="fechaini" id="fechaini" type="hidden" value="<?= $fechaini?>" />
<input name="fechafin" id="fechafin" type="hidden" value="<?= $fechafin?>" />
<input name="idcli" id="idcli" type="hidden" value="<?= $idcli?>" />
<input name="fecha" id="fecha" type="hidden" value="<?= $fecha?>" />
<input name="canti" id="canti" type="hidden" value="<?= $canti?>" />
<input name="concepto" id="concepto" type="hidden" value="<?= $concepto?>" />
<input name="importe" id="importe" type="hidden" value="<?= $importe?>" />
<input name="tarea" id="tarea" type="hidden" value="<?= $tarea?>" />
<input name="primero" id="primero" type="hidden" value="1" />
<input name="urlmain" id="urlmain" type="hidden" value="<?= $urlmain?>" />
<input name="url" id="url" type="hidden" value="<?= $url?>" />
<?
for($i=0;$i<$canti;$i++) {
    $detallepago="detallepago$i";
    $detalle="detalle$i";
    $importedet="importedet$i";
    $chequepro="chequepro$i";
    $$detallepago=$glo->getGETPOST($detallepago);
    $$detalle=$glo->getGETPOST($detalle);
    $$importedet=$glo->getGETPOST($importedet); 
    $$chequepro=$glo->getGETPOST($chequepro);
    ?>
<input name="detallepago<?= $i?>" id="detallepago<?= $i?>" type="hidden" value="<?= $$detallepago?>" />
<input name="detalle<?= $i?>" id="detalle<?= $i?>" type="hidden" value="<?= $$detalle?>" />
<input name="importedet<?= $i?>" id="importedet<?= $i?>" type="hidden" value="<?= $$importedet?>" />
<input name="chequepro<?= $i?>" id="chequepro<?= $i?>" type="hidden" value="<?= $$chequepro?>" />
<?} ?>
</form>
<script languaje="javascript">
  document.form1.submit()
</script>
</body>
</html>
