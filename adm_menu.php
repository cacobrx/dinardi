<? require_once 'estilos.php';
$dir="doc";
$seperador=";";
$rep=opendir($dir);
$docs=array();
while($arc=readdir($rep)) {
    if($arc!=".." and $arc!="." and $arc!="") 
        array_push($docs,$arc);
}
closedir($rep);
clearstatcache();
?>
<link rel="stylesheet" href="fontawesome/css/all.css" crossorigin="anonymous"><td width="594" height="30" colspan="2">
<td width="100%" height="30">
    <ul id="menu">
    <!-- <li class="ui-state-disabled"><a href="#">Aberdeen</a></li> -->
        <li><a href="#">Compras</a>
            <ul>
                <? if($usr->getNivel()<=1) { ?>
                <li><a href="adm_art_main.php">Productos</a></li>
                <? } ?>
                <li><a href="adm_prv_main.php">Proveedores</a></li>
                <? if($usr->getNivel()<=1) { ?>
                <li><a href="adm_rem_main.php">Remitos de Entrada</a></li>
                <li><a href="adm_crm_main.php">Control de Faena</a></li>
                <!--<li><a href="adm_fae_main.php">Control de Faena</a></li>-->
                <? } ?>
                <li><a href="adm_com_main.php">Compras</a></li>
                <li><a href="adm_opg_main.php">Órdenes de Pago</a></li>
                <li><a href="adm_prv_ctacte.php">Cuenta Corrientes</a></li>
                <li><a href="adm_prv_saldos.php">Saldos</a></li>
            </ul>
        </li>

        <li><a href="#">Ventas</a>
            <ul>
                <? if($usr->getNivel()<=1) { ?>
                <li><a href="adm_prd_main.php">Artículos</a></li>
                <? } ?>
                <li><a href="adm_cli_main.php">Clientes</a></li>
                <? if($usr->getNivel()<=1) { ?>
                <li><a href="adm_cped_main.php">Pedidos</a></li>        
                <li><a href="adm_crem_main.php">Remitos</a></li>        
                <? } ?>
                <li><a href="adm_crec_main.php">Recibos</a></li>        
                <li><a href="adm_cli_ctacte.php">Cuentas Corrientes</a></li>        
                <li><a href="adm_cli_saldos.php">Saldos</a></li>        
                <li><a href="adm_oin_main.php">Otros Ingresos</a></li>        
                <li><a href="adm_rem_exp_main.php">Remitos de Expotación</a></li>
                <li><a href="adm_planilla_colores.php">Planilla de Ubicación</a></li>
            </ul>
        </li>
        <li><a href="#">Administracion</a>
            <ul>
                <li><a href="adm_fis_main.php">Comprobantes Fiscales</a></li>
                <?if($usr->getNivel()<=1) { ?>
                <li><a href="adm_cht_main.php">Cheques Terceros</a></li>
                <li><a href="adm_che_main.php">Cheques Propios</a></li>
                <? } ?>
                <li><a href="adm_com_var_main.php">Compras Proveedores Varios</a></li>  
                <li><a href="adm_gas_main.php">Gastos</a></li>  
                <?if($usr->getNivel()<=1) { ?>
                <li><a href="adm_mov_caja_main.php">Movimientos de Caja</a></li>        
                <li><a href="adm_clasif_main.php">Descriptores</a></li>   
                <? if($usr->getNivel()==0) { ?>
                <li><a href="adm_per_main.php">Períodos Cerrados</a></li>        
                <? } }?>
                <li><a href="adm_trans_main.php">Mov. Bancarios</a></li>   
                <li><a href="consulta_afip.php">Consulta Comprobantes Fiscales</a></li>   
            </ul>
        </li>        
        <li><a href="#">Producción</a>
            <ul>
                <li><a href="adm_ela_main.php">Elaboración</a></li>
                <li><a href="adm_env_main.php">Envasado</a></li>
            </ul>
        </li>   
        <li><a href="adm_empleados_main.php">Empleados</a></li>           
        <li><a href="#">Contabilidad</a>
            <ul>
                <li><a href="adm_cta_main.php">Plan de Cuentas</a></li>
                <li><a href="adm_mov_main.php">Movimientos</a></li>
                <li><a href="adm_inf_mayor.php">Libro Mayor</a></li>
                <li><a href="adm_inf_ss.php">Sumas Y Saldos</a></li>
                <li><a href="adm_vta_conf_main.php">Configuración Cuentas Ventas</a></li>
                <li><a href="adm_com_conf_main.php">Configuración Cuentas Compras</a></li>
                <li><a href="adm_inf_movdif.php">Diferencias de Asientos</a></li>
                <li><a href="adm_ajuste_main.php">Ajustes de Inflacion</a></li>
            </ul>
        </li>        
        <li><a href="#">Informes</a>
            <ul>
            <li><a href="adm_inf_compras.php">Productos comprados x proveedor</a></li>
            <li><a href="adm_inf_ventas.php">Productos vendidos x cliente</a></li>
            <li><a href="adm_inf_descriptores.php">Descriptores</a></li>
            <li><a href="adm_inf_eco.php">Cuenta económica</a></li>
            <li><a href="adm_inf_eco_mensual.php">Cuenta económica mensual</a></li>
            <li><a href="adm_compras_exp.php">Exportar compras</a></li>
            <li><a href="adm_inf_compras_dia.php">Productos comprados x proveedor diario</a></li>
            <li><a href="adm_inf_congelados.php">Productos congelados diario por fecha</a></li>
            <li><a href="adm_inf_congelados_fec.php">Productos congelados por rango de fecha</a></li>
            <li><a href="adm_inf_elaboracion.php">Productos elaboración diario por fecha</a></li>
            <li><a href="adm_inf_elaboracion_fec.php">Productos elaboración por rango de fecha</a></li>
            <li><a href="adm_inf_envasados.php">Productos Envasados</a></li>
            <li><a href="adm_rem_det_main.php">Trazabilidad</a></li>
            </ul>
        </li> 
        <li><a href="#">Manuales</a>
            <ul>
            <?for($d=0;$d<count($docs);$d++) { ?>
        <li><a href="doc/<?= $docs[$d]?>" target="_blank"><?= substr($docs[$d],0,strlen($docs[$d])-4)?></a></li>
            <? } ?>
            </ul>
        </li>
        <li><a href="#">Utilidades</a>
            <ul>

                <? if($usr->getNivel()==0) { ?>
                <li><a href="planb_tab_main.php">Tablas</a></li>
                <li><a href="planb_usr_main.php">Usuarios</a></li>
                <li><a href="planb_ciu_main.php">Ciudades</a></li>
                <li><a href="adm_caj_main.php">Cajas</a></li>
                <li><a href="adm_carga_arba.php">Carga Padrón ARBA</a></li>
                <li><a href="planb_conf.php">Configuración</a></li>
                <li><a href="adm_config_fiscal.php">Configuración Fiscal</a></li>
                <li><a href="adm_aud_main.php">Auditoría</a></li>
                <? } else { ?>
                <li><a href="planb_usr_pwd.php">Modifica Clave</a></li>
                <?if($usr->getNivel()<=1) { ?>
                <li><a href="planb_tab_main.php">Tablas</a></li>
                <li><a href="adm_dolar_main.php">Cotización Dólar</a></li>
                <li><a href="adm_aud_main.php">Auditoría</a></li>
                <li><a href="planb_ciu_main.php">Ciudades</a></li>
                <? } } ?>
            </ul>
        </li>
         
   
        <li><a href="adm_index.php" target="_blank"><i class="far fa-window-restore fa-lg" title="Nueva Ventana" alt="Nueva Ventana"></i></a></li>
        <li><a href="adm_index.php"><i class="fas fa-home fa-lg" title="Inicio" alt="Inicio"></i></a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt fa-lg" title="Salir del Sistema" alt="Salir del Sistema"></i></a></li>
    
    </ul>
</td>
