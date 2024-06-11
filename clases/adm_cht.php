<?
/*
 *Created on 06/10/12 - 09:17:40
 *Author: Gustavo
 *File: adm_che.php
 */

class adm_cht_1 {
    var $id=0;
    var $centro=0;
    var $idbanco=0;
    var $nrocheque=0;
    var $fechaorigen='';
    var $fechaacr="";
    var $fechapago=0;
    var $importe=0;
    var $nombre='';
    var $acreditado=0;
    var $idcli=0;
    var $cliente="";
    var $entregado="";
    var $bancodes='';
    var $tipo=0;
    var $dias=0;

    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql='select * from adm_cht where id='.$id;
        if($conx->getCantidadRegA($ssql, $conn)>0) {
  //          echo $ssql;    
          $rs=$conx->consultaBase($ssql,$conn);
          $reg=mysqli_fetch_object($rs);
          $this->id=$reg->id;
          $this->centro=$reg->centro;
          $this->idbanco=$reg->idbanco;
          $this->nrocheque=$reg->nrocheque;
          $this->fechaorigen=$reg->fechaorigen;
          $this->fechapago=$reg->fechapago;
          $this->importe=$reg->importe;
          $this->nombre=$reg->nombre;
          $this->fechaarc=$reg->fechaacr;
          $this->acreditado=$reg->acreditado;
          $this->idcli=$reg->idcli;
          $cli=new adm_cli_1($reg->idcli);
          $this->cliente=$cli->getApellido()." ".$cli->getNombre();
          $this->entregado=$reg->entregado;
          $this->tipo=$reg->tipo;
          $fini=$reg->fecha;
          $dd=0;
          while($fini<=$reg->fechapago) {
              $dd++;
              $fini=date("Y-m-d", strtotime("$fini + 1 day"));
          }
          $this->dias=$dd;

        }  
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
    
    function getFechaacr() {
        return $this->fechaarc;
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

    function getIdcli() {
        return $this->idcli;
    }

    function getTipo() {
        return $this->tipo;
    }  

    function getEntregado() {
        return $this->entregado;
    }
    
    function getDias() { return $this->dias; }

}

class adm_cht_2 {
    var $id=array();
    var $centro=array();
    var $idbanco=array();
    var $nrocheque=array();
    var $fechaorigen=array();
    var $fechapago=array();
    var $importe=array();
    var $nombre=array();
    var $acreditado=array();
    var $bancodes=array();
    var $fechaacr=array();
    var $idcli=array();
    var $cliente=array();
    var $entregado=array();
    var $tipo=array();
    var $color=array();
    var $backcolor=array();
    var $dias=array();

    var $maxregistros=0;

    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
        require_once 'clases/datesupport.php';
        $dsup=new datesupport();
        global $cfg;
        $hoy=date("Y-m-d");
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
                array_push($this->idbanco,$reg->idbanco);
                array_push($this->nrocheque,$reg->nrocheque);
                array_push($this->fechaorigen,$reg->fechaorigen);
                array_push($this->fechapago,$reg->fechapago);
                array_push($this->importe,$reg->importe);
                array_push($this->nombre,$reg->nombre);
                array_push($this->acreditado,$reg->acreditado);
                array_push($this->idcli,$reg->idcli);
                $cli=new adm_cli_1($reg->idcli,$conn);
                array_push($this->cliente,$cli->getApellido()." ".$cli->getNombre());
                array_push($this->entregado,$reg->entregado);
                array_push($this->fechaacr,$reg->fechaacr);
                array_push($this->tipo,$reg->tipo);
                array_push($this->bancodes,$conx->getTextoValor($reg->idbanco, "BAN", $conn));
                $xcolor="#000000";
                $xback="#ffffff";
                $dias=0;
//                echo $reg->entregado." ".$reg->fechaacr."<br>";
                if($reg->entregado=="" or $reg->entregado==NULL) {
                    if($reg->fechaacr==NULL) {
                        $di=$cfg->getDiasvencimientocht();
                        $xven=date("Y-m-d");
                        $xfechapago=date("Y-m-d", strtotime($reg->fechapago));
                        $enunmes=date("Y-m-d", strtotime("$xven + 1 month"));
                        $fechapagoenunmes=date("Y-m-d", strtotime("$xfechapago + 1 month"));
                        $xven1=date("Y-m-d", strtotime("$xven + $di days"));
            //            echo "$xven1 | ".$reg->fechapago."\n";
                        if($reg->fechapago<=date("Y-m-d")) $xcolor="#990000";
                        if($xven1>=$reg->fechapago and $reg->fechapago>=$hoy) $xcolor="#009900";
                        $dias=$dsup->getFechaDif($reg->fechapago, date("Y-m-d"), "d");
                        $xx=30-$cfg->getDiasfinalcht();
    //                    echo "dias: $dias | $xx\n";
                        if($dias>30-$cfg->getDiasfinalcht()) {
                            $xcolor="#000000";
                            $xback="yellow";
                        }
                        if($dias>=30) {
                            $xcolor="#ffffff";
                            $xback="#000000";
                        }
                    }
                }
                array_push($this->color,$xcolor);
                array_push($this->backcolor,$xback);
                array_push($this->dias, $dias);

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
    
    function getFechaacr() {
        return $this->fechaacr;
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

    function getTipo() {
      return $this->tipo;
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
    
    function getColor() { return $this->color; }
    function getBackcolor() { return $this->backcolor; }
    function getDias() { return $this->dias; }
}

class tmp_cht_1 {
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
  var $idprv=0;
  var $proveedor="";
  var $idcaj=0;
  var $cajades="";

  function __construct($id, $conn="0") { 
    require_once 'clases/conexion.php';
    require_once 'clases/adm_cht.php';
    require_once 'clases/adm_prv.php';
    require_once 'clases/adm_cli.php';
    $conx=new conexion();
    if($conn=="0") $conn=$conx->conectarBase ();
    $ssql='select * from tmp_cht where id='.$id;
//    echo $ssql."<br>";
    if($conx->getCantidadRegA($ssql, $conn)>0) {
        $rs=$conx->consultaBase($ssql, $conn);
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
        $this->idprv=$reg->idprv;
        $this->idcaj=$reg->idcaj;
        $this->cajades=$conx->getTextoValor($reg->idcaj, "CAJ", $conn);
        $this->bancodes=$conx->getTextoValor($reg->idbanco, "BAN", $conn);
        $cli=new adm_cli_1($reg->idcli, $conn);
        $this->cliente=$cli->getApellido()." ".$cli->getNombre();
        if($reg->idprv>0) {
            $prv=new adm_prv_1($reg->idprv, $conn);
            $this->proveedor=$prv->getApellido()." ".$prv->getNombre();
        }
    }
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
  
  function getIdprv() {
      return $this->idprv;
  }
  
  function getProveedor() {
      return $this->proveedor;
  }
  
  function getIdcaj() {
      return $this->idcaj;
  }
  
  function getCajades() {
      return $this->cajades;
  }
  

}


?>
