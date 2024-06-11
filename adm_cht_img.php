<?php
/*
 * Creado el 22/11/2018 10:55:16
 * Autor: gus
 * Archivo: adm_img_cht.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cht.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea = $glo->getGETPOST("tarea");
$idche = $glo->getGETPOST("idche");
require_once 'clases/adm_cht.php';
$botoncap = "Actualizar";
$adm = new adm_cht_1($idche);
$carteltarea = "IMÁGENES DEL CHEQUE ".$adm->getBancodes()." #".$adm->getNrocheque();
$imafrente=$adm->getImafrente();
$imareverso=$adm->getImareverso();
$versionfoto=$adm->getVersionfoto();
$aa=600;
if($imafrente!="") {
    $imag=getimagesize($imafrente);
    $x_width = $imag[0];
    $x_height = $imag[1];
    $ancho1=$aa;
    $alto1=$x_height*$aa/$x_width;
}
if($imareverso!="") {
    $imag=getimagesize($imareverso);
    $x_width = $imag[0];
    $x_height = $imag[1];
    $ancho2=$aa;
    $alto2=$x_height*$aa/$x_width;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $cfg->getTitulo() ?></title>
        <style type="text/css">
            <!--
            #barblue {
                position:absolute;
                left:0px;
                top:0px;
                width:100%;
                height:51px;
                z-index:1;
                background-color:<?= $cfg->getColor1() ?>;
            }
            #barcentral {
                position:absolute;
                left:50%;
                top:<?= $cfg->getAlturamarco() ?>px;
                width:960px;
                height:75px;
                z-index:1;
                margin-left: -480px;
            }

            -->
        </style>
        <link href="css.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="planb.js"></script>
        <script src="js/jquery-1.3.2.js" type="text/javascript"></script>
        <script src="js/vanadium.js" type="text/javascript"></script>
        <script language="javascript">
            var VanadiumRules = {
                nombre: ['required', 'only_on_submit']
            }
        </script>
        <? require_once 'estilos.php'; ?>

    </head>

    <body>
        <div class="style1" id="barblue">
            <blockquote>
                <p class="titulo1"><?= $cfg->getCabecera() ?></p>
            </blockquote>
        </div>
        <div id="barcentral">
            <form name="form1" id="form1" action="adm_cht_img_save.php" enctype="multipart/form-data" method="post">
                <tr>
                    <? include("adm_menu.php") ?>
                    <input name="idche" type="hidden" id="id" value="<?= $idche ?>" />
                    <input name="foto" type="hidden" id="foto" />
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                            <? require_once('displayusuario.php'); ?>
                            <tr>
                                <td>
                                    <div class="panel960 letra6">
                                        <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                            <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea ?></h3>                
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr>
                                                    <td colspan="2"><a href="javascript: document.form1.action='adm_cht_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                                </tr>                  
                                                <tr>
                                                    <td valign="top" align="right" width="20%">Imagen Frente&nbsp;</td>
                                                    <td width="80%" align="center">
                                                        <input name="file1" type="file" id="file1" /> 
                                                        <a href="javascript: document.form1.foto.value=1; document.form1.action='adm_cht_img_del.php'; document.form1.submit()"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Imagen Frente" title="Elimina Imagen Frente"></i></a>                                                         
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <? if($imafrente!="") { ?>
                                                        <img src="<?= $imafrente."?".$versionfoto?>" width="<?= $ancho1?>" height="<?= $alto1?>" />
                                                        <? } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><hr></hr></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" align="right" width="20%">Imagen Reverso&nbsp;</td>
                                                    <td width="80%" align="center">
                                                        <input name="file2" type="file" id="file2" /> 
                                                        <a href="javascript: document.form1.foto.value=2; document.form1.action='adm_cht_img_del.php'; document.form1.submit()"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Imagen Reverso" title="Elimina Imagen Reverso"></i></a>                                                         
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <? if($imareverso!="") { ?>
                                                        <img src="<?= $imareverso."?".$versionfoto?>" width="<?= $ancho2?>" height="<?= $alto2?>" />
                                                        <? } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><hr></hr></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <input type="submit" name="Submit" value="<?= $botoncap ?>" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </form>
        </div>
    </body>
</html>
