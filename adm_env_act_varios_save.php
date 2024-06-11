<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$conn=$conx->conectarBase();
$cantidad=$glo->getGETPOST("cantidaddet");
$clave=$glo->getGETPOST("clave");
for($i=0;$i<=$cantidad;$i++) {
    $item_fecha="item_fecha$i";
    $item_producto="item_producto$i";
    $item_proveedor="item_proveedor$i";
    $item_tenvasado="item_tenvasado$i";
    $item_kgdescarte="item_kgdescarte$i";
    $item_lote="item_lote$i";
    $item_cajas="item_cajas$i";
    $item_kilos="item_kilos$i";
    $item_tunel="item_tunel$i";
    $$item_fecha=$glo->getGETPOST($item_fecha);
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_proveedor=$glo->getGETPOST($item_proveedor);
    $$item_tenvasado=$glo->getGETPOST($item_tenvasado);
    $$item_kgdescarte=$glo->getGETPOST($item_kgdescarte);
    $$item_lote=$glo->getGETPOST($item_lote);
    $$item_cajas=$glo->getGETPOST($item_cajas);
    $$item_kilos=$glo->getGETPOST($item_kilos);
    $$item_tunel=$glo->getGETPOST($item_tunel);
    if($$item_tenvasado=="") $$item_tenvasado=0;
    if($$item_kgdescarte=="") $$item_kgdescarte=0;
    if($$item_lote=="") $$item_lote=0;
    if($$item_cajas=="") $$item_cajas=0;
    if($$item_kilos=="") $$item_kilos=0;
    if($$item_tunel=="") $$item_tunel=0;
    if($$item_proveedor=="") $$item_proveedor=0;
    if($$item_producto>0) {
        $ssql="select * from adm_env where idart=".$$item_producto." and idprv=".$$item_proveedor." and kilos=".$$item_kilos." and cantidad=".$$item_cajas." and lote=".$$item_lote." and tunel=".$$item_tunel." and clave='$clave'";
//        echo $ssql."<br>";
        if($conx->getCantidadRegA($ssql, $conn)==0) {
            $ssql="insert into adm_env (fechaing, idprv, idart, tenvasado3, kgdescarte, lote, cantidad, kilos, tunel, clave) values (";
            $ssql.="'".$$item_fecha."', ".$$item_proveedor.", ".$$item_producto.", ".$$item_tenvasado.", ".$$item_kgdescarte.", ".$$item_lote.", ".$$item_cajas.", ".$$item_kilos.", ".$$item_tunel.", '$clave')";
    //        echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);
        }
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_env_main.php" method="post">

        </form>
        <script language="javascript">
         document.form1.submit();
        </script>
    </body>
</html>
