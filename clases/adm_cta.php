<?
/*
 *Created on 16/08/12 - 12:09:55
 *Author: Gustavo
 *File: hpa_cta.php
 */

class adm_cta_1 {
    var $id=0;
    var $centro=0;
    var $nombre='';
    var $tipo=0;
    var $tipodes='';
    var $codigo='';

    function __construct($id,$conn="0") { 
        require_once('conexion.php');
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql='select * from adm_cta where id='.$id;
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->nombre=$reg->nombre;
            $this->tipo=$reg->tipo;
            $this->codigo=$reg->codigo;
            $this->tipodes=$conx->getTextoValorA($reg->tipo, "TPC",$conn);
        }
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTipodes() {
        return $this->tipodes;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCtagasto() {
        return $this->ctagasto;
    }

}

class adm_cta_cod {
    var $id=0;
    var $centro=0;
    var $nombre='';
    var $tipo=0;
    var $tipodes='';
    var $codigo='';

    function __construct($cod, $idemp, $conn="0") { 
        require_once('conexion.php');
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_cta where codigo='$cod' and idemp='$idemp'";
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->nombre=$reg->nombre;
            $this->tipo=$reg->tipo;
            $this->codigo=$reg->codigo;
            $this->tipodes=$conx->getTextoValorA($reg->tipo, "TPC",$conn);
        }
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTipodes() {
        return $this->tipodes;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getCtagasto() {
        return $this->ctagasto;
    }

}


class adm_cta_2 {
    var $id=array();
    var $centro=array();
    var $nombre=array();
    var $tipo=array();
    var $tipodes=array();
    var $codigo=array();
    var $okborrar=array();
    var $maxregistros=0;

    function __construct($ssql, $conn="0") { 
        require_once('conexion.php');
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->nombre,$reg->nombre);
                array_push($this->tipo,$reg->tipo);
                array_push($this->codigo,$reg->codigo);
                if($reg->tipo==1)
                    array_push($this->tipodes,"Imputable");
                else
                    array_push($this->tipodes,"No Imputable");
                $ssql="select * from adm_mov2 where idcta=".$reg->id;
                if($conx->getCantidadRegA($ssql, $conn)==0)
                    array_push($this->okborrar,1);
                else
                    array_push($this->okborrar,0);
            }
        }
    }

    function getMaxRegistros() {
      return $this->maxregistros;
    }

    function getId() {
      return $this->id;
    }

    function getCentro() {
      return $this->centro;
    }

    function getNombre() {
      return $this->nombre;
    }

    function getTipo() {
      return $this->tipo;
    }

    function getTipodes() {
      return $this->tipodes;
    }

    function getCodigo() {
        return $this->codigo;
    }
    
    function getOkborrar() {
        return $this->okborrar;
    }

}

?>
