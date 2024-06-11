<?
/*
 *Created on 12/11/12 - 12:28:46
 *Author: Gustavo
 *File: adm_opg2.php
 */

class adm_rec2_1 {
  var $id=0;
  var $centro=0;
  var $idop=0;
  var $detalle='';
  var $importe=0;
  var $idcht=0;
  var $detallepago=0;
  var $detallepagodes="";

  function __construct($id) { 
    require_once('conexion.php');
    $conx=new conexion();
    $ssql='select * from adm_rec2 where id='.$id;
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->idop=$reg->idop;
    $this->detalle=$reg->detalle;
    $this->importe=$reg->importe;
    $this->idcht=$reg->idcht;
    $this->detallepago=$reg->detallepago;
    $this->detallepagodes=$conx->getTextoValor($reg->detallepago, "DPG");
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
  
  function getDetallepago() { return $this->detallepago(); }
  function getDetallepagodes() { return $this->detallepagodes; }

}

class adm_rec2_2 {
  var $id=array();
  var $centro=array();
  var $idrec=array();
  var $detalle=array();
  var $importe=array();
  var $detallepago=array();
  var $detallepagodes=array();
  var $idcht=array();
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
        array_push($this->idrec,$reg->idrec);
        array_push($this->detalle,$reg->detalle);
        array_push($this->importe,$reg->importe);
        array_push($this->detallepago,$reg->detallepago);
        array_push($this->detallepagodes,$conx->getTextoValor($reg->detallepago, "DPG"));
        array_push($this->idcht,$reg->idcht);
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

  function getIdrec() {
    return $this->idrec;
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
  
  function getDetallepago() {
      return $this->detallepago;
  }
  function getDetallepagodes() { return $this->detallepagodes; }
  

}
?>
