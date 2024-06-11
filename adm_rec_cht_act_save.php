<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'user.php';
//print_r($_POST);
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';

$dsup=new datesupport();
$sup=new support();
$glo=new globalson();
$conx=new conexion();
$fecha=$glo->getGETPOST("fecha");
$idcli=$glo->getGETPOST("idcli");
$canti=$glo->getGETPOST("canti");
$cantc=$glo->getGETPOST("cantc");
$cantf=$glo->getGETPOST("cantf");
$tarea=$glo->getGETPOST("tarea");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$idrec=$glo->getGETPOST("idrec");
$concepto=$glo->getGETPOST("concepto");
$importe=$glo->getGETPOST("importe");
$primero=$glo->getGETPOST("primero");
$cantf=$glo->getGETPOST("cantf");
$cli=new adm_cli_1($idcli);
$che_fechaorigen=$glo->getGETPOST("che_fechaorigen");
$che_fechaven=$glo->getGETPOST("che_fechaven");
$che_importe=$glo->getGETPOST("che_importe");
$che_nrocheque=$glo->getGETPOST("che_nrocheque");
$che_banco=$glo->getGETPOST("che_banco");
$che_nombre=$glo->getGETPOST("che_nombre");
$canti++;
$che_cliente=$cli->getApellido();
$usuario=$usr->getId();
$ssql="insert into tmp_cht (centro, idbanco, nrocheque, fechaorigen, fechapago, importe, nombre, cliente, idcli, usuario, tipo) values ";
$ssql.="($centrosel, $che_banco, '$che_nrocheque', '$che_fechaorigen', '$che_fechaven'";
$ssql.=", $che_importe, '$che_nombre', '$che_cliente', $idcli, $usuario, 0)";

//echo $ssql."<br>";
$conx->getConsulta($ssql);


?>

<html>
    <body>
        <form name="form1" id="form1" action="adm_crec_act.php" method="post">
           <input name="fechaini" id="fechaini" type="hidden" value="<?= $fechaini?>" />
           <input name="fechafin" id="fechaini" type="hidden" value="<?= $fechafin?>" />
           <input name="lim" id="lim" type="hidden" value="<?= $lim?>" />
           <input name="primero" id="primero" type="hidden" value="<?= $primero?>" />

           <input name="fecha" id="fecha" type="hidden" value="<?= $fecha?>" />
           <input name="idcli" id="idcli" type="hidden" value="<?= $idcli?>" />
           <input name="canti" id="canti" type="hidden" value="<?= $canti?>" />
           <input name="cantc" id="cantc" type="hidden" value="<?= $cantc?>" />
           <input name="cantf" id="cantf" type="hidden" value="<?= $cantf?>" />
           <input name="tarea" id="tarea" type="hidden" value="<?= $tarea?>" />
           <input name="idrec" id="idop" type="hidden" value="<?= $idrec?>" />
           <input name="tipocontabilidad" id="tipocontabilidad" type="hidden" value="<?= $tipocontabilidad?>" />
           
           <input name="concepto" id="concepto" type="hidden" value="<?= $concepto?>" />
           <input name="importe" id="importe" type="hidden" value="<?= $importe?>" />
           <? for($i=0;$i<$canti;$i++) { 
                $detallemov="detalle$i";
                $importedet="importedet$i";
                $chequeter="chequeter$i";
                $$detallemov=$glo->getGETPOST($detallemov);
                $$importedet=$glo->getGETPOST($importedet);
                $$chequeter=$glo->getGETPOST($chequeter);
                ?>
           <input name="detallemov<?= $i?>" id="detallemov<?= $i?>" type="hidden" value="<?= $$detallemov?>" />
           <input name="importedet<?= $i?>" id="importedet<?= $i?>" type="hidden" value="<?= $$importedet?>" />
           <input name="chequeter<?= $i?>" id="chequeter<?= $i?>" type="hidden" value="<?= $$chequeter?>" />
           <? } 
            for($i=0;$i<$cantf;$i++) {
                $idcom="idcom$i";
                $pagar="pagar$i";
                $$idcom=$glo->getGETPOST($idcom);
                $$pagar=$glo->getGETPOST($pagar);
           ?>
           <input name="idcom<?= $i?>" id="idcom<?= $i?>" type="hidden" value="<?= $$idcom?>" />
           <input name="pagar<?= $i?>" id="pagar<?= $i?>" type="hidden" value="<?= $$pagar?>" />

           <? } 
            for($i=0;$i<$cantc;$i++) {
                $cuenta="cuenta$i";
                $entrada="entrada$i";
                $salida="salida$i";
                $detallecon="detallecon$i";
                $$cuenta=$glo->getGETPOST($cuenta);
                $$entrada=$glo->getGETPOST($entrada);
                $$salida=$glo->getGETPOST($salida);
                $$detallecon=$glo->getGETPOST($detallecon);
                
           ?>
           <input name="cuenta<?= $i?>" id="cuenta<?= $i?>" type="hidden" value="<?= $$cuenta?>" />
           <input name="entrada<?= $i?>" id="entrada<?= $i?>" type="hidden" value="<?= $$entrada?>" />
           <input name="salida<?= $i?>" id="salida<?= $i?>" type="hidden" value="<?= $$salida?>" />
           <input name="detallecon<?= $i?>" id="detallecon<?= $i?>" type="hidden" value="<?= $$detallecon?>" />
           <? } ?>
        </form>
        <script language="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

