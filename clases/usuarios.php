<?
/*
 *Created on 08/01/10 - 14:44:22
 *Author: Gustavo
 *File: edd_users.php
 */

class usuarios_1 {
  var $id=0;
  var $apellido="";
  var $nombre='';
  var $email='';
  var $clave='';
  var $acceso="";
  var $centro=0;
  var $nivel=0;
  var $servidorafip=0;

  function __construct($id, $conn="0") { 
    require_once('conexion.php');
    require_once("centro.php");
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    $ssql='select * from usuarios where id='.$id;
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->apellido=$reg->apellido;
    $this->nombre=$reg->nombre;
    $this->email=$reg->email;
    $this->clave=$reg->clave;
    $this->centro=$reg->centro;
    $this->acceso=$reg->acceso;
    $this->nivel=$reg->nivel;
    $this->servidorafip=$reg->servidorafip;
    $cen=new centro_1($reg->centro, $conn);
    $this->centronom=$cen->getNombre();
    
  }

  function getId() {
    return $this->id;
  }
  
  function getApellido() {
  	return $this->apellido;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getEmail() {
    return $this->email;
  }

  function getClave() {
    return $this->clave;
  }

  function getCentronom() {
    return $this->centronom;
  }
  
  function getCentro() {
    return $this->centro;
  }
  
  function getAcceso() {
  	return $this->acceso;
  }
  
  function getNivel() {
  	return $this->nivel;
  }
  
  function getServidorafip() { return $this->servidorafip; }
  

}

class usuarios_2 {
  var $id=array();
  var $apellido=array();
  var $nombre=array();
  var $email=array();
  var $clave=array();
  var $centronom=array();
  var $nivel=array();
  var $servidorafip=array();
  var $maxregistros=0;

  function __construct($ssql) { 
    require_once('conexion.php');
    require_once 'centro.php';
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
        array_push($this->apellido,$reg->apellido);
        array_push($this->nombre,$reg->nombre);
        array_push($this->email,$reg->email);
        array_push($this->clave,$reg->clave);
        array_push($this->nivel,$reg->nivel);
        array_push($this->servidorafip,$reg->servidorafip);
    	$cen=new centro_1($reg->centro);
    	array_push($this->centronom,$cen->getNombre());
        
      }
    }
  }

  function getMaxRegistros() {
    return $this->maxregistros;
  }

  function getId() {
    return $this->id;
  }
  
  function getApellido() {
  	return $this->apellido;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getEmail() {
    return $this->email;
  }

  function getClave() {
    return $this->clave;
  }

  function getCentronom() {
  	return $this->centronom;
  }
  
  function getNivel() {
  	return $this->nivel;
  }
  
  function getServidorafip() { return $this->servidorafip; }

}
?>
