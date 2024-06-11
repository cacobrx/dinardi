<?
/*
 * Creado el 26/05/2017 15:34:36
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_empleados_act_save.php
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
$centro=$glo->getGETPOST("centro");
$nombre=$glo->getGETPOST("nombre");
$apellido=$glo->getGETPOST("apellido");
$documento=$glo->getGETPOST("documento");
$fechaingreso=$glo->getGETPOST("fechaingreso");
$importe=$glo->getGETPOST("importe");
$iddep=$glo->getGETPOST("iddep");
if($importe=="") $importe=0;

$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Empleados",$usr->getId(),"Ingresa Empleados: \[$nombre]",$centrosel);
    $ssql="insert into adm_empleados (centro, nombre, apellido, documento, fechaingreso, importe, iddep) values ($centrosel, '$nombre', '$apellido', $documento, '".$fechaingreso."', $importe, $iddep)";
} else {
    $aud->regAud("Empleados",$usr->getId(),"Modifica Empleados: [$nombre]",$centrosel);
    $ssql="update adm_empleados set nombre='$nombre', apellido='$apellido', documento=$documento, fechaingreso='".$fechaingreso."', importe=$importe, iddep=$iddep where id=$id";
}
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_empleados_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
