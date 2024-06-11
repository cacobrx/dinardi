<?php
/*
 * creado el 10/11/2017 15:27:11
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_vta_conf_main_save
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$conn=$conx->conectarBase();
$tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Percepción IVA", "Percepción IIBB", "Cuenta Corriente");
$tipocuenta=$glo->getGETPOST("tipocuenta");
for($i=1;$i<count($tipos);$i++) {
    $idcta="idcta$i";
    $$idcta=$glo->getGETPOST($idcta);
    if($$idcta=="") $$idcta=0;
    $ssql="select * from adm_vta_conf where idtipo=$i";
    if($conx->getCantidadRegA($ssql, $conn)==0)
        $ssql="insert into adm_vta_conf (centro, idcta, idtipo, tipocuenta) values ($centrosel, ".$$idcta.", $tipocuenta, $i)";
    else
        $ssql="update adm_vta_conf set idcta=".$$idcta.", tipocuenta=$tipocuenta,  where idtipo=$i";
    $conx->consultaBase($ssql, $conn);
//    echo $ssql."<br>";
}
$aud->regAud("VENTAS", $usr->getId(), "Configuración Ventas", $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_vta_conf_main.php" method="post">

        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
