<?php
/*
 * Creado el 22/01/2016 11:39:34
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_desc_extras_act_save
 */

require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$fecha=$glo->getGETPOST("fecha");
$importe=$glo->getGETPOST("importe");
$idper=$glo->getGETPOST("idper");
if($importe=="")
    $importe=0;
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Extras de Empleados",$usr->getId(),"Ingresa Extras de Empleados: $fecha | $importe | $idper",$centrosel);
    $ssql="insert into adm_extras (fecha, importe, idper) values ";
    $ssql.="('$fecha', $importe, $idper)";
    $conx->getConsulta($ssql);
} else {
    $aud->regAud("Extras de Empleados",$usr->getId(),"Modifica Extras de Empleados: $fecha | $importe | $idper",$centrosel);
    $ssql="update adm_extras set fecha='$fecha', importe=$importe, idper=$idper where id=$id";
    $conx->getConsulta($ssql);
}
//echo $ssql."<br>";
?>
<html>
<body>
<form name="form1" id="form1" action="adm_extras_main.php" method="post">
</form>
<script languaje="javascript">
document.form1.submit()
</script>
</body>
</html>
