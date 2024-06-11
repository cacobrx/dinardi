<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$cantidad=$glo->getGETPOST("cantidaddet");
for($i=0;$i<=$cantidad;$i++) {
    $item_fecha="item_fecha$i";
    $item_producto="item_producto$i";
    $item_proveedor="item_proveedor$i";
    $item_temperatura="item_temperatura$i";
    $item_hielo="item_hielo$i";
    $item_tunel="item_tunel$i";
    $item_control="item_control$i";
    $item_contaminante="item_contaminante$i";
    $item_kilos="item_kilos$i";
    $item_descarte="item_descarte$i";

    $$item_fecha=$glo->getGETPOST($item_fecha);
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_proveedor=$glo->getGETPOST($item_proveedor);
    $$item_hielo=$glo->getGETPOST($item_hielo);
    $$item_temperatura=$glo->getGETPOST($item_temperatura);
    $$item_tunel=$glo->getGETPOST($item_tunel);
    $$item_control=$glo->getGETPOST($item_control);
    $$item_contaminante=$glo->getGETPOST($item_contaminante);
    $$item_kilos=$glo->getGETPOST($item_kilos);
    $$item_descarte=$glo->getGETPOST($item_descarte);
    if($$item_hielo=="") $$item_hielo=0;        
    if($$item_control=="") $$item_control=0;        
    if($$item_contaminante=="") $$item_contaminante=0;        
    if($$item_producto>0 and $$item_producto>0) {
        $ssql="insert into adm_band (fecha, idprv, idart, hielo, temperatura, tunel, control, contaminante, kg, kgrechazo) values (";
        $ssql.="'".$$item_fecha."', ".$$item_proveedor.", ".$$item_producto.", ".$$item_hielo.", ".$$item_temperatura.", ".$$item_tunel.", ".$$item_control.", ".$$item_contaminante.", ".$$item_kilos.", ".$$item_descarte.")";
//        echo $ssql."<br>";
        $conx->getConsulta($ssql);
    }
        
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_band_main.php" method="post">

        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>
