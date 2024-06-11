<?php
/*
 * Creado el 07/08/2019 21:25:24
 * Autor: gus
 * Archivo: prv_ctacte.php
 * planbsistemas.com.ar
 */

class ctacte_proveedores {
    var $fecha=array();
    var $detalle=array();
    var $importe=array();
    var $saldo=array();
    
    function __construct($idprov, $fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_opg1.php';
        require_once 'clases/adm_gas.php';
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $saldoinicial=0;
        $ssql="select sum(totaltotal) as totalcom from adm_com where idprv=$idprov and tipocom!=2 and fecha<'$fechaini'";
        $rc=$conx->consultaBase($ssql,$conn);
        $rcc=mysqli_fetch_object($rc);
        $saldoinicial=+$rcc->totalcom;
        $ssql="select sum(totaltotal) as totalcom from adm_com where idprv=$idprov and tipocom=2 and fecha<'$fechaini'";
        $rc=$conx->consultaBase($ssql,$conn);
        $rcc=mysqli_fetch_object($rc);
        $saldoinicial-=$rcc->totalcom;
        //echo $ssql."<br>";
        $ssql="select sum(importe) as totalopg from adm_opg1 where idprv=$idprov and fecha<'$fechaini'";
        $ro=$conx->consultaBase($ssql,$conn);
        $roo=mysqli_fetch_object($ro);
        
        $saldoinicial-=$roo->totalopg;
        
        
        $ssql="select * from adm_com where idprv=$idprov and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
//            echo $ssql."<br>";
        $com=new adm_com_2($ssql);
        $c_fec=$com->getFecha();
        $c_num=$com->getNumero();
        $c_imp=$com->getTotaltotal();
        $ssql="select * from adm_opg1 where idprv=$idprov and fecha>='$fechaini' and fecha<='$fechafin'";
        //if($tipo>0) $ssql.=" and tipo=$tipo";
        $ssql.=" order by fecha";
//        echo $ssql."<br>";
        $opg=new adm_opg1_2($ssql);
        $o_fec=$opg->getFecha();
        $o_num=$opg->getId();
        $o_imp=$opg->getTotalimporte();
        
        $ssql="select * from adm_gas where idprv=$idprov and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
//            echo $ssql;
        $gas=new adm_gas_2($ssql);
        $g_fec=$gas->getFecha();
        $g_num=$gas->getId();
        $g_imp=$gas->getImporte();
        
        $registro=array();
        if($saldoinicial>0)
            array_push($registro, $fechaini."||$saldoinicial|Saldo Inicial ");
        else
            array_push($registro, $fechaini."|-|$saldoinicial|Saldo Inicial");
        
        for($i=0;$i<count($c_fec);$i++) {
            array_push($registro,$c_fec[$i]."|".$c_num[$i]."|".$c_imp[$i]."|Compra");
        }
        for($i=0;$i<count($o_fec);$i++) {
            array_push($registro,$o_fec[$i]."|".$o_num[$i]."|".$o_imp[$i]."|O.Pago");
        }
        for($i=0;$i<count($g_fec);$i++) {
            array_push($registro,$g_fec[$i]."|".$g_num[$i]."|".$g_imp[$i]."|Gasto");
        }
        sort($registro);
        $sal=0;
//        print_r($registro);
        for($i=0;$i<count($registro);$i++) {
            $datos=  explode("|", $registro[$i]);
            array_push($this->fecha,$datos[0]);
            array_push($this->detalle,$datos[3]." ".$datos[1]);
            if($datos[3]=="Compra" or $datos[3]=="Gasto" or $datos[3]=="Saldo Inicial ")
                $imp=$datos[2];
            else
                $imp=$datos[2]*-1;
            array_push($this->importe,$imp);
            $sal+=$imp;
            array_push($this->saldo,$sal);
            
        }
        
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getDetalle() {
        return $this->detalle;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}
