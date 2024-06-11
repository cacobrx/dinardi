<?
/*
 * Creado el 05/06/2020 14:54:24
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_band_act_save.php
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
$idart=$glo->getGETPOST("idart");
$fecha=$glo->getGETPOST("fecha");
$idprv=$glo->getGETPOST("idprv");
$kg=$glo->getGETPOST("kg");
$hielo=$glo->getGETPOST("hielo");
$temperatura=$glo->getGETPOST("temperatura");
$tunel=$glo->getGETPOST("tunel");
$control=$glo->getGETPOST("control");
$contaminante=$glo->getGETPOST("contaminante");
$kgrechazo=$glo->getGETPOST("kgrechazo");
$tarea=$glo->getGETPOST("tarea");
if($control=="") $control=0;
if($contaminante=="") $contaminante=0;
if($hielo=="") $hielo=0;
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Bandejas",$usr->getId(),"Ingresa Bandejas: \[]",$centrosel);
    $ssql="insert into adm_band (idart, fecha, idprv, hielo, temperatura, tunel, control, contaminante, kgrechazo, kg) values ($idart, '".$fecha."', $idprv, $hielo, $temperatura, $tunel, $control, $contaminante, $kgrechazo, $kg)";
} else {
    $aud->regAud("Bandejas",$usr->getId(),"Modifica Bandejas: []",$centrosel);
    $ssql="update adm_band set idart=$idart, fecha='$fecha', idprv=$idprv, hielo=$hielo, temperatura=$temperatura, tunel=$tunel, control=$control, contaminante=$contaminante, kgrechazo=$kgrechazo, kg=$kg where id=$id";
}
//echo $ssql;
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_band_main.php" method="post">
        </form>
        <script languaje="javascript">
          document.form1.submit()
        </script>
    </body>
</html>
