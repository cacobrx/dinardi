<?php
/*
 * Creado el 13/03/2019 13:57:03
 * Autor: gus
 * Archivo: adm_crem.php
 * planbsistemas.com.ar
 */

class adm_crem_1 {
    var $id=0;
    var $fecha='';
    var $idcli=0;
    var $cliente="";
    var $direccion="";
    var $fechaentrega="";
    var $observaciones="";
    var $total=0;
    var $ptovta=0;
    var $numero=0;
    var $controlado=0;
    var $ciudad="";
    var $cuit=0;
    var $condiva="";
    var $patente="";
    var $idfis=0;
    var $fiscal="";
    var $det_id=array();
    var $det_idped=array();
    var $det_idpro=array();
    var $det_cantidad=array();
    var $det_precio=array();
    var $det_importe=array();
    var $det_articulo=array();
    var $det_recipiente=array();

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_crem_det.php';
        require_once 'clases/adm_fis.php';
        require_once 'clases/support.php';
        $sup=new support();
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_crem where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->fecha=$reg->fecha;
        $this->idcli=$reg->idcli;
        $this->ptovta=$reg->ptovta;
        $this->numero=$reg->numero;
        $this->fechaentrega=$reg->fechaentrega;
        $this->observaciones=$reg->observaciones;
        $this->controlado=$reg->controlado;
        $this->patente=$reg->patente;
        $this->idfis=$reg->idfis;
        $cli=new adm_cli_1($reg->idcli,$conn);
        $this->direccion=$cli->getDireccion();
        $this->cliente=$cli->getApellido()." ".$cli->getNombre();
        $this->ciudad=$cli->getCiudaddes();
        $this->cuit=$cli->getCuit();
        $this->condiva=$cli->getCondicionivades();
        $ssql="select * from adm_crem_det where idrem=".$reg->id;
        $det=new adm_crem_det_2($ssql, $conn);
        $this->det_id=$det->getId();
        $this->det_idped=$det->getIdrem();
        $this->det_idpro=$det->getIdpro();
        $this->det_cantidad=$det->getCantidad();
        $this->det_precio=$det->getPrecio();
        $this->det_importe=$det->getImporte();
        $this->det_articulo=$det->getArticulo();
        $this->total=$det->getTotal();
        $this->det_recipiente=$det->getRecipiente();
        if($reg->idfis>0) {
            $fis=new adm_fis_fiscal($reg->idfis, $conn);
            $this->fiscal=$fis->getFiscal();
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCiudad() {
        return $this->ciudad;
    }
    
    function getCuit() {
        return $this->cuit;
    }
    
    function getCondiva() {
        return $this->condiva;
    }
    
    function getIdcli() {
        return $this->idcli;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getCliente() {
        return $this->cliente;
    }
    
    function getDireccion() {
        return $this->direccion;
    }    
  
    function getTotal() {
        return $this->total;
    }
    
    function getPatente() {
        return $this->patente;
    }
    
    function getFechaentrega() { return $this->fechaentrega; }
    function getObservaciones() { return $this->observaciones; }
    function getNumero() { return $this->numero; }
    function getPtovta() { return $this->ptovta; }
    function getControlado() { return $this->controlado; }
    function getIdfis() { return $this->idfis; }
    function getFiscal() { return $this->fiscal; }
    
    function getDet_recipiente() { return $this->det_recipiente; }    
    function getDet_id() { return $this->det_id; }
    function getDet_idped() { return $this->det_idped; }
    function getDet_idpro() { return $this->det_idpro; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_articulo() { return $this->det_articulo; }
}

class adm_crem_2 {
    var $id=array();
    var $fecha=array();
    var $idcli=array();
    var $cliente=array();
    var $direccion=array();
    var $fechaentrega=array();
    var $observaciones=array();
    var $controlado=array();
    var $ptovta=array();
    var $patente=array();
    var $numero=array();
    var $total=array();
    var $det_id=array();
    var $det_idped=array();
    var $det_idpro=array();
    var $det_cantidad=array();
    var $det_precio=array();
    var $det_importe=array();
    var $det_articulo=array();
    var $det_recipiente=array();
    var $det_alicuota=array();
    var $neto0=array();
    var $neto10=array();
    var $neto21=array();
    var $iva10=array();
    var $iva21=array();
    var $fiscal=array();
    var $idfis=array();
    
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_crem_det.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_fis.php';
        $sup=new support();
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
                array_push($this->fecha,$reg->fecha);
                array_push($this->fechaentrega,$reg->fechaentrega);
                array_push($this->idcli,$reg->idcli);
                array_push($this->ptovta,$reg->ptovta);
                array_push($this->numero, $reg->numero);
                array_push($this->observaciones,$reg->observaciones);
                array_push($this->controlado,$reg->controlado);
                array_push($this->idfis,$reg->idfis);
                if($reg->idfis>0) {
                    $fis=new adm_fis_fiscal($reg->idfis, $conn);
                    array_push($this->fiscal,$fis->getFiscal());
                } else
                    array_push($this->fiscal,"");
                $cli=new adm_cli_1($reg->idcli,$conn);
                array_push($this->patente,$reg->patente);
                array_push($this->direccion, $cli->getDireccion());
                array_push($this->cliente,$cli->getApellido()." ".$cli->getNombre());
                $ssql="select * from adm_crem_det where idrem=".$reg->id;
//                echo $ssql;
                $det=new adm_crem_det_2($ssql, $conn);
                array_push($this->det_id,$det->getId());
                array_push($this->det_idped,$det->getIdpro());
                array_push($this->det_idpro,$det->getIdpro());
                array_push($this->det_cantidad,$det->getCantidad());
                array_push($this->det_precio,$det->getPrecio());
                array_push($this->det_importe,$det->getImporte());
                array_push($this->det_articulo,$det->getArticulo());
                array_push($this->det_recipiente, $det->getRecipiente());
                array_push($this->total,$det->getTotal());
                array_push($this->det_alicuota,$det->getAlicuota());
                
                $xneto0=0;
                $xneto10=0;
                $xneto21=0;
                $xiva10=0;
                $xiva21=0;
                
                $xalicuota=$det->getAlicuota();
                $ximporte=$det->getImporte();
                for($x=0;$x<count($xalicuota);$x++) {
                    switch ($xalicuota[$x]) {
                        case 0:
                            $xneto0+=$ximporte[$x];
                            break;
                        case 10.5:
                            $neto=$ximporte[$x]/(1+$xalicuota[$x]/100);
                            $xneto10+=$neto;
                            $xiva=$ximporte[$x]-$neto;
                            $xiva10+=$xiva;
                            break;
                        case 21:
                            $neto=$ximporte[$x]/(1+$xalicuota[$x]/100);
                            $xneto21+=$neto;
                            $xiva=$ximporte[$x]-$neto;
                            $xiva21+=$xiva;
                            break;
                    }
                }
                array_push($this->neto0,$xneto0);
                array_push($this->neto10,$xneto10);
                array_push($this->neto21,$xneto21);
                array_push($this->iva10,$xiva10);
                array_push($this->iva21,$xiva21);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdcli() {
        return $this->idcli;
    }
    
    function getPatente() {
        return $this->patente;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getCliente() {
        return $this->cliente;
    }

    function getDireccion() {
        return $this->direccion;
    }    
  
    function getTotal() {
        return $this->total;
    }
    
    function getDet_id() { return $this->det_id; }
    function getDet_idped() { return $this->det_idped; }
    function getDet_idpro() { return $this->det_idpro; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_articulo() { return $this->det_articulo; }
    function getFechaentrega() { return $this->fechaentrega; }
    function getDet_recipiente() { return $this->det_recipiente; }
    function getDet_alicuota() { return $this->det_alicuota; }
    
    function getNeto0() { return $this->neto0; }
    function getNeto10() { return $this->neto10; }
    function getNeto21() { return $this->neto21; }
    function getIva10() { return $this->iva10; }
    function getIva21() { return $this->iva21; }
    function getPtovta() { return $this->ptovta; }
    function getNumero() { return $this->numero; }
    function getIdfis() { return $this->idfis; }
    function getFiscal() { return $this->fiscal; }
    
    function getControlado() { return $this->controlado; }
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
