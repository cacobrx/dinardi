<?php
/*
 * Created on 12/08/2008 - 08:05:10
 * Author: Gustavo
 * File: support.php
 */

class support {
  function getArrayJS($arr) {
    $arrayjs="['";
    for($i=0;$i<count($arr);$i++) {
      $arrayjs.=$arr[$i]."','";
    }
    $arrayjs=substr($arrayjs,0,strlen($arrayjs)-2)."]";    
    return $arrayjs;
  }
  
  function cargaCombo($ssql,$id) {
    require_once("conexion.php");
    $base=new conexion();
    if($id==0)
    	echo "<option value=''>[Seleccione]</option>";
    $rs=$base->getConsulta($ssql);
    //echo $ssql."<br>";
    while($reg=mysqli_fetch_object($rs)) {
      if($reg->id==$id)
        echo "<option selected value=".$reg->id.">".$reg->campo."</option>";
      else
        echo "<option value=".$reg->id.">".$reg->campo."</option>";
    }
  }
  
  function cargaCombo3($ssql,$id, $cartel='', $codigo0='') {
    require_once("conexion.php");
    $base=new conexion();
    $rs=$base->getConsulta($ssql);
    //echo $ssql."<br>";
    if($cartel!="")
    	echo "<option value=''>[$cartel]</option>";
    if($codigo0!="") {
        if($id=="0")
            echo "<option selected value=0>$codigo0</option>";
        else
            echo "<option value=0>$codigo0</option>";
    }
    while($reg=mysqli_fetch_object($rs)) {
      if($reg->id==$id)
        echo "<option selected value='".$reg->id."'>".$reg->campo."</option>";
      else
        echo "<option value='".$reg->id."'>".$reg->campo."</option>";
    }
  }

  function cargaComboArray($array, $valor=0, $cartel="") {
    if($cartel!="")
        echo "<option value=''>[$cartel]</option>";
    for($i=0;$i<count($array);$i++) {
        if($valor==$array[$i]) 
            echo "<option selected value=".$array[$i].">".$array[$i]."</option>";
        else
            echo "<option value=".$array[$i].">".$array[$i]."</option>";
    }
  }  

  function cargaComboArrayValor($array, $avalor, $valor=0, $cartel="") {
    if($cartel!="")
        echo "<option value=''>[$cartel]</option>";
    for($i=0;$i<count($array);$i++) {
        if($valor==$avalor[$i]) 
            echo "<option selected value='".$avalor[$i]."'>".$array[$i]."</option>";
        else
            echo "<option value='".$avalor[$i]."'>".$array[$i]."</option>";
    }
  }  
  
  
  function cargaComboDepartamento($cliente, $idequ) {
  	require_once 'conexion.php';
  	require_once 'tmt_maq.php';
  	$conx=new conexion();
  	echo "<option value=0>No Ingresado</option>";
  	$ssql="select * from tmt_maq where idcli=$cliente";
  	$maq=new tmt_maq_2($ssql);
  	$m_id=$maq->getId();
  	$m_equ=$maq->getEquipamientodes();
  	$m_mar=$maq->getMarcades();
  	$m_mod=$maq->getModelodes();
  	for($i=0;$i<count($m_id); $i++) {
  		if($m_id[$i]==$idequ)
  			echo "<option selected value=".$m_id[$i].">".$m_equ[$i]." ".$m_mar[$i]." ".$m_mod[$i]."</option>";
  		else
  			echo "<option value=".$m_id[$i].">".$m_equ[$i]." ".$m_mar[$i]." ".$m_mod[$i]."</option>";
  	}
  	
  }
    
  function cargaComboDia($centro,$iddia) {
    require_once("conexion.php");
    require_once 'datesupport.php';
    $dsup=new datesupport();
    $base=new conexion();
    $a_dias=array();
    $a_id=array();
    $ssql="select * from edd_dia where centro=$centro";
    $rs=$base->getConsulta($ssql);
    //echo $ssql."<br>";
    while($reg=mysqli_fetch_object($rs)) {
    	array_push($a_dias,$dsup->getDiasemana($reg->dia1)." ".$dsup->getDiasemana($reg->dia2)." ".$dsup->getDiasemana($reg->dia3)."|".$reg->id);
    }
    sort($a_dias);
    for($j=0;$j<count($a_dias);$j++) {
    	$datos=explode('|', $a_dias[$j]);
		if($datos[1]==$iddia)
        	echo "<option selected value=".$datos[1].">".$datos[0]."</option>";
      	else
        	echo "<option value=".$datos[1].">".$datos[0]."</option>";
    }
  }
  
  
  function cargaComboC($ssql,$id) {
    require_once("conexion.php");
    $base=new conexion();
    $rs=$base->getConsulta($ssql);
    while($reg=mysqli_fetch_object($rs)) {
      if($reg->id==$id)
        echo "<option selected value='".$reg->id."'>".$reg->campo."</option>";
      else
        echo "<option value='".$reg->id."'>".$reg->campo."</option>";
    }
  }  
  
  function getCargaComboIniFin($inicio, $final, $dato=0) {
      for($i=$inicio;$i<=$final;$i++) {
          if($dato==$i)
              echo "<option selected value=$i>$i</option>";
          else
              echo "<option value=$i>$i</option>";
      }
  }
  
  function getArrayRubros() {
    require_once("conexion.php");
    $conexion=new conexion();
    $rr13=array();
    $ssql="select * from subrubros order by rubro";
    $rs=$conexion->getConsulta($ssql);
    while($reg=mysqli_fetch_object($rs)) {
      $r="rr".$reg->rubro;
      echo $r;
      array_push($$r,$reg->subrubro);
    }
    print_r($rr13);
  }
  
  function Resize($image,$new_width,$new_height=0) {
    
    $old_width = imagesx($image);
    $old_height= imagesy($image);
    //if($old_height>$old_width) {
    //	$aux=$old_height;
    //	$old_height=$old_width;
    //	$old_width=$aux;
    //}
    if($new_height==0) // if the height is not specified....calculate the relative height
      $new_height= $new_width * $old_height / $old_width ;
    //if($old_width>$old_height) {
      $new_image= imagecreatetruecolor($new_width, $new_height);
      imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);
    //} else {
    //  $new_image= imagecreatetruecolor($new_height, $new_width);
    //  imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_height, $new_width, $old_height, $old_width);
    //}
    return $new_image;
  }            

  function setVistaAvisos($ssql,$n) {
    require_once("conexion.php");
    $conx=new conexion();
    if($conx->getCantidadReg($ssql)==0) {
      $ssql="update avisos set visto=0 where destacado=$n";
      $conx->getConsulta($ssql);
    }
    return 1;
  }

  function setVistaAvisosOk($ids) {
    if(count($ids)>0) {
      require_once("conexion.php");
      $conx=new conexion();
      $cad="update avisos set visto=1 where ";
      for($i=0;$i<count($ids);$i++)
        $cad.=" id=".$ids[$i]." or ";
      $cad=substr($cad,0,strlen($cad)-4);
      $conx=$conx->getConsulta($cad);
    }
    return 1;
  }
  
  function getRandomize($can,$n) {
    require_once("conexion.php");
    $conx=new conexion();
    $ssql="select avisos.* from avisos,clientes where avisos.cliente=clientes.id and clientes.fecha>='". date('Y-m-d H:i:s')."' and avisos.destacado=$n and avisos.publicar=1 order by id";
    //$ssql="select avisos.* from avisos,clientes where avisos.cliente=clientes.id and fecha>='". date('Y-m-d H:i:s')."' order by id";
    $a_idp=array();
    $a_id=array();
    //echo $ssql."<br>";
    if($conx->getCantidadReg($ssql)>0) {
      if($conx->getCantidadReg($ssql)<$can)
        $can=$conx->getCantidadReg($ssql);
      $rs=$conx->getConsulta($ssql);
      while($reg=mysqli_fetch_object($rs))
        array_push($a_id,$reg->id);
      $ini=0;
      $fin=count($a_id)-1;
      $a_idp=array();
      $i=1;
      while($i<=$can) {
        $rnd=rand($ini,$fin);
        $clave=array_search($a_id[$rnd],$a_idp);
        $j=$i-1;
        if($clave===false) {
          array_push($a_idp,$a_id[$rnd]);
          $i++;
        }
      }
    }
    return $a_idp;
  }
  
 	function getFechaNormal($fec) {
 		if(strlen($fec>8)) {
	 		list($year,$month,$day) = split ('-',$fec);
	 		$dffin=$day."/".$month."/".$year;
 		} else
 			$dffin="";
 		return $dffin;
 	}   
 	
 	function getFechaHoraNormal($fec) {
 		if(strlen($fec)>=19 && $fec!="0000-00-00 00:00:00") {
 			$nfec=date("d/m/Y H:i",strtotime($fec));
 		} else {
 			$nfec="";
 		}
 		return $nfec;
 	}
 	
 	
  function isDate($fec) {
   	$stamp = strtotime( $fec );
    if (!is_numeric($stamp))  	
      return true;
    else
      return false;
  }
 	
 	function getPreguntasAContestar($id) {
   	require_once("conexion.php");
   	$conx=new conexion();
   	$ssql="select count(*) as cantidad from preguntas where aviso=$id and autorizado=1 and fechar is NULL";
   	$rs=$conx->getConsulta($ssql);
   	$reg=mysqli_fetch_object($rs);
   	return $reg->cantidad;
 	}
 	
 	function getLastPregunta($id) {
   	require_once("conexion.php");
   	$conx=new conexion();
   	$ssql="select * from preguntas where aviso=$id order by id desc";
   	$rs=$conx->getConsulta($ssql);
   	$reg=mysqli_fetch_object($rs);
   	return $reg->id;
 	}
 	
 	function getCadEspacios($cad,$tipo,$largo) {
   	$largo--;
   	$espacios="                                                                                            ";
   	$cadesp=substr($espacios,0,$largo);
   	$lcad=strlen($cad);
   	if($tipo==0) {
     	$ret=substr($cadesp,0,$largo - $lcad).$cad;
   	} else {
     	$ret=$cad.substr($cadesp,0,$largo - $lcad);
   	}
   	return $ret;
 	}
  
  function getNuevoOrden($empre) {
    require_once("clases/conexion.php");
    $conx=new conexion();
    $ssql="select count(*) as nuevoorden from man_productos where empresa=$empre";
    //echo $ssql."<br>";
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $oorr=$reg->nuevoorden;
    $oorr++;
    return $oorr;
  }
  
  function generateKey(){//Generate a unique key
    $key = md5(uniqid(mt_rand(), false));
    return $key;
}
    

/*! 
  @function num2letras () 
  @abstract Dado un n?mero lo devuelve escrito. 
  @param $num number - N?mero a convertir. 
  @param $fem bool - Forma femenina (true) o no (false). 
  @param $dec bool - Con decimales (true) o no (false). 
  @result string - Devuelve el n?mero escrito en letra. 

*/ 
function num2letras($num, $fem = false, $dec = true) { 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack --> return ucfirst($tex);
   //$end_num=ucfirst($tex).' pesos '.$float[1].'/100 M.N.';
   $end_num=ucfirst($tex).' pesos con '.$float[1].' ctvs.-';
   return $end_num; 
} 

function Obtener_Descripcion($valor, $a_id, $a_des) {
    $search=array_search($valor, $a_id);
    if($search===false)
        $ret="";
    else
        $ret=$a_des[$search];
    return $ret;
    
}

function Obtener_Id($valor, $a_id, $a_des) {
//    echo "valor: $valor<br>";
//    //print_r($a_des);
//    for($i=0;$i<count($a_des);$i++) {
//        echo strlen($a_des[$i])." || ".strlen($valor)." || ";
//        echo $a_des[$i]." == ".$valor."<br>";
//        if($a_des[$i]==$valor) {
//            echo "esta<br>";
//            break;
//        }
//        
//    }
    $search=array_search($valor, $a_des);
    if($search===false)
        $ret=0;
    else
        $ret=$a_id[$search];
    return $ret;
    
}

    function AddZeros($num,$len) {
        $zero="";
        for($i=0;$i<$len;$i++) {
            $zero.="0";
        }
        $ret=substr($zero,0,$len-strlen($num)).$num;
        return $ret;
    }
    
    function AddSpaces($cad,$len) {
        if(strlen($cad)>$len)
            $ret=substr($cad,0,$len);
        else {
            $space="";
            for($i=0;$i<$len;$i++) {
                $space.=" ";
            }
            $ret=$cad.substr($space,0,$len-strlen($cad));
        }
        //echo strlen($ret)."<br>";
        return $ret;
    }

    function SanearCaracteres($string) {
        $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string ); 
        $string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string ); 
        $string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string ); 
        $string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string ); 
        $string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string ); 
        $string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string );    
        return $string;
    }
    
    function DigitoFiscal($cad) {
        $acad=  str_split($cad);
        $acad1=array();
        $acad2=array();
        for($i=0;$i<count($acad);$i++) {
            if(fmod($i,2)==0)
                array_push($acad2,$acad[$i]);
            else
                array_push($acad1,$acad[$i]);
        }
//        print_r($acad);
//        print_r($acad1);
//        print_r($acad2);
        
        $suma1=array_sum($acad1);
        $suma2=array_sum($acad2);
        $sumatotal=$suma1*3+$suma2;
//        echo $suma1."<br>";
//        echo $suma2."<br>";
//        echo $sumatotal."<br>";
        $dv=0;
        while(fmod($sumatotal,10)!=0) {
            $dv++;
            $sumatotal++;
        }
//        echo "dv: $dv";
        return $dv;
    }
    
    
    function cargarmaterias() {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_mat order by anocursada, nombre";
        $rs=$conx->getConsulta($ssql);
        $respuesta="";
        while($reg= mysqli_fetch_object($rs)) {
            $respuesta .= '<li id="mat.$reg->id.">'.utf8_encode($reg->nombre).'</li>';
            
        }
        return $respuesta;
    }
    
    function getNuevocodigo($tipo, $val="") {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $codigofinal="";
//        echo "tipo: $tipo | val: $val<br>";
        $ssql="select * from adm_clasif where tipo='$tipo'";
        if($val!="") $ssql.=" and left(codigodep, length('$val'))='$val'";
        $ssql.=" order by codigodep desc limit 1";
//        echo "aa: ".$ssql."<br>";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $numero=substr($reg->codigodep,strlen($reg->codigodep)-3,3);
            $numero++;
            $numero=$this->AddZeros($numero, 3);
            $codigofinal=substr($reg->codigodep,0,strlen($reg->codigodep)-3).$numero;
        } else
            $codigofinal=$val."001";
        return $codigofinal;
    }
    
    function getUltimoRecibo() { 
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $numero=0;
        $ssql="select * from adm_crec1 order by numero desc limit 1";
        if($conx->getCantidadReg($ssql)>0) {
            $rs=$conx->getConsulta($ssql);
            $reg=mysqli_fetch_object($rs);
            $numero=$reg->numero;
        }
        $numero++;
        return $numero;
    }
    
function generar_color($rgb){
    $rgb=substr($rgb,1,6);
    //extrec les 3 parts del color:
    $vermell= substr($rgb,1,2);
    $verd = substr($rgb,3,2);
    $blau = substr($rgb,5,2);
    
    //Converteixo de hexadecimal a decimal
    $enter_vermell= hexdec($vermell);
    $enter_verd= hexdec($verd);
    $enter_blau= hexdec($blau);
    
    $umbralcolor=$enter_vermell+$enter_verd+$enter_blau;
//    echo $umbralcolor."<br>";
    $umbralcolor=$umbralcolor/3;
//    echo $rgb." ".$umbralcolor."<br>";
    //Valor que li sumarem o restarem a cada component rgb:
    $valor = hexdec(22);
    
    //Calculo l'umbral del color.
    $umbral = 255/2; //7F en hexadecimal.
//    echo $umbral."<br>";
    
    //Calculo la foscor del color entrat:
    $foscor= ($enter_vermell + $enter_verd + $enter_blau) /3;
    
    //El color és clar. Per tant tenim que enfosquirlo restant-li el $valor en cada component rgb.
    if($foscor >= $umbral){
        $enter_vermell = ($enter_vermell-$valor<00) ? 00 : $enter_vermell-$valor;
        $enter_verd = ($enter_verd-$valor<00) ? 00 : $enter_verd-$valor;
        $enter_blau = ($enter_blau-$valor<00) ? 00 : $enter_blau-$valor;
        //if($enter_vermell-$valor<00){ $nou_enter_vermell = 00; } else { $enter_vermell=$enter_vermell-$valor; }
        //if($enter_vermell-$valor<00){ $nou_enter_vermell = 00; } else { $enter_vermell=$enter_vermell-$valor; }
    }
    
    //El color és fosc. Per tant tenim que aclararlo sumant-li el $valor en cada component rgb.
    else{
        $enter_vermell = ($enter_vermell+$valor>255) ? 255 : $enter_vermell+$valor;
        $enter_verd = ($enter_verd+$valor>255) ?  255 : $enter_verd+$valor;
        $enter_blau = ($enter_blau+$valor>255) ?  255 : $enter_blau+$valor;
    }
    $vermell=dechex($enter_vermell);
    $verd=dechex($enter_verd);
    $blau=dechex($enter_blau);
    
    $rgb="#".$vermell.$verd.$blau;
    if($umbralcolor>80) $ccolor="white"; else $ccolor="black";
    return $ccolor;
}     

}
?>
