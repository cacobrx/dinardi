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
$textoart=$glo->getGETPOST("textoart");
$ordenart=$glo->getGETPOST("ordenart");
$rubroart=$glo->getGETPOST("rubroart");
$limart=$glo->getGETPOST("limart");
if($limart=="")
    $limart=0;
$_SESSION["textoart"]=$textoart;
$_SESSION["ordenart"]=$ordenart;
$_SESSION["rubroart"]=$rubroart;
$_SESSION["limart"]=$limart;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_art_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


