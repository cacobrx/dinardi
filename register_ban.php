<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_art.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$limban=$glo->getGETPOST("limban");
if($limban=="")
    $limart=0;
$_SESSION["limart"]=$limart;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_ban_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


