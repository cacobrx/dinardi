<?php
/*
 * Creado el 13/03/2019 14:07:01
 * Autor: gus
 * Archivo: adm_crem_det.php
 * planbsistemas.com.ar
 */

class adm_crem_det_2 {
    var $id=array();
    var $idrem=array();
    var $idpro=array();
    var $cantidad=array();
    var $precio=array();
    var $importe=array();
    var $articulo=array();
    var $recipiente=array();
    var $alicuota=array();
    var $total=0;
    var $maxregistros=0;
    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prd.php';
        require_once 'clases/adm_cli_pre.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
            $tot=0;
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->idrem,$reg->idrem);
                array_push($this->idpro,$reg->idpro);
                array_push($this->cantidad,$reg->cantidad);
                array_push($this->precio,$reg->precio);
                array_push($this->recipiente, $reg->recipiente);
                $art=new adm_prd_1($reg->idpro,$conn);       
                array_push($this->articulo,$art->getDescripcion());
                array_push($this->importe,$reg->cantidad*$reg->precio);
                $tot+=$reg->cantidad*$reg->precio;
                $ssql="select * from adm_crem where id=".$reg->idrem;
                $rr=$conx->consultaBase($ssql, $conn);
                $rrr=mysqli_fetch_object($rr);
                $pre=new adm_cli_pre_1($rrr->idcli, $reg->idpro, $conn);
                array_push($this->alicuota,$pre->getAlicuota());
            }
            $this->total=$tot;
        }
    }

    function getId() { return $this->id; }
    function getIdrem() { return $this->idrem; }
    function getCantidad() { return $this->cantidad; }
    function getIdpro() { return $this->idpro; }
    function getArticulo() { return $this->articulo; }
    function getPrecio() { return $this->precio; }
    function getImporte() { return $this->importe; }
    function getTotal() { return $this->total; }
    function getRecipiente() { return $this->recipiente; }
    function getAlicuota() { return $this->alicuota; }
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}
