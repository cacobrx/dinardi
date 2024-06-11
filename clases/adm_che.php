<?
/*
 *Created on 06/10/12 - 09:17:40
 *Author: Gustavo
 *File: adm_che.php
 */

class adm_che_1 {
  var $id=0;
  var $centro=0;
  var $idemp=0;
  var $idbanco=0;
  var $nrocheque=0;
  var $fechaorigen='';
  var $fechapago=0;
  var $importe=0;
  var $destinatario='';
  var $acreditado=0;
  var $referencia="";
  var $fechadeb="";
  var $bancodes='';
  var $tipo=0;
  var $entregado=0;

  function __construct($id, $conn="0") { 
    require_once 'clases/conexion.php';
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    $ssql='select * from adm_che where id='.$id;
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->idbanco=$reg->idbanco;
    $this->nrocheque=$reg->nrocheque;
    $this->fechaorigen=$reg->fechaorigen;
    $this->fechapago=$reg->fechapago;
    $this->importe=$reg->importe;
    $this->destinatario=$reg->destinatario;
    $this->acreditado=$reg->acreditado;
    $this->referencia=$reg->referencia;
    $this->fechadeb=$reg->fechadeb;
    $this->idemp=$reg->idemp;
    $this->bancodes=$conx->getTextoValor($reg->idbanco, "BAN", $conn);
    $this->entregado=$reg->entregado;
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getIdbanco() {
    return $this->idbanco;
  }

  function getNrocheque() {
    return $this->nrocheque;
  }

  function getFechaorigen() {
    return $this->fechaorigen;
  }

  function getFechapago() {
    return $this->fechapago;
  }
  
  function getFechadeb() {
      return $this->fechadeb;
  }

  function getImporte() {
    return $this->importe;
  }

  function getDestinatario() {
    return $this->destinatario;
  }

  function getAcreditado() {
    return $this->acreditado;
  }

  function getBancodes() {
    return $this->bancodes;
  }
  
  function getReferencia() {
      return $this->referencia;
  }
  
  function getIdemp() {
      return $this->idemp;
  }
  
  function getEntregado() { return $this->entregado; }
  

}

class adm_che_2 {
  var $id=array();
  var $centro=array();
  var $idbanco=array();
  var $nrocheque=array();
  var $fechaorigen=array();
  var $fechapago=array();
  var $importe=array();
  var $destinatario=array();
  var $acreditado=array();
  var $bancodes=array();
  var $referencia=array();
  var $idemp=array();
  var $fechadeb=array();
  var $entregado=array();
  var $maxregistros=0;

  function __construct($ssql, $conn="0") { 
    require_once 'clases/conexion.php';
    require_once 'clases/support.php';
    $sup=new support();
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
        array_push($this->idbanco,$reg->idbanco);
        array_push($this->nrocheque,$reg->nrocheque);
        array_push($this->fechaorigen,$reg->fechaorigen);
        array_push($this->fechapago,$reg->fechapago);
        array_push($this->fechadeb,$reg->fechadeb);
        array_push($this->importe,$reg->importe);
        array_push($this->destinatario,$reg->destinatario);
        array_push($this->acreditado,$reg->acreditado);
        array_push($this->referencia,$reg->referencia);
        array_push($this->idemp,$reg->idemp);
        array_push($this->bancodes,$conx->getTextoValor($reg->idbanco, "BAN", $conn));
        array_push($this->entregado,$reg->entregado);
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

  function getIdbanco() {
    return $this->idbanco;
  }

  function getNrocheque() {
    return $this->nrocheque;
  }

  function getFechaorigen() {
    return $this->fechaorigen;
  }

  function getFechapago() {
    return $this->fechapago;
  }
  
  function getFechadeb() {
      return $this->fechadeb;
  }

  function getImporte() {
    return $this->importe;
  }

  function getDestinatario() {
    return $this->destinatario;
  }

  function getAcreditado() {
    return $this->acreditado;
  }

  function getBancodes() {
    return $this->bancodes;
  }
  
  function getReferencia() {
      return $this->referencia;
  }
  
  function getIdemp() {
      return $this->idemp;
  }
  
  function getEntregado() { return $this->entregado; }
 

}

class tmp_che_1 {
  var $id=0;
  var $centro=0;
  var $idbanco=0;
  var $nrocheque=0;
  var $fechaorigen='';
  var $fechapago=0;
  var $importe=0;
  var $nombre='';
  var $acreditado=0;
  var $cliente="";
  var $entregado="";
  var $bancodes='';
  var $idcli=0;
  var $idcaj=0;
  var $cajades="";

  function __construct($id, $conn="0") { 
    require_once 'clases/conexion.php';
    require_once 'clases/adm_che.php';
    require_once 'clases/adm_cli.php';
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    $ssql='select * from tmp_che where id='.$id;
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->idbanco=$reg->idbanco;
    $this->nrocheque=$reg->nrocheque;
    $this->fechaorigen=$reg->fechaorigen;
    $this->fechapago=$reg->fechapago;
    $this->importe=$reg->importe;
    $this->nombre=$reg->nombre;
    $this->acreditado=$reg->acreditado;
    $this->idcli=$reg->idcli;
    $this->entregado=$reg->entregado;
    $this->idcli=$reg->idcli;
    $this->idcaj=$reg->idcaj;
    $this->cajades=$conx->getTextoValor($reg->idcaj, "CAJ", $conn);
    $this->bancodes=$conx->getTextoValor($reg->idbanco, "BAN", $conn);
    $cli=new adm_cli_1($reg->idcli, $conn);
    $this->cliente=$cli->getApellido()." ".$cli->getNombre();
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getIdbanco() {
    return $this->idbanco;
  }

  function getNrocheque() {
    return $this->nrocheque;
  }

  function getFechaorigen() {
    return $this->fechaorigen;
  }

  function getFechapago() {
    return $this->fechapago;
  }

  function getImporte() {
    return $this->importe;
  }

  function getNombre() {
    return $this->nombre;
  }

  function getAcreditado() {
    return $this->acreditado;
  }

  function getBancodes() {
    return $this->bancodes;
  }
  
  function getCliente() {
      return $this->cliente;
  }
  
  function getEntregado() {
      return $this->entregado;
  }
  
  function getIdcli() {
      return $this->idcli;
  }
  
  function getProveedor() {
      return $this->cliente;
  }
  
  function getIdcaj() {
      return $this->idcaj;
  }
  
  function getCajades() {
      return $this->cajades;
  }
  

}

?>
