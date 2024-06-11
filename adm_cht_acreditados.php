<?php
/*
 * creado el 7 ene. 2022 12:08:37
 * Usuario: gus
 * Archivo: adm_cht_acreditados
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_cht.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$conn=$conx->conectarBase();
$cantidadact=$glo->getGETPOST("cantidadact");
for($i=0;$i<$cantidadact;$i++) {
    $chek="chek$i";
    $$chek=$glo->getGETPOST($chek);
    if($$chek>0) {
        $ccc=new adm_cht_1($$chek, $conn);
        $ssql="update adm_cht set fechaacr=fechapago where (entregado='' or entregado is null) and id=".$$chek;
//        echo $ssql."<br>";
        $conx->consultaBase($ssql, $conn);
        $aud->regAudC("Cheques Terceros", $usr->getId(),"Acreditado cheque #".$$chek." | Cheque: ".$ccc->getNrocheque(),$centrosel,$conn);
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cht_main.php" method="post">
        </form>
        <script language="javascript">
           document.form1.submit();
        </script>
    </body>
</html>

