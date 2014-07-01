<?php
define('MapaBiciMADInc', TRUE);
require 'config.inc.php';

$tm = @time();
$fp = @hash_hmac($bm_hashalg, $tm . $bm_staticfp . $tm, $bm_secretkey);
$enc = @rawurlencode(@base64_encode($tm . "#" . $fp));
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta charset="utf-8" />
    <title>BiciMAD #OpenData</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;libraries=places"></script>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="main.js"></script>
  </head>
  <body>
    <input id="sid" type="hidden" value="<?php echo $enc; ?>" />
    <input id="pac-input" class="controls" type="text" placeholder="B&uacute;squeda..." />
    <div id="map-canvas"></div>
  </body>
</html>
