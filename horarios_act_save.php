<?
/*
 * Creado el 29/05/2017 13:46:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_adelantos_act_save.php
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
$iddep=$glo->getGETPOST("iddep");
$idemp=$glo->getGETPOST("idemp");
$tarea=$glo->getGETPOST("tarea");
if($tarea=="A") {
    $aud->regAud("Horarios",$usr->getId(),"Ingresa Horarios: $idemp | $iddep",$centrosel);
    $ssql="insert into horarios (fecha, idemp, iddep, fechaaplica) values ('".$fecha."', $idemp, $iddep, '".$fechaimp."')";
} else {
    $aud->regAud("Horarios",$usr->getId(),"Modifica Horarios: $idemp | $iddep",$centrosel);
    $ssql="update horarios set fecha='".$fecha."', idemp=$idemp, iddep=$iddep, fechaaplica='$fechaimp' where id=$id";
}
//echo $ssql;
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="horarios_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
