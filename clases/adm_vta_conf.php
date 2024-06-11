<?php
/*
 * creado el 10/11/2017 14:35:23
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_vta_conf
 */

class adm_vta_conf_1 {
    var $id=0;
    var $centro=0;
    var $idemp=0;
    var $idcta=0;
    var $idtipo=0;
    var $cuenta="";
    var $tipo="";
    var $tipocuenta=1;
    var $tipocuentades='';

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Percepción IVA", "Percepción IIBB", "Cuenta Corriente");
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_vta_conf where id=$id";
        //echo $ssql."\n";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idemp=$reg->idemp;
        $this->idcta=$reg->idcta;
        $this->idtipo=$reg->idtipo;
        $this->tipocuenta=$reg->tipocuenta;
                if($reg->tipoceunta==0) {
            $this->tipocuentades="Entrada";       
        } else {
            $this->tipocuentades="Salida";            
        }
        $cta=new adm_cta_1($reg->idcta, $conn);
        $this->cuenta=$cta->getNombre();
        $this->tipo=$tipos[$reg->idtipo];
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getIdemp() {
        return $this->idemp;
    }
  
    function getIdcta() {
        return $this->idcta;
    }
  
    function getCuenta() {
        return $this->cuenta;
    }
  
    function getIdtipo() {
        return $this->idtipo;
    }
  
    function getTipo() {
        return $this->tipo;
    }
  
    function getTipocuenta() {
        return $this->tipocuenta;
    }
    
    function getTipocuentades() {
        return $this->tipocuentades;
    }    
    
}

class adm_vta_conf_t {
    var $id=0;
    var $centro=0;
    var $idemp=0;
    var $idcta=0;
    var $idtipo=0;
    var $cuenta="";
    var $tipo="";
    var $codigo="";

    
    function __construct($idemp, $ttt, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Percepción IVA", "Percepción IIBB", "Cuenta Corriente");
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_vta_conf where idemp=$idemp and idtipo=$ttt";
//        echo $ssql."\n";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->idemp=$reg->idemp;
            $this->idcta=$reg->idcta;
            $this->idtipo=$reg->idtipo;
            $cta=new adm_cta_1($reg->idcta, $conn);
            $this->cuenta="(".$cta->getCodigo().") ".$cta->getNombre();
            $this->tipo=$tipos[$reg->idtipo];
            $this->codigo=$cta->getCodigo();
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getIdemp() {
        return $this->idemp;
    }
  
    function getIdcta() {
        return $this->idcta;
    }
  
    function getCuenta() {
        return $this->cuenta;
    }
  
    function getIdtipo() {
        return $this->idtipo;
    }
  
    function getTipo() {
        return $this->tipo;
    }
    
    function getCodigo() {
        return $this->codigo;
    }
  
  
}



class adm_vta_conf_2 {
    var $id=array();
    var $centro=array();
    var $idemp=array();
    var $idcta=array();
    var $idtipo=array();
    var $cuenta=array();
    var $tipo=array();
    var $tipocuenta=array();
    var $tipocuentades=array();
    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "IMP.INT", "Percepción IVA", "Percepción IIBB", "Cuenta Corriente");
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->idemp,$reg->idemp);
                array_push($this->idcta,$reg->idcta);
                array_push($this->idtipo,$reg->idtipo);                
                array_push($this->tipocuenta,$reg->tipocuenta);
                if($reg->tipocuenta==0) {
                    array_push($this->tipocuentades,"Debe");                    
                } else {
                    array_push($this->tipocuentades,"Haber");                    
                }
                $cta=new adm_cta_1($reg->idcta, $conn);
                array_push($this->cuenta,$cta->getNombre());
                array_push($this->tipo,$tipos[$reg->idtipo]);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getIdemp() {
        return $this->idemp;
    }
  
    function getIdcta() {
        return $this->idcta;
    }
  
    function getCuenta() {
        return $this->cuenta;
    }
  
    function getIdtipo() {
        return $this->idtipo;
    }
  
    function getTipo() {
        return $this->tipo;
    }
    
    function getTipocuenta() {
        return $this->tipocuenta;
    }  
    
    function getTipocuentades() {
        return $this->tipocuentades;
    }     
}

class adm_vta_contable {
    var $idcta=array();
    var $debe=array();
    var $haber=array();
    var $detalle=array();
    var $cuenta=array();
    var $codigo=Array();
    
    function __construct($idemp, $idcli, $xneto21, $xneto10, $xneto27, $xexento, $xnograbado, $xiva21, $xiva10, $xiva27, $ximpint, $xperiva, $xperiibb) {
        require_once 'clases/adm_cli.php';
        $imp=array(0,$xiva21, $xiva10, $xiva27, $ximpint, $xperiva, $xperiibb);
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "IMP.INT", "Percepción IVA", "Percepción IIBB", "Cuenta Corriente");
        $neto=$xneto21+$xneto10+$xneto27+$xexento+$xnograbado;
        $total=$xneto21+$xneto10+$xneto27+$xexento+$xnograbado+$xiva21+$xiva10+$xiva27+$ximpint+$xperiva+$xperiibb;
        $cli=new adm_cli_1($idcli);
        array_push($this->idcta,$cli->getCuenta());
        array_push($this->cuenta,$cli->getCuentades());
        array_push($this->debe,$neto);
        array_push($this->haber,0);
        array_push($this->detalle,"");
        array_push($this->codigo,$cli->getCodigo());
        for($i=1;$i<=6;$i++) {
//            echo $i." - ".$imp[$i]."\n";
            if($imp[$i]!=0) {
                $ttt=new adm_vta_conf_t($idemp, $i);
                array_push($this->idcta,$ttt->getIdcta());
                if($imp[$i]>0) {
                    array_push($this->debe,$imp[$i]);
                    array_push($this->haber,0);
                } else {
                    array_push($this->haber,abs($imp[$i]));
                    array_push($this->debe,0);
                }
                array_push($this->detalle,$tipos[$i]);
                array_push($this->cuenta,$ttt->getCuenta());
                array_push($this->codigo,$ttt->getCodigo());
            }
        }
        $ttt=new adm_vta_conf_t($idemp, 7);
        array_push($this->idcta,$ttt->getIdcta());
        array_push($this->debe,0);
        array_push($this->haber,$total);
        array_push($this->detalle,"Cliente: ".$cli->getApellido());
        array_push($this->cuenta,$ttt->getCuenta());
        array_push($this->codigo,$ttt->getCodigo());
    }
    
    function getIdcta() {
        return $this->idcta;
    }
    
    function getDebe() {
        return $this->debe;
    }
    
    function getHaber() {
        return $this->haber;
    }
    
    function getDetalle() {
        return $this->detalle;
    }
    
    function getCuenta() {
        return $this->cuenta;
    }
    
    function getCodigo() {
        return $this->codigo;
    }
}

?>
