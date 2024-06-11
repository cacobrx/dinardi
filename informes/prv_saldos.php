<?php
/*
 * Creado el 07/08/2019 21:45:19
 * Autor: gus
 * Archivo: prv_saldos.php
 * planbsistemas.com.ar
 */

class saldo_proveedores {
    var $proveedor=array();
    var $facturas=array();
    var $recibos=array();
    var $saldo=array();
    
    function __construct($tipo, $conceros, $fechafin) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_opg1.php';
        require_once 'clases/adm_prv.php';
        if($tipo!="")
            $ssql="select * from adm_prv where tipo=$tipo order by apellido, nombre";
        else
            $ssql="select * from adm_prv order by apellido, nombre";
        $prv=new adm_prv_2($ssql);
        $p_id=$prv->getId();
        $p_ape=$prv->getApellido();
        $p_nom=$prv->getNombre();
        $conx=new conexion();
        $conn=$conx->conectarBase();
        for($i=0;$i<count($p_id);$i++) {
            $ssql="select sum(totaltotal) as totalcom from adm_com where idprv=".$p_id[$i]." and tipocom!=1 and fecha<='$fechafin'";
//            echo $ssql;
            $rc=$conx->consultaBase($ssql,$conn);
            $rcc=mysqli_fetch_object($rc);
            $totalcom=$rcc->totalcom;
            $ssql="select sum(totaltotal) as totalcom from adm_com where idprv=".$p_id[$i]." and tipocom=1 and fecha<='$fechafin'";
            $rc=$conx->consultaBase($ssql,$conn);
            $rcc=mysqli_fetch_object($rc);
            $totalcom+=$rcc->totalcom;
            //echo $ssql."<br>";
            $ssql="select sum(importe) as totalopg from adm_opg1 where idprv=".$p_id[$i]." and fecha<='$fechafin'";
            $ro=$conx->consultaBase($ssql,$conn);
            $roo=mysqli_fetch_object($ro);
            $totalopg=-$roo->totalopg;
            $pasa=1;
            $ss=$rcc->totalcom-$roo->totalopg;
            
//            echo number_format($totalopg,2)."|".number_format($totalcom,2)."|$ss<br>";
            if($conceros!=1)
                if($ss==0) $pasa=0;
            
            if($pasa==1) {     
                array_push($this->proveedor,$p_ape[$i]." ".$p_nom[$i]);
                array_push($this->facturas,abs($totalcom));
                array_push($this->recibos,abs($totalopg));
                array_push($this->saldo,$totalopg+$totalcom);
            }
        }
        
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getFacturas() {
        return $this->facturas;
    }
    
    function getRecibos() {
        return $this->recibos;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}
