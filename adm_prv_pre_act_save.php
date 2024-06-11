<?php
/*
 * Creado el 21/01/2019 10:46:42
 * Autor: gus
 * Archivo: adm_prv_pre_act_save.php
 * planbsistemas.com.ar
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
require_once 'clases/adm_art.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$usuario = $usr->getId();
$id = $glo->getGETPOST("id");
$idp = $glo->getGETPOST("idp");
$importe = $glo->getGETPOST("importe");
$preciominimo=$glo->getGETPOST("preciominimo");
$preciomaximo=$glo->getGETPOST("preciomaximo");
$alicuota=$glo->getGETPOST("alicuota");
$seleccionado=$glo->getGETPOST("seleccionado");
if($seleccionado=="") $seleccionado=0;
$prv=new adm_prv_1($id);
$art=new adm_art_1($idp);
if($importe=="") $importe=0;
if($preciominimo=="") $preciominimo=$importe;
if($preciomaximo=="") $preciomaximo=$importe;
if($alicuota=="") $alicuota=0;
$ssql="select * from adm_prv_pre where idprv=$id and idart=$idp";
if($conx->getCantidadReg($ssql)>0)
    $ssql="update adm_prv_pre set importe=$importe, preciominimo=$preciominimo, preciomaximo=$preciomaximo, alicuota=$alicuota, seleccionado=$seleccionado where idprv=$id and idart=$idp";
else
    $ssql="insert into adm_prv_pre (idprv, idart, importe, preciominimo, preciomaximo, alicuota, seleccionado) values ($id, $idp, $importe, $preciominimo, $preciomaximo, $alicuota, $seleccionado)";
$conx->getConsulta($ssql);
//echo $ssql."<br>";
$aud->regAud("Proveedores Precios", $usr->getId(), "Modifica precio art: ".$art->getDescripcion()." - Prv: ".$prv->getApellido(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_prv_pre_main.php" method="post">
            <input name="id" id="id" type="hidden" value="<?= $id ?>" />
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>