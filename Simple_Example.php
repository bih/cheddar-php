<?php
/****************************************

  \\\\\\\\\ \\   \\ \\\\\\\  \\\\\\   \\\\\\   \\\\\\\\\\  \\\\\\\\
  \\\        \\   \\ \\   \\  \\   \\  \\   \\          \\  \\    \\
  \\          \\\\\\\ \\\\\\\  \\    \\ \\    \\ \\\\\\\\\\  \\\\\\\
   \\\         \\   \\ \\       \\   \\  \\   \\  \\      \\  \\    \\
    \\\\\\\\\\  \\   \\ \\\\\\\  \\\\\\   \\\\\\   \\\\\\\\\\  \\    \\


  Cheddar_PHP is a PHP library that works directly with the Cheddarapp.com API.
  It is released open source under the MIT license, and I welcome all contributions through Github.
  
  Version: 1.1.0
  GitHub repository: http://github.com/bilawal360/cheddar-php
  Author website: http://bilaw.al/

  See LICENSE for full information on the license.
  
*****************************************/

require "Cheddar.php";

$cheddar = new Cheddar\API('app_id=APP ID HERE&app_secret=APP SECRET HERE');

if(! $access_token = $cheddar->get_access_token()) {
	$cheddar->authorize();
}

// insertIntoDatabase($access_token);

echo 'Cheddar_PHP says hi to ' . $cheddar->call('/v1/me')->username;
