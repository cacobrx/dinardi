<?
/*
 * Creado el 14/07/2020 12:40:40
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_per_act_save.php
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
$periodo=$glo->getGETPOST("periodo");
$tarea=$glo->getGETPOST("tarea");
$xano=$glo->getGETPOST("xano");
$xmes=$glo->getGETPOST("xmes");
if($tarea=="A") {
    $aud->regAud("Periodos",$usr->getId(),"Ingresa Periodos: \[$id]",$centrosel);
    $ssql="insert into adm_per (centro, periodo) values ($centrosel, '".$xano.$xmes."')";
} else {
    $aud->regAud("Periodos",$usr->getId(),"Modifica Periodos: [$id]",$centrosel);
    $ssql="update adm_per set periodo='$xano$xmes' where id=$id";
}
//echo $ssql;
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_per_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
