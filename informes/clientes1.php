<?php
/*
 * Creado el 11/07/2019 19:01:44
 * Autor: gus
 * Archivo: clientes.php
 * planbsistemas.com.ar
 */

class ctacte_clientes {
    var $fecha=array();
    var $detalle=array();
    var $importe=array();
    var $signo=array();
    var $saldo=array();
    var $factura=array();
    var $remito=array();
    
    function __construct($idcli, $fechaini, $fechafin, $fechainicli, $centrosel, $saldoini=0) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_fis.php';
        require_once 'clases/adm_crec.php';
        require_once 'clases/conexion.php';
        $conx=new conexion();
        // saldo inicial antes de la fecha inicial
        
        $ssql="select * from adm_fis where idcli=$idcli and tipo!='C' and fecha>='$fechainicli' and fecha<'$fechaini' order by fecha";
//        echo $ssql."\n";
        $fis=new adm_fis_2($ssql);
        $fis_imp=$fis->getTotaltotal();
//        print_r($fis_imp);
        $ssql="select * from adm_fis where idcli=$idcli and tipo='C' and fecha>='$fechainicli' and fecha<'$fechaini' order by fecha";
        //echo $ssql."<br>";
        $fis=new adm_fis_2($ssql);
        $fisn_imp=$fis->getTotaltotal();
        $totarec=0;
        $ssql="select sum(adm_crec3.importe) as inirec from adm_crec3, adm_crec1 where adm_crec1.idcli=$idcli and adm_crec1.fecha>='$fechainicli' and adm_crec1.fecha<'$fechaini' and adm_crec3.idcrec=adm_crec1.id";
        if($conx->getCantidadReg($ssql)>0) {
            $ri=$conx->getConsulta($ssql);
            $rri=  mysqli_fetch_object($ri);
            $totalrec=$rri->inirec;
        }

        $saldoini=$saldoini + array_sum($fis_imp) - array_sum($fisn_imp) - $totalrec;
        
//        if($fechaini<$fechainicioctacte) $fechaini=$fechainicioctacte;
        
        if($fechaini<$fechainicli) $fechaini=$fechainicli;

        
        $ssql="select * from adm_fis where idcli=$idcli and tipo!='C' and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
//        echo $ssql."<br>";
        $fis=new adm_fis_2($ssql);
        $c_fec=$fis->getFecha();
        $c_num=$fis->getNumero();
        $c_let=$fis->getLetra();
        $c_pto=$fis->getPtovta();
        $c_tip=$fis->getTipo();
        $c_imp=$fis->getTotal();
        $c_per=$fis->getPercepcioniibb();
        $c_id=$fis->getId();
        $ssql="select * from adm_fis where idcli=$idcli and tipo='C' and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
        //echo $ssql."<br>";
        $fis=new adm_fis_2($ssql);
        $x_fec=$fis->getFecha();
        $x_num=$fis->getNumero();
        $x_let=$fis->getLetra();
        $x_pto=$fis->getPtovta();
        $x_tip=$fis->getTipo();
        $x_imp=$fis->getTotal();
        $x_per=$fis->getPercepcioniibb();
        $x_id=$fis->getId();
        $ssql="select * from adm_crec1 where idcli=$idcli and fecha>='$fechaini' and fecha<='$fechafin'";
        $rec=new adm_crec1_2($ssql);
        $o_fec=$rec->getFecha();
        $o_num=$rec->getNumero();
        $o_imp=$rec->getImporte();
        
        $conn=$conx->conectarBase();
        $c_rec=array();
        for($i=0;$i<count($c_fec);$i++) {
            $ssql="select adm_crec2.*, adm_crec1.numero from adm_crec2, adm_crec1 where adm_crec2.idfis=".$c_id[$i]." and adm_crec1.id=adm_crec2.idcrec and adm_crec1.idcli=$idcli";
//            echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql, $conn)>0) {
                $rr=$conx->consultaBase($ssql, $conn);
                $rrr=mysqli_fetch_object($rr);
                array_push($c_rec," - Rec: ".$rrr->numero);
            } else 
                array_push($c_rec,"");
            
        }
        $x_rec=array();
        for($i=0;$i<count($x_fec);$i++) {
            $ssql="select adm_crec2.*, adm_crec1.numero from adm_crec2, adm_crec1 where adm_crec2.idfis=".$x_id[$i]." and adm_crec1.id=adm_crec2.idcrec and adm_crec1.idcli=$idcli";
//            echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql, $conn)>0) {
                $rr=$conx->consultaBase($ssql, $conn);
                $rrr=mysqli_fetch_object($rr);
                array_push($x_rec," - Rec: ".$rrr->numero);
            } else 
                array_push($x_rec,"");
            
        }

        $registro=array();
        if($saldoini!=0) {
            if($saldoini<0)
                array_push($registro, "0000-00-00|Inicial|$saldoini|Recibo");
            else
                array_push($registro, "0000-00-00|Saldo Inicial|$saldoini|Pedido");
        }

        
        for($i=0;$i<count($c_fec);$i++) {
            array_push($registro,$c_fec[$i]."|".$c_num[$i]."|".abs($c_imp[$i])."|Factura|".$c_rec[$i]);
        }
        for($i=0;$i<count($x_fec);$i++) {
            array_push($registro,$x_fec[$i]."|".$x_num[$i]."|".abs($x_imp[$i])."|N.Credito|".$x_rec[$i]);
        }
        for($i=0;$i<count($o_fec);$i++) {
            array_push($registro,$o_fec[$i]."|".$o_num[$i]."|".$o_imp[$i]."|Recibo|");
        }
        
        sort($registro);
//        print_r($registro);
        $sal=0;
        for($i=0;$i<count($registro);$i++) {
            $datos=  explode("|", $registro[$i]);
            //echo $registro[$i]."\n";
            array_push($this->fecha,$datos[0]);
            if($datos[0]=="0000-00-00")
                array_push($this->detalle,"Saldo Inicial");
            else
                array_push($this->detalle,$datos[3]." ".$datos[1]." ".$datos[4]);
            if($datos[3]=="Recibo" or $datos[3]=="Devolucion" or $datos[3]=="N.Credito") {
                $imp=$datos[2];
                array_push($this->signo,"H");
                $sal-=$datos[2];
            } else {
                $imp=$datos[2];
                array_push($this->signo,"D");
                $sal+=$datos[2];
            }
            array_push($this->importe,abs($imp));
            array_push($this->saldo,$sal);
            
        }
        
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getDetalle() {
        return $this->detalle;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
    
    function getSigno() {
        return $this->signo;
    }
    
}

class saldo_clientes {
    var $cliente=array();
    var $telefono=array();
    var $pedidos=array();
    var $recibos=array();
    var $saldo=array();
    var $inicial=array();
    var $idcli=array();
    
    function __construct($fechafin, $versaldocero=0) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_fis.php';
        require_once 'clases/adm_cli.php';
        global $fechainicioctacte;
        $conx=new conexion();
        $ssql="select * from adm_cli order by apellido, nombre";
        $cli=new adm_cli_2($ssql);
        $c_id=$cli->getId();
        $c_ape=$cli->getApellido();
        $c_nom=$cli->getNombre();
        $c_sal=$cli->getSaldoini();
        $c_tel=$cli->getTelefono();
        $saldocli=$cli->getSaldoini();
        $c_fei=$cli->getFechainicioctacte();
        $saldocli=0;
        $conn=$conx->conectarBase();
        for($i=0;$i<count($c_id);$i++) {
            $saldocli=$c_sal[$i];
            
            
            $ssql="select * from adm_fis where idcli=".$c_id[$i]." and tipo!='C' and fecha>='".$c_fei[$i]."' and fecha<='$fechafin' order by fecha";
//            echo $ssql."\n";
            $fis=new adm_fis_2($ssql);
            $fis_imp=$fis->getTotal();
            $fis_per=$fis->getPercepcioniibb();
            $ssql="select * from adm_fis where idcli=".$c_id[$i]." and tipo='C' and fecha>='".$c_fei[$i]."' and fecha<='$fechafin' order by fecha";
            //echo $ssql."<br>";
            $fis=new adm_fis_2($ssql);
            $fisn_imp=$fis->getTotal();
            $fisn_per=$fis->getPercepcioniibb();
            $totarec=0;
            $ssql="select sum(adm_crec3.importe) as inirec from adm_crec3, adm_crec1 where adm_crec1.idcli=".$c_id[$i]." and adm_crec1.fecha>='".$c_fei[$i]."' and adm_crec1.fecha<='$fechafin' and adm_crec3.idcrec=adm_crec1.id";
            if($conx->getCantidadReg($ssql)>0) {
                $ri=$conx->getConsulta($ssql);
                $rri=  mysqli_fetch_object($ri);
                $totalrec=$rri->inirec;
            }
            
//            echo "saldocli: $saldocli<br>";
//            echo "fis_imp: ".array_sum($fis_imp)."<br>";
//            echo "fisn_imp: ".array_sum($fisn_imp)."<br>";
//            echo "totalrec: $totalrec<br>";
//            echo "fis_per: ".array_sum($fis_per)."<br>";
//            echo "fisn_per: ".array_sum($fisn_per)."<br>";
            
            $saldoini=$saldocli + array_sum($fis_imp) - array_sum($fisn_imp) - $totalrec;

            $totfac=array_sum($fis_imp);
            $totrec=$totalrec+array_sum($fisn_imp);
            if($saldocli>0) $totfac+=$saldocli; else $totrec+=abs($saldocli);
            
            
            if($versaldocero==1)
                $pasa=1;
            else {
                if($versaldocero==0 and number_format($saldoini,2,'.','')!=0)
                    $pasa=1;
                else
                    $pasa=0;
            }
            if($pasa==1) {
                array_push($this->cliente,$c_ape[$i]." ".$c_nom[$i]);
                array_push($this->pedidos,$totfac);
                array_push($this->recibos,$totrec);
                array_push($this->saldo,number_format($saldoini,2,'.',''));
                array_push($this->inicial,$c_sal[$i]);
                array_push($this->telefono,$c_tel[$i]);
                array_push($this->idcli,$c_id[$i]);
            }
        }
        
    }
    
    function getCliente() {
        return $this->cliente;
    }
    
    function getPedidos() {
        return $this->pedidos;
    }
    
    function getRecibos() {
        return $this->recibos;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
    
    function getInicial() {
        return $this->inicial;
    }
    
    function getTelefono() {
        return $this->telefono;
    }
    
    function getIdcli() {
        return $this->idcli;
    }
}
