<?
class debug {
  function WriteLog($cad, $archivo) {
    $fp = fopen($archivo,"a");
    fwrite($fp, date("Y-m-d H:i:s")." ".$cad."\n", 1000);
    fclose($fp);
    return 1;
  }
}
?>