<?
/*
 * Creado el 24/07/2020 14:59:35
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_asistencias_act_save.php
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
$idper=$glo->getGETPOST("idper");
$fecha=$glo->getGETPOST("fecha");
$cantidad=$glo->getGETPOST("cantidad");
$tarea=$glo->getGETPOST("tarea");
$tipohora=$glo->getGETPOST("tipohora");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Asistencias",$usr->getId(),"Ingresa Asistencias: \[$idper]",$centrosel);
    $ssql="insert into adm_asistencias (idper, fecha, cantidad, tipohora) values ($idper, '".$fecha."', $cantidad, $tipohora)";
} else {
    $aud->regAud("Asistencias",$usr->getId(),"Modifica Asistencias: [$idper]",$centrosel);
    $ssql="update adm_asistencias set idper=$idper, fecha='$fecha', cantidad=$cantidad, tipohora=$tipohora where id=$id";    
}
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_asistencias_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
