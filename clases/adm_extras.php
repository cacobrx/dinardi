<?php
/*
 * Creado el 22/01/2016 10:23:16
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_dextra
 */

class adm_extras_1 {
  var $id=0;
  var $fecha='';
  var $idper=0;
  var $persona='';
  var $importe=0;

    
  function __construct($id) {
    require_once "clases/conexion.php";
    require_once 'clases/adm_empleados.php';
    $conx=new conexion();
    $ssql="select * from adm_extras where id=$id";
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->fecha=$reg->fecha;
    $this->idper=$reg->idper;
    $this->importe=$reg->importe;
    $per=new adm_empleados_1($reg->idper);
    $this->persona=$per->getApellido()." ".$per->getNombre();
  }

  function getId() {
    return $this->id;
  }
  
  function getFecha() {
    return $this->fecha;
  }
  
  function getIdper() {
    return $this->idper;
  }
  
  function getImporte() {
    return $this->importe;
  }
  
  function getPersona() {
      return $this->persona;
  }
  
}

class adm_extras_2 {
  var $id=array();
  var $fecha=array();
  var $idper=array();
  var $importe=array();
  var $persona=array();
  var $maxregistros=0;

    
  function __construct($ssql) {
    require_once "clases/conexion.php";
    require_once 'clases/adm_empleados.php';
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
        array_push($this->fecha,$reg->fecha);
        array_push($this->idper,$reg->idper);
        array_push($this->importe,$reg->importe);
        $per=new adm_empleados_1($reg->idper);
        array_push($this->persona,$per->getApellido()." ".$per->getNombre());
      }    
    }
  }

  function getId() {
    return $this->id;
  }
  
  function getFecha() {
    return $this->fecha;
  }
  
  function getIdper() {
    return $this->idper;
  }
  
  function getImporte() {
    return $this->importe;
  }
  
  function getPersona() {
      return $this->persona;
  }
  
  function getMaxRegistros() {
    return $this->maxregistros;
  }
}

?>
