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
$fecha=$glo->getGETPOST("fecha");
$ptovta=$glo->getGETPOST("ptovta");
$numero=$glo->getGETPOST("numero");
$exportador=$glo->getGETPOST("exportador");
$buque=$glo->getGETPOST("buque");
$destino=$glo->getGETPOST("destino");
$remitente=$glo->getGETPOST("remitente");
$nro=$glo->getGETPOST("nro");
$precinto=$glo->getGETPOST("precinto");
$procedencia=$glo->getGETPOST("procedencia");
$giro=$glo->getGETPOST("giro");
$contenedor=$glo->getGETPOST("contenedor");
$agenciapre=$glo->getGETPOST("agenciapre");
$transportista=$glo->getGETPOST("transportista");
$balanza=$glo->getGETPOST("balanza");
$cuit=$glo->getGETPOST("cuit");
$certificado=$glo->getGETPOST("certificado");
$serie=$glo->getGETPOST("serie");
$fiscal=$glo->getGETPOST("fiscal");
$nro2=$glo->getGETPOST("nro2");
$patenteca=$glo->getGETPOST("patenteca");
$cantidaddet=$glo->getGETPOST("cantidaddet");
$tarea=$glo->getGETPOST("tarea");
if($numero=="") $numero=0;
if($ptovta=="") $ptovta=0;
if($nro=="") $nro=0;
//if($agenciapre=="") $agenciapre=0;
if($nro2=="") $nro2=0;
$conn=$conx->conectarBase();
$aud->regAud("Remitos de Expotación",$usr->getId(),"Ingresa Remitos de Expotación:  $exportador",$centrosel);
$ssql="insert into adm_rem_exp (centro, fecha, exportador, buque, destino, remitente, nro, precinto, procedencia, giro, contenedor, agenciapre, transportista, balanza, cuit, certificado, serie, fiscal, nro2, patenteca, ptovta, numero) values (";
$ssql.="$centrosel, '$fecha', '$exportador', '$buque', '$destino', '$remitente', '$nro', '$precinto', '$procedencia', '$giro', '$contenedor', '$agenciapre', '$transportista', '$balanza', '$cuit', '$certificado', '$serie', '$fiscal', $nro2, '$patenteca', $ptovta, $numero)";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$id=$conx->getLastId("adm_rem_exp", $conn);
$ssql="delete from adm_rem_exp_det where idrem=$id";
$conx->getConsulta($ssql);

for($i=0;$i<=$cantidaddet;$i++) {
    $item_cantidad="item_cantidad$i";
    $item_descripcion="item_descripcion$i";
    $item_kgsb="item_kgsb$i";
    $item_kgsn="item_kgsn$i";
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
    $$item_descripcion=$glo->getGETPOST($item_descripcion);
    $$item_kgsb=$glo->getGETPOST($item_kgsb);
    $$item_kgsn=$glo->getGETPOST($item_kgsn);    
    $ssql="insert into adm_rem_exp_det (centro, cantidad, descripcion, kgsbrutos, kgsnetos, idrem) values (";
    $ssql.=$centrosel.", ".$$item_cantidad.", '".$$item_descripcion."', ".$$item_kgsb.", ".$$item_kgsn.", $id)";
//    echo $ssql."<br>";
    $conx->getConsulta($ssql);
}
?>
<html>
<body>
<form name="form1" id="form1" action="adm_rem_exp_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
