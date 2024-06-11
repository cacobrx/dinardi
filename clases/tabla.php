<?
/*
 *Created on 04/11/11 - 16:49:08
 *Author: Gustavo
 *File: tabla.php
 */

class tabla_1 {
  var $id=0;
  var $codtab='';
  var $descripcion='';
  var $valor=0;
  var $orden=0;
  var $centro=0;
  var $valorc='';
  var $activo=0;

  function __construct($id) { 
    require_once('conexion.php');
    $conx=new conexion();
    $ssql='select * from tablas where id='.$id;
    //echo $ssql."<br>";
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->codtab=$reg->codtab;
    $this->descripcion=$reg->descripcion;
    $this->valor=$reg->valor;
    $this->orden=$reg->orden;
    $this->centro=$reg->centro;
    $this->valorc=$reg->valorc;
    $this->activo=$reg->activo;
  }

  function getId() {
    return $this->id;
  }

  function getCodtab() {
    return $this->codtab;
  }

  function getDescripcion() {
    return $this->descripcion;
  }

  function getValor() {
    return $this->valor;
  }

  function getOrden() {
    return $this->orden;
  }

  function getCentro() {
    return $this->centro;
  }

  function getValorc() {
    return $this->valorc;
  }

  function getActivo() {
      return $this->activo;
  }

}

class tabla_2 {
  var $id=array();
  var $codtab=array();
  var $descripcion=array();
  var $valor=array();
  var $orden=array();
  var $centro=array();
  var $valorc=array();
  var $activo=array();
  var $maxregistros=0;

  function __construct($ssql) { 
    require_once('conexion.php');
    $conx=new conexion();
    if($conx->getCantidadReg($ssql)>0) {
      if(strpos($ssql,'limit')=='')
        $ssqltot=$ssql;
      else
        $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
      $this->maxregistros=$conx->getCantidadReg($ssqltot);
      $rs=$conx->getConsulta($ssql);
      while($reg=mysqli_fetch_object($rs)) {
        array_push($this->id,$reg->id);
        array_push($this->codtab,$reg->codtab);
        array_push($this->descripcion,$reg->descripcion);
        array_push($this->valor,$reg->valor);
        array_push($this->orden,$reg->orden);
        array_push($this->centro,$reg->centro);
        array_push($this->valorc,$reg->valorc);
        array_push($this->activo,$reg->activo);
      }
    }
  }

  function getMaxRegistros() {
    return $this->maxregistros;
  }

  function getId() {
    return $this->id;
  }

  function getCodtab() {
    return $this->codtab;
  }

  function getDescripcion() {
    return $this->descripcion;
  }

  function getValor() {
    return $this->valor;
  }

  function getOrden() {
    return $this->orden;
  }

  function getCentro() {
    return $this->centro;
  }

  function getValorc() {
    return $this->valorc;
  }
  
  function getActivo() {
      return $this->activo;
  }

}

class tabla_def {
    var $descripcion="";
    var $activo=0;
    
    function __construct($codtab,$conn="0") {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from tablas where id=$codtab";
        //echo $ssql."\n";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=  mysqli_fetch_object($rs);
            $this->descripcion=$reg->descripcion;
            $this->activo=$reg->activo;
        }
        
    }
    
    function getDescripcion() {
        return $this->descripcion;
    }
    
    function getActivo() {
        return $this->activo;
    }
}

?>
