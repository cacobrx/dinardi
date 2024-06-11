<?php
/*
 * creado el 10/11/2017 14:35:23
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_com_conf
 */

class adm_com_conf_1 {
    var $id=0;
    var $centro=0;
    var $idemp=0;
    var $idcta=0;
    var $idtipo=0;
    var $cuenta="";
    var $tipo="";

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Retencion IVA", "Retencion IIBB", "Cuenta Corriente", "Percepción IVA", "IVA 17.335%");
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_com_conf where id=$id";
        //echo $ssql."\n";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idemp=$reg->idemp;
        $this->idcta=$reg->idcta;
        $this->idtipo=$reg->idtipo;
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
  
  
}

class adm_com_conf_t {
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
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Retencion IVA", "Retencion IIBB", "Cuenta Corriente", "Percepción IVA", "IVA 17.335%");
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_com_conf where idemp=$idemp and idtipo=$ttt";
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



class adm_com_conf_2 {
    var $id=array();
    var $centro=array();
    var $idemp=array();
    var $idcta=array();
    var $idtipo=array();
    var $cuenta=array();
    var $tipo=array();
    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Retencion IVA", "Retencion IIBB", "Cuenta Corriente", "Percepción IVA", "IVA 17.335%");
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
}

class adm_com_contable {
    var $idcta=array();
    var $debe=array();
    var $haber=array();
    var $detalle=array();
    var $cuenta=array();
    var $codigo=array();
    
    function __construct($idemp, $idpro, $xneto21, $xneto10, $xneto27, $xexento, $xnograbado, $xiva21, $xiva10, $xiva27, $ximpint, $xperiva, $xperiibb, $cuenta, $xneto15, $xiva17) {
        require_once 'clases/adm_pro.php';
        require_once 'clases/adm_cta.php';
        $imp=array(0,$xiva21, $xiva10, $xiva27, $ximpint, $xperiva, $xperiibb);
        $tipos=array("", "IVA 21%", "IVA 10%", "IVA 27%", "Impuestos Internos", "Retencion IVA", "Retencion IIBB", "Cuenta Corriente", "Percepción IVA", "IVA 17.335%");
        $neto=$xneto21+$xneto10+$xneto27+$xexento+$xnograbado;
        $total=$xneto21+$xneto10+$xneto27+$xexento+$xnograbado+$xiva21+$xiva10+$xiva27+$ximpint+$xperiva+$xperiibb;
        $pro=new adm_pro_1($idpro);
        if($cuenta>0) {
            array_push($this->idcta,$cuenta);
            $cta=new adm_cta_1($cuenta);
            array_push($this->cuenta,"(".$cta->getCodigo().") ".$cta->getNombre());
            array_push($this->codigo,$cta->getCodigo());
        } else {
            array_push($this->idcta,$pro->getCuenta());
            array_push($this->cuenta,$pro->getCuentades());
            array_push($this->codigo,$pro->getCodigo());
        }
        array_push($this->debe,$neto);
        array_push($this->haber,0);
        array_push($this->detalle,"");
        for($i=1;$i<=6;$i++) {
            if($imp[$i]!=0) {
                $ttt=new adm_com_conf_t($idemp, $i);
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
        $ttt=new adm_com_conf_t($idemp, 7);
        array_push($this->idcta,$ttt->getIdcta());
        array_push($this->debe,0);
        array_push($this->haber,$total);
        array_push($this->detalle,"Proveedor: ".$pro->getApellido());
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
