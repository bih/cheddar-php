<?php
require 'Cheddar.php';

// First @param is your Application ID [required]
// Second @param is your Application Secret [required]
// Third @param is your Access Token [optional]
$cheddar = new Cheddar_PHP( 'empty', 'empty', 'b0a15ce8a3b9b26f365fc129900ac326' );

// If you did not put your Access Token earlier, you should put it here (unless authentication is not required)
// $res = $cheddar->call('/v1/lists', 'b0a15ce8a3b9b26f365fc129900ac326');

// And if you did put the Access Token in earlier, you don't need to.
$res = $cheddar->call('/v1/lists');

//$res = $cheddar->call('/v1/lists/5407');
//$res = $cheddar->call('/v1/users/3373');

header('Content-Type: text/javascript');
print_r($res);