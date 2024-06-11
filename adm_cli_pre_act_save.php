<?php
/*
 * Creado el 21/01/2019 10:46:42
 * Autor: gus
 * Archivo: adm_cli_pre_act_save.php
 * planbsistemas.com.ar
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'clases/adm_art.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$usuario = $usr->getId();
$id = $glo->getGETPOST("id");
$idp = $glo->getGETPOST("idp");
$importe = $glo->getGETPOST("importe");
$alicuota=$glo->getGETPOST("alicuota");
$seleccionado=$glo->getGETPOST("seleccionado");
if($seleccionado=="") $seleccionado=0;
$cli=new adm_cli_1($id);
$art=new adm_art_1($idp);
if($importe=="") $importe=0;
if($alicuota=="") $alicuota=0;
$ssql="select * from adm_cli_pre where idcli=$id and idart=$idp";
if($conx->getCantidadReg($ssql)>0)
    $ssql="update adm_cli_pre set importe=$importe, alicuota=$alicuota, seleccionado=$seleccionado where idcli=$id and idart=$idp";
else
    $ssql="insert into adm_cli_pre (idcli, idart, importe, alicuota, seleccionado) values ($id, $idp, $importe, $alicuota, $seleccionado)";
$conx->getConsulta($ssql);
//echo $ssql."<br>";
$aud->regAud("Clientes Precios", $usr->getId(), "Modifica precio art: ".$art->getDescripcion()." - Cli: ".$cli->getApellido(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cli_pre_main.php" method="post">
            <input name="id" id="id" type="hidden" value="<?= $id ?>" />
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>