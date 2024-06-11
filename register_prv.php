<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_prv.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$textoprv=$glo->getGETPOST("textoprv");
$tipoprv=$glo->getGETPOST("tipoprv");
$ordenprv=$glo->getGETPOST("ordenprv");
$limprv=$glo->getGETPOST("limprv");
if($limprv=="")
    $limprv=0;
$_SESSION["textoprv"]=$textoprv;
$_SESSION["tipoprv"]=$tipoprv;
$_SESSION["ordenprv"]=$ordenprv;
$_SESSION["limprv"]=$limprv;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_prv_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


