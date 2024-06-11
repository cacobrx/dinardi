<?php
/*
 * creado el 18 ago. 2023 18:06:29
 * Usuario: gus
 * Archivo: register_inf
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainiinf=$glo->getGETPOST("fechainiinf");
$fechafininf=$glo->getGETPOST("fechafininf");
$paisinf=$glo->getGETPOST("paisinf");

$_SESSION["fechainiinf"]=$fechainiinf;
$_SESSION["fechafininf"]=$fechafininf;
$_SESSION["paisinf"]=$paisinf;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_rem_det_main.php" method="post">
    </form>
    <script language="javascript">
    document.form1.submit()
    </script>
</body>
</html>
