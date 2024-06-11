<?php
/*
 * Creado el 19/05/2018 12:24:59
 * Autor: gus
 * Archivo: register_exp.php
 * planbsistemas.com.ar
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
$glo=new globalson();
$fechainiexp=$glo->getGETPOST("fechainiexp");
$fechafinexp=$glo->getGETPOST("fechafinexp");
$detalleexp=$glo->getGETPOST("detalleexp");
$limexp=$glo->getGETPOST("limexp");
if($limexp=="")
    $limexp=0;
$_SESSION["fechainiexp"]=$fechainiexp;
$_SESSION["fechafinexp"]=$fechafinexp;
$_SESSION["detalleexp"]=$detalleexp;
$_SESSION["limexp"]=$limexp;
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_rem_exp_main.php" method="post">
</form>
<script language="javascript">
document.form1.submit()
</script>
</body>
</html>


