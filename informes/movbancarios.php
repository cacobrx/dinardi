<?php
/*
 * creado el 10 ene. 2022 10:29:40
 * Usuario: gus
 * Archivo: movbancarios
 */

class movbancarios {
    var $fecha=array();
    var $importe=array();
    var $detalle=array();
    
    function __construct($fechaini, $fechafin, $tipo) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $cadena=array();
        $conn=$conx->conectarBase();
        if($tipo==0 or $tipo==2) {
            $ssql="select adm_opg2.*, adm_opg1.fecha, adm_prv.apellido from adm_opg2 inner join adm_opg1 on adm_opg2.idop=adm_opg1.id inner join adm_prv on adm_opg1.idprv=adm_prv.id where adm_opg1.fecha>='$fechaini' and adm_opg1.fecha<='$fechafin' and left(upper(detalle),4)='TRAN'";
            //echo $ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($cadena, $reg->fecha."|OP: ".$reg->idop." ".$reg->apellido."|-".$reg->importe);
            }
        }
        
        // cheques propios debitados
        if($tipo==0 or $tipo==2) {
            $ssql="select * from adm_che where fechadeb>='$fechaini' and fechadeb<='$fechafin'";
            //echo $ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($cadena,$reg->fechadeb."|Ch. Propio ".$reg->nrocheque." ".$reg->destinatario."|-".$reg->importe);
            }
        }
        
        // cheques terceros acreditados
        if($tipo==0 or $tipo==1) {
            $ssql="select adm_cht.*, adm_cli.apellido from adm_cht inner join adm_cli on adm_cht.idcli=adm_cli.id where fechaacr>='$fechaini' and fechaacr<='$fechafin'";
//            echo $ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                $banco=$conx->getTextoValorA($reg->idbanco, "BAN", $conn);
                array_push($cadena,$reg->fechaacr."|Ch. Terceros $banco ".$reg->nrocheque." ".$reg->apellido."|".$reg->importe);
            }
        }
        
        sort($cadena);
//        print_r($registro);
        $sal=0;
        for($i=0;$i<count($cadena);$i++) {
            $datos=  explode("|", $cadena[$i]);
            array_push($this->fecha,$datos[0]);
            array_push($this->detalle,$datos[1]);
            array_push($this->importe,$datos[2]);
        }
        
    }
    
    function getFecha() { return $this->fecha; }
    function getDetalle() { return $this->detalle; }
    function getImporte() { return $this->importe; }
}