<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adm_fis
 *
 * @author gus
 */

class adm_fis_1 {
    var $id=0;
    var $centro=0;
    var $fecha="";
    var $anomes="";
    var $tipo="";
    var $tipodes="";
    var $tipocom=99;
    var $ptovta=0;
    var $numero=0;
    var $total=0;
    var $letra="";
    var $tipopago=0;
    var $tipopagodes="";
    var $imprimir=0;
    var $cliente="";
    var $totaltotal=0;
    var $docreferencia=0;
    var $condicioniva="";
    var $nrocuit=0;
    var $numerocae=0;
    var $fechacae="";
    var $direccion="";
    var $ciudad="";
    var $ciudaddes="";
    var $condicionivades="";
    var $codigocomp=0;
    var $idcuit=0;
    var $error="";
    var $fechaperini="";
    var $fechaperfin="";
    var $fechapago="";
    var $importepago=0;
    var $idped="";
    var $email="";
    var $fechamail="";
    var $tipodoc="";
    var $percepcioniibb=0;
    var $porcentajeiibb=0;
    var $netocf21=0;
    var $netori21=0;
    var $netocf10=0;
    var $netori10=0;
    var $ivacf21=0;
    var $ivari21=0;
    var $ivacf10=0;
    var $ivari10=0;
    var $neto=0;
    var $iva10=0;
    var $iva21=0;
    var $nogravado=0;
    var $rem_numero=array();
    var $rem_fecha=array();
    var $rem_importe=array();
    var $cerrado=0;
    var $codigodoc=80;

    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once "clases/support.php";
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_crem.php';
//        require_once 'clases/ciudades.php';
        $sup=new support();
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_fis where id=$id";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->idcli=$reg->idcli;
            $this->anomes=$reg->anomes;
            $this->fecha=$reg->fecha;
            $this->tipo=$reg->tipo;
            //$this->totaltotal=$reg->total;
            $this->letra=$reg->letra;
            $this->numero=$reg->numero;
            $this->ptovta=$reg->ptovta;
            $this->tipopago=$reg->tipopago;
            $this->docreferencia=$reg->docreferencia;
            $this->percepcioniibb=$reg->percepcioniibb;
            $this->numerocae=$reg->numerocae;
            $this->fechacae=$reg->fechacae;
            $this->fechaperfin=$reg->fechaperfin;
            $this->fechaperini=$reg->fechaperini;
            $this->fechapago=$reg->fechapago;
            $this->fechamail=$reg->fechamail;
            $this->importepago=$reg->importepago;
    //        $this->cliente=$reg->cliente;
            $this->error=$reg->error;
            $this->idped=$reg->idped;
//            $this->nrocuit=$reg->nrocuit;
            if($reg->tipopago==0)
                $this->tipopagodes="CONTADO";
            else
                $this->tipopagodes="CUENTA CORRIENTE";
            $cli=new adm_cli_1($reg->idcli, $conn);
            $this->cliente=$cli->getApellido()." ".$cli->getNombre();
            $this->condicioniva=$cli->getCondicioniva();
            $this->condicionivades=$cli->getCondicionivades();
            $this->porcentajeiibb=$cli->getPercepcioniibb();
            $this->nrocuit=$cli->getCuit();
            $this->email=$cli->getEmail();
            switch ($reg->tipo) {
                case "F":
                    $this->tipodes="FC";
                    if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4)
                        $this->codigocomp=1;
                    else
                        $this->codigocomp=11;
                    $this->tipodoc="FACTURA";
                    break;
                case "D":
                    $this->tipodes="ND";
                    if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4)
                        $this->codigocomp=2;
                    else
                        $this->codigocomp=12;
                    $this->tipodoc="NOTA DE DÉBITO";
                    break;
                case "C":
                    $this->tipodes="NC";
                    if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4)
                        $this->codigocomp=3;
                    else
                        $this->codigocomp=13;
                    $this->tipodoc="NOTA DE CRÉDITO";
                    break;
                case "G":
                    $this->tipodes="FCE";
                    if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4)
                        $this->codigocomp="201";
                    else
                        $this->codigocomp="206";
                    $this->tipodoc="FACTURA DE CRÉDITO ELECTRÓNICA";
                    break;
                case "I":
                    $this->tipodes="NDE";
                    if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4)
                        $this->codigocomp="202";
                    else
                        $this->codigocomp="207";
                    $this->tipodoc="NOTA DE DÉBITO ELECTRÓNICA";
                    break;
                case "H":
                    $this->tipodes="NCE";
                    if($cli->getCondicioniva()==3 or $cli->getCondicioniva()==4)
                        $this->codigocomp="203";
                    else
                        $this->codigocomp="208";
                    $this->tipodoc="NOTA DE CRÉDITO ELECTRÓNICA";
                    break;
            }
            $ssql="select sum(cantidad*precio) as totalll from adm_fis_det where idfis=$id";
            //echo $ssql;
            $rd=$conx->consultaBase($ssql, $conn);
            $rdd=mysqli_fetch_object($rd);
            $this->total=$reg->total;
            $this->netocf10=$reg->netocf10;
            $this->netocf21=$reg->netocf21;
            $this->netori10=$reg->netori10;
            $this->netori21=$reg->netori21;
            $this->ivacf10=$reg->ivacf10;
            $this->ivacf21=$reg->ivacf21;
            $this->ivari10=$reg->ivari10;
            $this->ivari21=$reg->ivari21;
            $this->nogravado=$reg->nogravado;
            $this->totaltotal=$reg->netori21+$reg->netori10+$reg->netocf21+$reg->netocf10+$reg->ivacf21+$reg->ivacf10+$reg->ivari21+$reg->ivari10+$reg->percepcioniibb+$reg->nogravado;    
            $this->neto=$reg->netori21+$reg->netori10+$reg->netocf21+$reg->netocf10;
            $this->iva10=$reg->ivacf10+$reg->ivari10;
            $this->iva21=$reg->ivacf21+$reg->ivari21;

            // remitos
            $ssql="select * from adm_crem where idfis=$id";
            $rem=new adm_crem_2($ssql, $conn);
            $this->rem_fecha=$rem->getFecha();
            $this->rem_importe=$rem->getTotal();
            $this->rem_numero=$rem->getNumero();
            $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
            $this->cerrado=$conx->getCantidadRegA($ssql, $conn);                  
//            if(strlen($reg->nrocuit)==11)
//                $this->tipocom=80;
//            else {
//                if($reg->nrocuit==0)
//                    $this->tipocom=99;
//                else
//                    $this->tipocom=96;
//            }
        }
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdcli() {
        return $this->idcli;
    }

    function getAnomes() {
        return $this->anomes;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTotal() {
        return $this->total;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTipodes() {
        return $this->tipodes;
    }

    function getLetra() {
        return $this->letra;
    }

    function getPtovta() {
        return $this->ptovta;
    }

    function getNumero() {
        return $this->numero;
    }

    function getImprimir() {
        return $this->imprimir;
    }

    function getTipopago() {
        return $this->tipopago;
    }
    
    function getTipopagodes() {
        return $this->tipopagodes;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getTotaltotal() {
        return $this->totaltotal;
    }

    function getDocreferencia() {
        return $this->docreferencia;
    }

    function getCondicioniva() {
        return $this->condicioniva;
    }

    function getNrocuit() {
        return $this->nrocuit;
    }

    function getNumerocae() {
        return $this->numerocae;
    }

    function getFechacae() {
        return $this->fechacae;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getCiudaddes() {
        return $this->ciudaddes;
    }

    function getCondicionivades() {
        return $this->condicionivades;
    }

    function getCodigocomp() {
        return $this->codigocomp;
    }
    
    function getIdcuit() {
        return $this->idcuit;
    }
    
    function getError() {
        return $this->error;
    }
    
    function getFechaperini() {
        return $this->fechaperini;
    }
    
    function getFechaperfin() {
        return $this->fechaperfin;
    }
    
    function getIdped() {
        return $this->idped;
    }
    
    function getRecargo() {
        return $this->recargo;
    }
    
    function getDescuento() {
        return $this->descuento;
    }
    
    function getEmail() { return $this->email; }
    function getFechamail() { return $this->fechamail; }
    function getTipodoc() { return $this->tipodoc; }
    function getTipocom() { return $this->tipocom; }
    function getPercepcioniibb() { return $this->percepcioniibb; }
    function getNetocf21() { return $this->netocf21; }
    function getNetori21() { return $this->netori21; }
    function getNetocf10() { return $this->netocf10; }
    function getNetori10() { return $this->netori10; }
    function getIvacf21() { return $this->ivacf21; }
    function getIvari21() { return $this->ivari21; }
    function getIvacf10() { return $this->ivacf10; }
    function getIvari10() { return $this->ivari10; }
    function getPorcentajeiibb() { return $this->porcentajeiibb; }
    function getNeto() { return $this->neto; }
    function getIva21() { return $this->iva21; }
    function getIVa10() { return $this->iva10; }
    function getFechapago() { return $this->fechapago; }
    function getRem_fecha() { return $this->rem_fecha; }
    function getRem_numero() { return $this->rem_numero; }
    function getRem_importe() { return $this->rem_importe; }
    function getImportepago() { return $this->importepago; }
    function getNogravado() { return $this->nogravado; }
    function getCerrado() { return $this->cerrado; }
    function getCodigodoc() { return $this->codigodoc; }
}

class adm_fis_clave {
  var $id=0;
  var $centro=0;
  var $fecha="";
  var $anomes="";
  var $idcli=0;
  var $tipo="";
  var $ptovta=0;
  var $numero=0;
  var $total=0;
  var $netori21=0;
  var $netori10=0;
  var $netocf21=0;
  var $netocf10=0;
  var $ivari21=0;
  var $ivari10=0;
  var $ivacf21=0;
  var $ivacf10=0;
  var $nogravado=0;
  var $letra="";
  var $cliente="";
  var $direccion="";
  var $nrocuit="";
  var $ciudad="";
  var $tipoiva="";
  var $detalle=array();
  var $cantidad=array();
  var $precio=array();
  var $alicuota=array();
  var $importe=array();
  var $imprimir=array();
  var $totaltotal=0;
  var $idrec="";
  var $tipopago=0;
  var $tipopagodes="";
  var $fechamail="";

    
  function __construct($id) {
    require_once "clases/conexion.php";
    require_once "clases/support.php";
    require_once 'clases/adm_fis_det.php';
    require_once 'clases/adm_cli.php';
    $sup=new support();
    $conx=new conexion();
    $ssql="select * from adm_fis where clave='$id'";
    //echo $ssql."<br>";
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->idcli=$reg->idcli;
    $this->anomes=$reg->anomes;
    $this->fecha=$reg->fecha;
    $this->total=$reg->total;
    $this->tipo=$reg->tipo;
    $this->netori21=$reg->netori21;
    $this->netori10=$reg->netori10;
    $this->netocf21=$reg->netocf21;
    $this->netocf10=$reg->netocf10;
    $this->ivari21=$reg->ivari21;
    $this->ivari10=$reg->ivari10;
    $this->ivacf21=$reg->ivacf21;
    $this->ivacf10=$reg->ivacf10;
    $this->nogravado=$reg->nogravado;
    $this->letra=$reg->letra;
    $this->numero=$reg->numero;
    $this->ptovta=$reg->ptovta;
    $this->imprimir=$reg->imprimir;
    $this->idrec=$reg->idrec;
    $this->fechamail=$reg->fechamail;
    $this->totaltotal=$reg->netori21+$reg->netori10+$reg->netocf21+$reg->netocf10+$reg->ivacf21+$reg->ivacf10+$reg->ivari21+$reg->ivari10+$reg->percepcioniibb;    
    $ssql="select * from adm_fis_det where idfis=".$reg->id;
    $fdet=new adm_fis_det_2($ssql);
    $this->detalle=$fdet->getDetalle();
    $this->cantidad=$fdet->getCantidad();
    $this->precio=$fdet->getPrecio();
    $this->alicuoda=$fdet->getAlicuota();
    $this->importe=$fdet->getImporte();
    $this->cliente=$reg->cliente;
    $this->direccion=$reg->direccion;
    $this->ciudad=$reg->ciudad;
//    $cli=new adm_cli_1($reg->idcli);
//    $zcliente=$cli->getApellido()." ".$cli->getNombre();
//    if($zcliente=="")
//        $zcliente=$cli->getRazonsocial ();
//    $this->cliente=$zcliente;
//    if($cli->getDireccionfac()!="") {
//        $this->direccion=$cli->getDireccionfac();
//        $this->ciudad=$cli->getCiudadfac();
//    } else {
//        $this->direccion=$cli->getCalle()." ".$cli->getNumero();
//        $this->ciudad=$cli->getCiudaddes();
//    }
    $this->tipoiva=$reg->condicioniva;
    $this->nrocuit=$reg->cuit;
    $this->tipodoc=$reg->getTipodoc();
    if($reg->tipopago==0)
        $this->tipopagodes="CONTADO";
    else
        $this->tipopagodes="CUENTA CORRIENTE";
    
  }

  function getId() {
    return $this->id;
  }
  
  function getCentro() {
    return $this->centro;
  }
  
  function getIdcli() {
    return $this->idcli;
  }
  
  function getAnomes() {
    return $this->anomes;
  }
  
  function getFecha() {
    return $this->fecha;
  }
  
  function getTotal() {
      return $this->total;
  }
  
  function getTipo() {
      return $this->tipo;
  }
  
  function getNetori21() {
      return $this->netori21;
  }
  
  function getNetori10() {
      return $this->netori10;
  }
  
  function getNetocf21() {
      return $this->netocf21;
  }
  
  function getNetocf10() {
      return $this->netocf10;
  }
  
  function getIvari21() {
      return $this->ivari21;
  }
  
  function getIvari10() {
      return $this->ivari10;
  }
  
  function getIvacf21() {
      return $this->ivacf21;
      
  }
  
  function getIvacf10() {
      return $this->ivacf10;
  }
  
  function getLetra() {
      return $this->letra;
  }
  
  function getPtovta() {
      return $this->ptovta;
  }
  
  function getNumero() {
      return $this->numero;
  }
  
  function getCliente() {
      return $this->cliente;
  }
  
  function getDireccion() {
      return $this->direccion;
  }
  
  function getCiudad() {
      return $this->ciudad;
  }
  
  function getNrocuit() {
      return $this->nrocuit;
  }
  
  function getTipoiva() {
      return $this->tipoiva;
  }
  
  function getDetalle() {
    return $this->detalle;
  }
  
  function getCantidad() {
    return $this->cantidad;
  }
  
  function getPrecio() {
    return $this->precio;
  }
  
  function getAlicuota() {
    return $this->alicuota;
  }
  
  function getImporte() {
    return $this->importe;
  }
  
  function getImprimir() {
      return $this->imprimir;
  }
  
  function getTotaltotal() {
      return $this->totaltotal;
  }
  
  function getIdrec() {
      return $this->idrec;
  }
  
  function getFechamail() { return $this->fechamail; }
  function getNogravado() { return $this->nogravado; }
  
}


class adm_fis_2 {
    var $id=array();
    var $centro=array();
    var $cliente=array();
    var $direccion=array();
    var $ciudad=array();
    var $tipoiva=array();
    var $condicioniva=array();
    var $condicionivades=array();
    var $email=array();
    var $nrocuit=array();
    var $fecha=array();
    var $anomes=array();
    var $idcli=array();
    var $tipo=array();
    var $ptovta=array();
    var $numero=array();
    var $total=array();
    var $letra=array();
    var $neto=array();
    var $iva=array();
    var $imprimir=array();
    var $tipopago=array();
    var $tipopagodes=array();
    var $totaltotal=array();
    var $importepago=array();
    var $tipodes=array();
    var $numerocae=array();
    var $fechacae=array();
    var $codigodoc=array();
    var $idcuit=array();
    var $fechaperini=array();
    var $fechaperfin=array();
    var $recargo=array();
    var $descuento=array();
    var $det_idart=array();
    var $det_articulo=array();
    var $det_descripcion=array();
    var $det_cantidad=array();
    var $det_precio=array();
    var $det_importe=array();
    var $det_alicuota=array();
    var $det_id=array();
    var $fechamail=array();
    var $percepcioniibb=array();
    var $porcentajeiibb=array();
    var $netori21=array();
    var $netori10=array();
    var $netocf21=array();
    var $netocf10=array();
    var $ivari21=array();
    var $ivari10=array();
    var $ivacf21=array();
    var $ivacf10=array();
    var $tipodes2=array();
    var $neto10=array();
    var $neto21=array();
    var $iva10=array();
    var $iva21=array();
    var $nogravado=array();
    var $cerrado=array();
    var $maxregistros=0;


    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_fis_det.php';
        require_once 'clases/ciudades.php';
        require_once 'clases/adm_cli.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
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
                array_push($this->idcli,$reg->idcli);
                array_push($this->fecha,$reg->fecha);
                array_push($this->anomes,$reg->anomes);
                array_push($this->letra,$reg->letra);
                array_push($this->ptovta,$reg->ptovta);
                array_push($this->numero,$reg->numero);
                array_push($this->tipo,$reg->tipo);
                array_push($this->numerocae,$reg->numerocae);
                array_push($this->fechacae,$reg->fechacae);
                array_push($this->fechamail,$reg->fechamail);
                array_push($this->importepago,$reg->importepago);
                array_push($this->percepcioniibb,$reg->percepcioniibb);
                array_push($this->porcentajeiibb,$reg->porcentajeiibb);
                array_push($this->totaltotal,$reg->total);
                if($reg->tipopago==0)
                    array_push($this->tipopagodes,"CDO");
                else
                    array_push($this->tipopagodes,"CTA");
                switch ($reg->tipo) {
                    case "C":
                        array_push($this->tipodes,"NC");
                        array_push($this->tipodes2,"C");
                        break;
                    case "F":
                        array_push($this->tipodes,"FC");
                        array_push($this->tipodes2,"F");
                        break;
                    case "D":
                        array_push($this->tipodes,"ND");
                        array_push($this->tipodes2,"D");
                        break;
                    case "G":
                        array_push($this->tipodes,"FCE");
                        array_push($this->tipodes2,"F");
                        break;
                    case "I":
                        array_push($this->tipodes,"NDE");
                        array_push($this->tipodes2,"D");
                        break;
                    case "H":
                        array_push($this->tipodes,"NCE");
                        array_push($this->tipodes2,"C");
                        break;
                    default:
                        array_push($this->tipodes,$reg->tipo);
                        array_push($this->tipodes2,"F");
                        break;

                }
                $ssql="select * from adm_fis_det where idfis=".$reg->id;
                $det=new adm_fis_det_2($ssql,$conn);
                $d_imp=$det->getTotal();
                $d_iva=$det->getAlicuota();
                array_push($this->det_idart,$det->getIdart());
                array_push($this->det_articulo,$det->getDetalle());
                array_push($this->det_descripcion,$det->getDetalle());
                array_push($this->det_cantidad,$det->getCantidad());
                array_push($this->det_precio,$det->getPrecio());
                array_push($this->det_importe,$det->getTotal());
                array_push($this->det_alicuota,$det->getAlicuota());
                array_push($this->det_id,$det->getId());
                array_push($this->total,$reg->total);
                if($reg->numerocae>0 and $reg->fechacae!="" and $reg->numero>0)
                    array_push($this->imprimir,1);
                else
                    array_push($this->imprimir,0);
                $cli=new adm_cli_1($reg->idcli, $conn);
                array_push($this->email,$cli->getEmail());
                array_push($this->cliente,$cli->getApellido()." ".$cli->getNombre());
                array_push($this->nrocuit,$cli->getCuit());
                array_push($this->condicionivades,$cli->getCondicionivaabr());
                if($cli->getCuit()==0) {
                    array_push($this->codigodoc,"99");
                } else {
                    if(strlen($cli->getCuit())>=11)
                        array_push($this->codigodoc,"80");
                    else
                        array_push($this->codigodoc,"96");
                }   
                array_push($this->netori21,$reg->netori21);
                array_push($this->netori10,$reg->netori10);
                array_push($this->netocf21,$reg->netocf21);
                array_push($this->netocf10,$reg->netocf10);
                array_push($this->ivari21,$reg->ivari21);
                array_push($this->ivari10,$reg->ivari10);
                array_push($this->ivacf21,$reg->ivacf21);
                array_push($this->ivacf10,$reg->ivacf10);
                array_push($this->iva10,$reg->ivacf10+$reg->ivari10);
                array_push($this->iva21,$reg->ivacf21+$reg->ivari21);
                array_push($this->neto10,$reg->netocf10+$reg->netori10);
                array_push($this->neto21,$reg->netocf21+$reg->netori21);
                array_push($this->nogravado,$reg->nogravado);
                array_push($this->neto,$reg->netocf10+$reg->netori10+$reg->netocf21+$reg->netori21);
                array_push($this->iva,$reg->ivacf10+$reg->ivari10+$reg->ivacf21+$reg->ivari21);
                $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
                array_push($this->cerrado,$conx->getCantidadRegA($ssql, $conn));                  
            }    
        }
    }

    function getDet_importe() {
        return $this->det_importe;
    }

    function getDet_iva() {
        return $this->det_alicuota;
    }
    
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_descripcion() { return $this->det_descripcion; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_articulo() { return $this->det_articulo; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_id() { return $this->det_id; }
    
    
    function getEmail() { return $this->email; }

    function getDireccion() {
        return $this->direccion;
    }

    function getCiudad() {
        return $this->ciudad;
    }

    function getTipoiva() {
        return $this->tipoiva;
    }

    function getId() {
      return $this->id;
    }

    function getCentro() {
      return $this->centro;
    }

    function getIdcli() {
      return $this->idcli;
    }

    function getAnomes() {
      return $this->anomes;
    }

    function getFecha() {
      return $this->fecha;
    }

    function getTotal() {
        return $this->total;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getCodigodoc() {
        return $this->codigodoc;
    }

    function getLetra() {
        return $this->letra;
    }

    function getPtovta() {
        return $this->ptovta;
    }

    function getNumero() {
        return $this->numero;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getTipopago() {
        return $this->tipopago;
    }

    function getTipopagodes() {
        return $this->tipopagodes;
    }

    function getTotaltotal() {
        return $this->totaltotal;
    }

    function getTipodes() {
        return $this->tipodes;
    }

    function getImportepago() {
        return $this->importepago;
    }

    function getCondicionivades() {
        return $this->condicionivades;
    }

    function getCondicioniva() {
        return $this->condicioniva;
    }

    function getNrocuit() {
        return $this->nrocuit;
    }

    function getNumerocae() {
        return $this->numerocae;
    }

    function getFechacae() {
        return $this->fechacae;
    }
    
    function getFechamail() { return $this->fechamail; }
    function getPercepcioniibb() { return $this->percepcioniibb; }
    function getPorcentajeiibb() { return $this->porcentajeiibb; }
    
    function getNetori21() { return $this->netori21; }
    function getNetori10() { return $this->netori10; }
    function getNetocf21() { return $this->netocf21; }
    function getNetocf10() { return $this->netocf10; }
    function getIvari21() { return $this->ivari21; }
    function getIvari10() { return $this->ivari10; }
    function getIvacf21() { return $this->ivacf21; }
    function getIvacf10() { return $this->ivacf10; }
    
    function getTipodes2() { return $this->tipodes2; }

    function getNeto() {
        return $this->neto;
    }
    
    function getIva() {
        return $this->iva;
    }
    
    function getNeto10() {
        return $this->neto10;
    }
    
    function getNeto21() {
        return $this->neto21;
    }
    
    function getIva10() {
        return $this->iva10;
    }
    
    function getIva21() {
        return $this->iva21;
    }
    
    function getNogravado() { return $this->nogravado; }
    function getCerrado() { return $this->cerrado; }
    
    function getMaxRegistros() {
      return $this->maxregistros;
    }
}



class adm_fis_imp {
    var $cantidad=array();
    var $precio=array();
    var $detalle=array();
    var $alicuota=array();
    var $importe=array();
    var $anomes=array();
    var $actividad=array();
    
    function __construct($idrec) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cped_det.php';
        $conx=new conexion();
        $ssql="select * from adm_rec_pag where idrec=$idrec order by id";
        $rs=$conx->getConsulta($ssql);
        while($reg=mysqli_fetch_object($rs)) {
            if($reg->tipo=="A") {
                if($reg->detalle=="Wireless") {
                    $det="SERVICIO INTERNET MES ".substr($reg->anomes,4,2)."/".substr($reg->anomes,0,4);
                    array_push($this->actividad,2);
                } else {
                    $det=$reg->detalle." ".substr($reg->anomes,4,2)."/".substr($reg->anomes,0,4);
                    array_push($this->actividad,3);
                }
                array_push($this->cantidad,1);
                array_push($this->detalle,$det);
                array_push($this->precio,$reg->importe);
                array_push($this->alicuota,21);
                array_push($this->importe,$reg->importe);
                array_push($this->anomes,$reg->anomes);
            } else {
                //$ssql="select adm_cped_det.*, adm_cped.anomes from adm_cped_det, adm_cped where adm_cped_det.idped=".$reg->idcped." and adm_cped.id=adm_cped_det.idped";
                $ssql="select * from adm_cped_det where adm_cped_det.idped=".$reg->idcped." order by id";
                $det=new adm_cped_det_2($ssql, $reg->idcped);
                $dcan=$det->getCantidad();
                $dart=$det->getArticulo();
                $dpre=$det->getPrecio();
                $dano=$det->getAnomes();
                $diva=$det->getIva();
                $rp=$conx->getConsulta($ssql);
                for($i=0;$i<count($dcan);$i++) {
                    array_push($this->cantidad,$dcan[$i]);
                    array_push($this->detalle, strtoupper($dart[$i]));
                    array_push($this->precio,$dpre[$i]);
                    array_push($this->alicuota,$diva[$i]);
                    array_push($this->importe,$dcan[$i]*$dpre[$i]);
                    array_push($this->anomes,$dano[$i]);
                    array_push($this->actividad,1);
                }
            }
        }
       
    }
    
    
    
    function getCantidad() {
        return $this->cantidad;
    }
    
    function getPrecio() {
        return $this->precio;
    }
    
    function getDetalle() {
        return $this->detalle;
    }
    
    function getAlicuota() {
        return $this->alicuota;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getAnomes() {
        return $this->anomes;
    }
    
    function getActividad() {
        return $this->actividad;
    }
}

class adm_fis_corr {
    var $numero=array();
    
    function __construct($fechaini, $fechafin, $ptovta, $letra) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_fis.php';
        $conx=new conexion();
        $ssql="select * from adm_fis where fecha>='$fechaini' and fecha<='$fechafin' and ptovta=$ptovta and letra='$letra' order by numero";
        $fis=new adm_fis_2($ssql);
        $num=$fis->getNumero();
        $ininum=$num[0];
        for($i=0;$i<count($num);$i++) {
            if($ininum!=$num[$i]) {
                array_push($this->numero,$ininum);
                $ininum=$num[$i];
            } else
                $ininum++;
        }
    }
    
    function getNumero() {
        return $this->numero;
    }
}


class adm_fis_rec_2 {
    var $id=array();
    var $centro=array();
    var $cliente=array();
    var $direccion=array();
    var $ciudad=array();
    var $tipoiva=array();
    var $condicioniva=array();
    var $nrocuit=array();
    var $fecha=array();
    var $anomes=array();
    var $idcli=array();
    var $tipo=array();
    var $ptovta=array();
    var $numero=array();
    var $total=array();
    var $netori21=array();
    var $netori10=array();
    var $netocf21=array();
    var $netocf10=array();
    var $ivari21=array();
    var $ivari10=array();
    var $ivacf21=array();
    var $ivacf10=array();
    var $nogravado=array();
    var $letra=array();
    var $neto=array();
    var $iva=array();
    var $imprimir=array();
    var $tipopago=array();
    var $tipopagodes=array();
    var $totaltotal=array();
    var $importepago=array();
    var $tipodes=array();
    var $rec_fecha=array();
    var $maxregistros=0;

    
    function __construct($ssql) {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
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
                array_push($this->idcli,$reg->idcli);
                array_push($this->fecha,$reg->fecha);
                array_push($this->anomes,$reg->anomes);
                array_push($this->total,$reg->total);
                array_push($this->netori21,$reg->netori21);
                array_push($this->netori10,$reg->netori10);
                array_push($this->netocf21,$reg->netocf21);
                array_push($this->netocf10,$reg->netocf10);
                array_push($this->ivari21,$reg->ivari21);
                array_push($this->ivari10,$reg->ivari10);
                array_push($this->ivacf21,$reg->ivacf21);
                array_push($this->ivacf10,$reg->ivacf10);
                array_push($this->nogravado,$reg->nogravado);
                array_push($this->letra,$reg->letra);
                array_push($this->ptovta,$reg->ptovta);
                array_push($this->numero,$reg->numero);
                array_push($this->tipo,$reg->tipo);
                array_push($this->imprimir,$reg->imprimir);
                array_push($this->importepago,$reg->importepago);
                array_push($this->totaltotal,$reg->netori21+$reg->netori10+$reg->netocf21+$reg->netocf10+$reg->ivacf21+$reg->ivacf10+$reg->ivari21+$reg->ivari10);
                array_push($this->neto,$reg->netori21+$reg->netori10+$reg->netocf21+$reg->netocf10);
                array_push($this->iva,$reg->ivari21+$reg->ivari10+$reg->ivacf21+$reg->ivacf10);
                $cli=new adm_cli_1($reg->idcli);
                array_push($this->cliente,$cli->getApellido()." ".$cli->getNombre());
                if($cli->getDireccionfac()!="") {
                    array_push($this->direccion,$cli->getDireccionfac());
                    array_push($this->ciudad,$cli->getCiudadfac());
                } else {
                    array_push($this->direccion,$cli->getCalle()." ".$cli->getNumero());
                    array_push($this->ciudad,$cli->getCiudaddes());
                }
                array_push($this->tipoiva,$cli->getCondicionivades());
                array_push($this->condicioniva,$cli->getCondicioniva());
                array_push($this->nrocuit,$cli->getCuitdni());
                array_push($this->tipopago,-$reg->tipopago);
                if($reg->tipopago==0)
                    array_push($this->tipopagodes,"CDO");
                else
                    array_push($this->tipopagodes,"CTA");
                switch ($reg->tipo) {
                    case "C":
                        array_push($this->tipodes,"NC");
                        break;
                    case "F":
                        array_push($this->tipodes,"FC");
                        break;
                    case "D":
                        array_push($this->tipodes,"ND");
                        break;
                }
                array_push($this->rec_fecha,$reg->rec_fecha);
            }    
        }
    }
  
    function getRec_fecha() {
        return $this->rec_fecha;
    }

    function getDireccion() {
        return $this->direccion;
    }
  
    function getCiudad() {
        return $this->ciudad;
    }
  
    function getTipoiva() {
        return $this->tipoiva;
    }
  
    function getNrocuit() {
        return $this->nrocuit;
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getIdcli() {
        return $this->idcli;
    }

    function getAnomes() {
        return $this->anomes;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTotal() {
        return $this->total;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getNetori21() {
        return $this->netori21;
    }

    function getNetori10() {
        return $this->netori10;
    }

    function getNetocf21() {
        return $this->netocf21;
    }

    function getNetocf10() {
        return $this->netocf10;
    }

    function getIvari21() {
        return $this->ivari21;
    }

    function getIvari10() {
        return $this->ivari10;
    }

    function getIvacf21() {
        return $this->ivacf21;

    }

    function getIvacf10() {
        return $this->ivacf10;
    }

    function getLetra() {
        return $this->letra;
    }

    function getPtovta() {
        return $this->ptovta;
    }

    function getNumero() {
        return $this->numero;
    }

    function getNeto() {
        return $this->neto;
    }

    function getIva() {
        return $this->iva;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getImprimir() {
        return $this->imprimir;
    }

    function getTipopago() {
        return $this->tipopago;
    }

    function getTipopagodes() {
        return $this->tipopagodes;
    }

    function getTotaltotal() {
        return $this->totaltotal;
    }

    function getTipodes() {
        return $this->tipodes;
    }

    function getCondicioniva() {
        return $this->condicioniva;
    }

    function getImportepago() {
        return $this->importepago;
    }
    
    function getNogravado() { return $this->nogravado; }
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

class adm_fis_total_netos {
    var $netocf21=0;
    var $netocf10=0;
    var $netori21=0;
    var $netori10=0;
    var $ivacf21=0;
    var $ivacf10=0;
    var $ivari21=0;
    var $ivari10=0;
//    var $nogravado=0;
    var $totaltotal=0;
    var $subtotal=0;
    var $recargo=0;
    var $descuento=0;
    
    function __construct($total, $tipo, $condicioniva, $recargo, $descuentopor, $descuento, $iva, $tot) {
        $d_iva= unserialize($iva);
        $d_tot= unserialize($tot);

        $this->subtotal=$total;
        $xrec=0;
        $xdes=0;
        $xrec=$total*$recargo/100;
        if($descuentopor>0)
            $xdes=$total*$descuentopor/100;
        else
            $xdes=$descuento;
        
        $total=$total+$xrec-$xdes;
        $this->totaltotal=$total;
        $this->descuento=$xdes;
        $this->recargo=$xrec;

        for($i=0;$i<count($d_iva);$i++) {
            $neto21=0;
            $iva21=0;
            $neto10=0;
            $iva10=0;
            $coef=1 + ($d_iva[$i]/100);
            if($d_iva[$i]==21) {
                $neto21=$d_tot[$i]/$coef;
                $iva21=$d_tot[$i]-$neto21;
            } else {
                $neto10=$d_tot[$i]/$coef;
                $iva10=$d_tot[$i]-$neto10;
            }
            if($tipo=="C") {
                $neto21=$neto21*-1;
                $neto10=$neto10*-1;
                $iva21=$iva21*-1;
                $iva10=$iva10*-1;
            }
            if($condicioniva==3 or $condicioniva==4) {
                if($d_iva[$i]=21) {
                    $this->netori21+=$neto21;
                    $this->ivari21+=$iva21;
                } else {
                    $this->netocf10+=$neto10;
                    $this->ivacf10+=$iva10;
                }
            } else {
                if($d_iva[$i]=21) {
                    $this->netori21+=$neto21;
                    $this->ivari21+=$iva21;
                } else {
                    $this->netocf10+=$neto10;
                    $this->ivacf10+=$iva10;
                }
            }
        }
        
        
    }
    
    function getNetocf21() { return $this->netocf21; }
    function getNetocf10() { return $this->netocf10; }
    function getNetori21() { return $this->netori21; }
    function getNetori10() { return $this->netori10; }
    function getIvacf21() { return $this->ivacf21; }
    function getIvacf10() { return $this->ivacf10; }
    function getIvari21() { return $this->ivari21; }
    function getIvari10() { return $this->ivari10; }
    function getTotaltotal() { return $this->totaltotal; }
    function getSubtotal() { return $this->subtotal; }
    function getRecargo() { return $this->recargo; }
    function getDescuento() { return $this->descuento; }
    
    
}

class adm_fis_fiscal {
    var $fiscal="";
    
    function __construct($id, $conn="0") {
        require_once 'clases/conexion.php';
        require_once 'clases/support.php';
        $sup=new support();
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_fis where id=$id";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            switch ($reg->tipo) {
                case "F":
                    $ff="FC-";
                    break;
                case "C":
                    $ff="NC-";
                    break;
                case "D":
                    $ff="ND-";
                    break;
                case "G":
                    $ff="FCE-";
                    break;
                case "H":
                    $ff="NCE-";
                    break;
                case "I":
                    $ff="NDE-";
                    break;
            }
            $ff=$reg->ptovta."-".$reg->numero;
            
            $this->fiscal=$ff;
        }
    }
    
    function getFiscal() { return $this->fiscal; }
}