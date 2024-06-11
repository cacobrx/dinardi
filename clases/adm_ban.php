<?php
/*
 * Creado el 07/04/2019 12:40:55
 * Autor: gus
 * Archivo: adm_ban.php
 * planbsistemas.com.ar
 */

class adm_ban_1 {
  var $id=0;
  var $centro=0;
  var $nombre='';
  var $tipocuenta=0;
  var $numero='';
  var $contacto='';
  var $usuariohb='';
  var $clavehb='';
  var $telefono='';
  var $cbu='';

  function __construct($id, $conn="0") { 
    require_once('conexion.php');
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    $ssql='select * from adm_ban where id='.$id;
    if($conx->getCantidadRegA($ssql, $conn)>0) {
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->nombre=$reg->nombre;
        $this->tipocuenta=$reg->tipocuenta;
        $this->numero=$reg->numero;
        $this->contacto=$reg->contacto;
        $this->usuariohb=$reg->usuariohb;
        $this->clavehb=$reg->clavehb;
        $this->telefono=$reg->telefono;
        $this->cbu=$reg->cbu;
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

  function getTipocuenta() {
    return $this->tipocuenta;
  }

  function getNumero() {
    return $this->numero;
  }

  function getContacto() {
    return $this->contacto;
  }

  function getUsuariohb() {
    return $this->usuariohb;
  }

  function getClavehb() {
    return $this->clavehb;
  }

  function getTelefono() {
    return $this->telefono;
  }

  function getCbu() {
    return $this->cbu;
  }

}

class adm_ban_2 {
  var $id=array();
  var $centro=array();
  var $nombre=array();
  var $tipocuenta=array();
  var $numero=array();
  var $contacto=array();
  var $usuariohb=array();
  var $clavehb=array();
  var $telefono=array();
  var $cbu=array();
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
        array_push($this->tipocuenta,$reg->tipocuenta);
        array_push($this->numero,$reg->numero);
        array_push($this->contacto,$reg->contacto);
        array_push($this->usuariohb,$reg->usuariohb);
        array_push($this->clavehb,$reg->clavehb);
        array_push($this->telefono,$reg->telefono);
        array_push($this->cbu,$reg->cbu);
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

  function getTipocuenta() {
    return $this->tipocuenta;
  }

  function getNumero() {
    return $this->numero;
  }

  function getContacto() {
    return $this->contacto;
  }

  function getUsuariohb() {
    return $this->usuariohb;
  }

  function getClavehb() {
    return $this->clavehb;
  }

  function getTelefono() {
    return $this->telefono;
  }

  function getCbu() {
    return $this->cbu;
  }

}
