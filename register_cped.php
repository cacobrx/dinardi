<?php
/*
 * Creado el 13/03/2019 14:33:39
 * Autor: gus
 * Archivo: register_cped.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainicped=$glo->getGETPOST("fechainicped");
$fechafincped=$glo->getGETPOST("fechafincped");
$detallecped=$glo->getGETPOST("detallecped");
$clientecped=$glo->getGETPOST("clientecped");
$limcped=$glo->getGETPOST("limcped");
if($limcped=="") $limcped=0;
$_SESSION["fechainicped"]=$fechainicped;
$_SESSION["fechafincped"]=$fechafincped;
$_SESSION["detallecped"]=$detallecped;
$_SESSION["clientecped"]=$clientecped;
$_SESSION["limcped"]=$limcped;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_cped_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
