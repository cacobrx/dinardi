<?php
/*
 * Creado el 13/03/2019 14:33:39
 * Autor: gus
 * Archivo: register_crem.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainicrem=$glo->getGETPOST("fechainicrem");
$fechafincrem=$glo->getGETPOST("fechafincrem");
$detallecrem=$glo->getGETPOST("detallecrem");
$clientecrem=$glo->getGETPOST("clientecrem");
$limcrem=$glo->getGETPOST("limcrem");
if($limcrem=="") $limcrem=0;
$_SESSION["fechainicrem"]=$fechainicrem;
$_SESSION["fechafincrem"]=$fechafincrem;
$_SESSION["detallecrem"]=$detallecrem;
$_SESSION["clientecrem"]=$clientecrem;
$_SESSION["limcrem"]=$limcrem;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_crem_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>
