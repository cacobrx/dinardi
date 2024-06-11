<?php
/*
 * Creado el 03/07/2019 19:18:24
 * Autor: gus
 * Archivo: register_clip.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$id=$glo->getGETPOST("id");
$ordenclip=$glo->getGETPOST("ordenclip");
$soloprecioclip=$glo->getGETPOST("soloprecioclip");
$rubroclip=$glo->getGETPOST("rubroclip");
$verpreciosclip=$glo->getGETPOST("verpreciosclip");
$_SESSION["ordenclip"]=$ordenclip;
$_SESSION["rubroclip"]=$rubroclip;
$_SESSION["soloprecioclip"]=$soloprecioclip;
$_SESSION["verpreciosclip"]=$verpreciosclip;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_cli_pre_main.php" method="post">
        <input name="id" id="id" type="hidden" value="<?= $id?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


