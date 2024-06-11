<?
/*
 *Created on 12/11/12 - 12:28:46
 *Author: Gustavo
 *File: adm_opg2.php
 */

class adm_opg2_1 {
  var $id=0;
  var $centro=0;
  var $idop=0;
  var $detalle='';
  var $importe=0;
  var $idcht=0;
  var $tipo=1;
  var $idche=0;
  var $tipopago=0;

  function __construct($id) { 
    require_once('conexion.php');
    $conx=new conexion();
    $ssql='select * from adm_opg2 where id='.$id;
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->idop=$reg->idop;
    $this->detalle=$reg->detalle;
    $this->importe=$reg->importe;
    $this->idcht=$reg->idcht;
    $this->tipo=$reg->tipo;
    $this->idche=$reg->idche;
    $this->tipopago=$reg->tipopago;
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getIdop() {
    return $this->idop;
  }

  function getDetalle() {
    return $this->detalle;
  }

  function getImporte() {
    return $this->importe;
  }
  
  function getIdcht() {
      return $this->idcht;
  }
  
  function getTipo() { return $this->tipo; }
  function getIdche() { return $this->idche; }
  function getTipopago() { return $this->tipopago; }

}

class adm_opg2_2 {
  var $id=array();
  var $centro=array();
  var $idop=array();
  var $detalle=array();
  var $importe=array();
  var $idcht=array();
  var $idche=array();
  var $tipopago=array();
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
        array_push($this->centro,$reg->centro);
        array_push($this->idop,$reg->idop);
        array_push($this->detalle,$reg->detalle);
        array_push($this->importe,$reg->importe);
        array_push($this->idcht,$reg->idcht);
        array_push($this->idche,$reg->idche);
        array_push($this->tipopago,$reg->tipopago);
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

  function getIdop() {
    return $this->idop;
  }

  function getDetalle() {
    return $this->detalle;
  }

  function getImporte() {
    return $this->importe;
  }
  
  function getIdcht() {
      return $this->idcht;
  }
  
  function getIdche() { return $this->idche; }
  function getTipopago() { return $this->tipopago; }
}
?>
