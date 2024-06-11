<?php
/*
 * Creado el 23/05/2019 18:35:17
 * Autor: gus
 * Archivo: register_prvp.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$id=$glo->getGETPOST("id");
$ordenprvp=$glo->getGETPOST("ordenprvp");
$soloprecioprvp=$glo->getGETPOST("soloprecioprvp");
$rubroprvp=$glo->getGETPOST("rubroprvp");
$_SESSION["ordenprvp"]=$ordenprvp;
$_SESSION["rubroprvp"]=$rubroprvp;
$_SESSION["soloprecioprvp"]=$soloprecioprvp;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_prv_pre_main.php" method="post">
        <input name="id" id="id" type="hidden" value="<?= $id?>" />
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


