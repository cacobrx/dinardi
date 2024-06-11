<?php
/*
 * Creado el 14/04/2020 21:54:31
 * Autor: gus
 * Archivo: adm_opg_retg_mod_save.php
 * planbsistemas.com.ar
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$idop=$glo->getGETPOST("idop");
$numeroretg=$glo->getGETPOST("numeroretg");
$retencionfinal=$glo->getGETPOST("retencionfinal");
$retencioniibb=$glo->getGETPOST("retencioniibb");
if($numeroretg=="") $numeroretg=0;
if($retencionfinal=="") $retencionfinal=0;
$ssql="update adm_opg1 set retencionganancia=$retencionfinal, numeroretg=$numeroretg where id=$idop";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$aud->regAud("OPAGO AJUSTE RETENCIÓN", $usr->getId(), "Ajusta retenciones OP #$idop | Importe: $retencioniibb / $retencionfinal", $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_retg_mod.php" method="post">
            <input name="idop" id="idop" type="hidden" value="<?= $idop?>" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

