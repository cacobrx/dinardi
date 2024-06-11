<?php
/*
 * creado el 24/11/2017 09:51:57
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: register_may
 */

session_start();
//print_r($_POST);
require_once 'clases/globalson.php';
require_once 'clases/adm_cta.php';
require_once 'clases/conexion.php';
$glo=new globalson();
$conx=new conexion();
$fechainimay=$glo->getGETPOST("fechainimay");
$fechafinmay=$glo->getGETPOST("fechafinmay");
$idctamay=$glo->getGETPOST("idctamay");
$primero=$glo->getGETPOST("primero");
$conn=$conx->conectarBase();
//if($idctamay!="") $idctamay=substr($idctamay,0,strlen($idctamay)-1);
$xcta=explode("|",$idctamay);
$cuentasmay="";
for($i=0;$i<count($xcta);$i++) {
    if($xcta[$i]>0) {
        $cta=new adm_cta_1($xcta[$i], $conn);
        $cuentasmay.=$cta->getNombre()." (".$cta->getCodigo().") - ";
    }
}

$_SESSION["fechainimay"]=$fechainimay;
$_SESSION["fechafinmay"]=$fechafinmay;
$_SESSION["cuentasmay"]=$cuentasmay;
$_SESSION["idctamay"]=$idctamay;
//print_r($_SESSION);
?>
<html>
<body>
    <form name="form1" id="form1" action="adm_inf_mayor.php" method="post">
        <input name="primero" id="primero" type="hidden" value="<?= $primero?>" />
    </form>
    <script language="javascript">
    document.form1.submit()
    </script>
</body>
</html>
