<?php
/*
 * Creado el 22/11/2018 13:09:13
 * Autor: gus
 * Archivo: adm_cht_img_del.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_cht.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$totalimporte = $glo->getGETPOST("totalimporte");
$idche = $glo->getGETPOST("idche");
$adm = new adm_cht_1($idche);
$foto=$glo->getGETPOST("foto");
if($foto==1) $ima=$adm->getImafrente ();
if($foto==2) $ima=$adm->getImareverso ();
if(file_exists($ima)) unlink ($ima);
$aud->regAud("CHEQUE IMAGEN", $usr->getId(), "Elimina imagen cheque ". $adm->getBancodes()." #".$adm->getNrocheque()." ".$adm->getId(), $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cht_img.php" method="post">
            <input name="idche" id="idche" type="hidden" value="<?= $idche?>" />
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
