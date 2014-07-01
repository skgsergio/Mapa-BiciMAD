<?php
function gtfo($code = "", $msg = "") {
  if (($code != "") && ($msg != "")) {
    @header("HTTP/1.0 ".$code);
    @die("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html><head>\n<title>".$code."</title>\n</head><body>\n<p>".$msg."</p>\n</body></html>");
  } else {
    @header("HTTP/1.0 404 Not Found");
    @die("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html><head>\n<title>404 Not Found</title>\n</head><body>\n<h1>Not Found</h1>\n<p>The requested URL " . $_SERVER["REQUEST_URI"] . " was not found on this server.</p>\n</body></html>");
  }
}

if(!defined('MapaBiciMADInc')) gtfo();

// Clave secreta para el HMAC
$bm_secretkey = "Cambia esta linea :)";

// Algoritmo de hash
$bm_hashalg = 'sha256';

// Datos estáticos del cliente para el fingerprint
$bm_staticfp = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];

// URL de get_all_estaciones.php
$bm_getallestaciones = "http://5.56.56.139:16080/functions/get_all_estaciones.php";
?>
