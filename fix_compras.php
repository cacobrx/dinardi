<?php
/*
 * Creado el 29/02/2020 10:54:43
 * Autor: gus
 * Archivo: fix_compras.php
 * planbsistemas.com.ar
 */

require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
$conx = new conexion();
$glo = new globalson();
$conn=$conx->conectarBase();

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 11, 6332, 63, '70090454453189', 0, 23896, 0, 0, 2509.0799999999995, 0, 0, 0, 0, 0, 0, 119.48, '2020-02-26', 26524.56, '91df95fdaa0a6189eee3926a5950537d', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1700 or id=1706 or id=1726 or id=1744 or id=1754";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-19', 1, 'A', 3, 6424, 33, '70089182947444', 0, 11121.3, 0, 0, 1167.74, 0, 0, 0, 0, 0, 0, 166.82, '2020-02-19', 12455.86, 'ae7087247425970d479569f669093a33', '2020-02-19', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1636";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6425, 33, '70089183141668', 0, 6261.72, 0, 0, 657.48, 0, 0, 0, 0, 0, 0, 93.93, '2020-02-26', 7013.13, '466f516d6475b174689111b964a643ad', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1647";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6426, 33, '70089183300410', 0, 6554.4, 0, 0, 688.21, 0, 0, 0, 0, 0, 0, 98.32, '2020-02-26', 7340.93, '3d993444552098e863673e7472759cf0', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1656";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6427, 33, '70089183420515', 0, 9045.6, 0, 0, 949.79, 0, 0, 0, 0, 0, 0, 135.68, '2020-02-26', 10131.07, '26dcdb109e26637a5dd0a708c280702b', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1664";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6428, 33, '70089183519424', 0, 3141.6, 0, 0, 329.87, 0, 0, 0, 0, 0, 0, 47.12, '2020-02-26', 3518.59, 'b75faca4f0759a5f02e129ae9ae8a243', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1676";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6429, 33, '7008918364846', 0, 12090, 0, 0, 1269.45, 0, 0, 0, 0, 0, 0, 181.35, '2020-02-26', 13540.8, '05e1b12bfaf206bd1621456f9e48df6c', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1681";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-28', 1, 'A', 3, 6450, 33, '70099462483772', 0, 7819.2, 0, 0, 821.02, 0, 0, 0, 0, 0, 0, 117.29, '2020-03-06', 8757.51, '1afc6cd79b0171754fbb964ff796f4a3', '2020-02-28', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1693";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-17', 1, 'A', 35, 5101, 45, '70082330474673', 0, 14412.4, 0, 0, 1513.3, 0, 0, 0, 0, 0, 0, 72.06, '2020-02-17', 15997.76, 'f9e58372afc9a613c1e2f35227fd4f4c', '2020-02-17', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1696";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6451, 33, '70099462569371', 0, 12164.4, 0, 0, 1277.26, 0, 0, 0, 0, 0, 0, 182.47, '2020-02-26', 13624.13, '5d6fbd702d93adb294584e3d20ac829a', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1712";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-18', 1, 'A', 35, 5109, 45, '70082331510616', 0, 7049, 0, 0, 740.15, 0, 0, 0, 0, 0, 0, 35.24, '2020-02-18', 7824.39, '12023ec6c75737a3fa252aafdbb34430', '2020-02-18', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1715";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-19', 1, 'A', 35, 5112, 45, '70082352688040', 0, 13503.8, 0, 0, 1417.9, 0, 0, 0, 0, 0, 0, 67.51, '2020-02-19', 14989.21, '910ce37ba51ee36f6273a11916e788f6', '2020-02-19', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1725";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (, '2020-02-26', 1, 'A', 27, 2500, 3, '700914665000094', 0, 12166.8, 0, 0, 1277.51, 0, 0, 0, 0, 0, 0, 182.5, '2020-02-26', 13626.81, '91471d884d5e30b74b909d94c6f8a886', '2020-02-26', 1, )";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1727";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 3, 6452, 33, '70099462645161', 0, 13575, 0, 0, 1425.38, 0, 0, 0, 0, 0, 0, 203.63, '2020-02-26', 15204.01, 'ed8d2c2f7523e6c4ed490c63884cf038', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1731";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-20', 1, 'A', 35, 5117, 45, '70082353991153', 0, 17360, 0, 0, 1822.8, 0, 0, 0, 0, 0, 0, 86.8, '2020-02-20', 19269.6, '387a4e3dc66ce63c71004dd2f5e7d792', '2020-02-20', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1743";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-21', 1, 'A', 35, 5118, 45, '70082354027685', 0, 20057.6, 0, 0, 2106.05, 0, 0, 0, 0, 0, 0, 100.28, '2020-02-21', 22263.93, '2111a1c297c637fcbdb76b29a5bf38a5', '2020-02-21', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1756";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 0537, 9295, 12, '70099463256304', 0, 12366, 0, 0, 1298.43, 0, 0, 0, 0, 0, 0, 62.45, '2020-02-26', 13726.88, 'f6c43e691ba5827abfdcf54bf90264f3', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=1148 where id=1765";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 1, 22370, 2, '70094441374604', 0, 14985, 0, 0, 1573.43, 0, 0, 0, 0, 0, 0, 77.71, '2020-02-26', 16636.14, 'a84781b4ff406b11977123b64b755358', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=$idcom where id=1767";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-26', 1, 'A', 537, 9305, 12, '70099481539499', 0, 2376, 0, 0, 249.48, 0, 0, 0, 0, 0, 0, 11.88, '2020-02-26', 2637.36, 'c274d5b971b9e7380f455b6cf1181ded', '2020-02-26', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=1148 where id=1776";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";

$ssql="insert into adm_com (centro, fecha, tipocom, letra, ptovta, numero, idprv, cainro, neto21, neto10, neto27, iva21, iva10, iva27, impinternos, nogravado, exento, periva, retiva, perretiibb, fechaven, totaltotal, clave, fechaimputacion, tipo, usuario) values (1, '2020-02-25', 1, 'A', 537, 9284, 12, '70089427007098', 0, 11103.7, 0, 0, 1165.8885, 0, 0, 0, 0, 0, 0, 55.52, '2020-02-25', 12325.1085, 'b94eb5ab9cb1a87a19581a3a7ee371ac', '2020-02-25', 1, 8)";
$conx->consultaBase($ssql, $conn);
$idcom=$conx->getLastId("adm_com", $conn);
echo $ssql."<br>";
$ssql="update adm_rem set idcom=1148 where id=1783";
$conx->consultaBase($ssql, $conn);
echo $ssql."<br>";



?>
