<?
/*
 * Creado el 13/11/2020 14:54:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_oin_act_save.php
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
$detalle=$glo->getGETPOST("detalle");
$importe=$glo->getGETPOST("importe");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Otros Ingresos",$usr->getId(),"Ingresa Otros Ingresos: $fecha | $detalle | $importe",$centrosel);
    $ssql="insert into adm_oin (fecha, detalle, importe) values ('".$fecha."', '$detalle', $importe)";
} else {
    $aud->regAud("Otros Ingresos",$usr->getId(),"Modifica Otros Ingresos: $fecha | $detalle | $importe",$centrosel);
    $ssql="update adm_oin set fecha='$fecha', detalle='$detalle', importe=$importe where id=$id";
}
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_oin_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
