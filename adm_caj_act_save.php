<?
/*
 * Creado el 06/01/2018 14:02:30
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_caj_act_save.php
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
$tipo=$glo->getGETPOST("tipo");
$monedapesos=$glo->getGETPOST("monedapesos");
if($monedapesos=="") $monedapesos=0;
if($tipo=="") $tipo=0;
$tarea=$glo->getGETPOST("tarea");
if($tarea=="A") {
    $aud->regAud("Caja",$usr->getId(),"Ingresa Caja: $nombre",$centrosel);
    $ssql="insert into adm_caj (centro, nombre, tipo, monedapesos) values ($centrosel, '$nombre', $tipo, $monedapesos)";
} else {
    $aud->regAud("Caja",$usr->getId(),"Modifica Caja: $nombre",$centrosel);
    $ssql="update adm_caj set nombre='$nombre', tipo=$tipo, monedapesos=$monedapesos where id=$id";
}
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_caj_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>
