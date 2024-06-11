<?
/*
 *Created on 22/10/12 - 12:42:36
 *Author: Gustavo
 *File: ram_caj.php
 */

class adm_caj_1 {
  var $id=0;
  var $centro=0;
  var $nombre='';
  var $tipo=0;
  var $monedapesos=0;

  function __construct($id, $conn="0") { 
    require_once('clases/conexion.php');
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    $ssql='select * from adm_caj where id='.$id;
    if($conx->getCantidadRegA($ssql, $conn)>0) {
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->nombre=$reg->nombre;
        $this->tipo=$reg->tipo;
        $this->monedapesos=$reg->monedapesos;
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
  
  function getMonedapesos() { return $this->monedapesos; }
  
}

class adm_caj_2 {
  var $id=array();
  var $centro=array();
  var $nombre=array();
  var $tipo=array();
  var $monedapesos=array();
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
      $this->maxregistros=$conx->getCantidadRegA($ssqltot, $conn);
      $rs=$conx->consultaBase($ssql, $conn);
      while($reg=mysqli_fetch_object($rs)) {
        array_push($this->id,$reg->id);
        array_push($this->centro,$reg->centro);
        array_push($this->nombre,$reg->nombre);
        array_push($this->tipo,$reg->tipo);
        array_push($this->monedapesos,$reg->monedapesos);
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
  
  function getMonedapesos() { return $this->monedapesos; }

}
?>
