<?php
define('MapaBiciMADInc', TRUE);
require 'config.inc.php';

/* Cutre protección de referer */
if (@strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST']) == false)
  gtfo("509 Bandwidth Limit Exceeded",
       "Por favor, no uses mi ancho de banda.<br />El c&oacute;digo fuente est&aacute; disponible en: <a href=\"https://github.com/skgsergio/Mapa-BiciMAD\">https://github.com/skgsergio/Mapa-BiciMAD</a>");

/* Cutre protección por token */
if (!isset($_GET['sid'])) gtfo();

$dec = @base64_decode(@rawurldecode($_GET['sid']), true);
if ($dec == false) gtfo();

list($tm, $fp) = @explode("#", $dec, 2);
if (($tm == false) || ($fp == false) ||
    (@time() - $tm > 120) ||
    ($fp != @hash_hmac($bm_hashalg, $tm . $bm_staticfp . $tm, $bm_secretkey))) {
  gtfo();
}

/* Obtención de los datos */
$estaciones = @file_get_contents($bm_getallestaciones);
if ($estaciones == false) gtfo();

echo $estaciones;
?>
