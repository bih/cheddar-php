<?php
/*

Cheddar_PHP 1.0.0 built by @bilawalhameed
http://github.com/bilawal360/cheddar-php

`In this version, there's lots of unused things in here. The reason is because when we make updates, no code elsewhere will needed to be changed other than Cheddar.php. We would appreciate your feedback on the code though.`

-------------------------------------------------------------

Copyright (C) 2012 Bilawal Hameed

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

// Once we're stable.
//error_reporting(0);

// We need JSON to decode requests
if(!function_exists('json_encode') || !function_exists('json_decode')) {
	throw new Exception('JSON package not installed.');
}

// If the below is true, Cheddar_PHP is already running. 
if(defined('CHEDDAR_PHP')) {}

class Cheddar_PHP {

	protected $version = '1.0.0';
	protected $api_server = 'https://api.cheddarapp.com';
	
	private $app_id;
	private $app_secret;
	private $access_token;
	
	function __construct( $id, $secret, $token = null ) {
		if(empty($id) or empty($secret))
			return 'You need to register a Cheddar app. Register one at https://cheddarapp.com/developer/apps';
	
		$this->app_id = $id;
		$this->app_secret = $secret;
		$this->access_token = $token ? $token : '';
	}
	
	public function call( $address, $access_token = null ) {
		return $this->update( $address, null, $access_token);
	}
	
	public function update( $address, $post, $access_token = null ) {
		if($access_token == null && $this->access_token)
			$access_token = $this->access_token;
	
		return $this->http( $address, $post, array( 'Authorization: Bearer '. $access_token ) );
	}
	
	/* This makes the HTTP connection to the REST API */
	private function http($uri, $post = null, $header = null)
	{
		if( ! function_exists('curl_init') )
			die("You need CURL to use Cheddar_PHP");
			 
		$resource = curl_init();
		curl_setopt($resource, CURLOPT_URL, $this->api_server.$uri );
		curl_setopt($resource, CURLOPT_REFERER, 'http://github.com/bilawal360/cheddar-php');
		curl_setopt($resource, CURLOPT_USERAGENT, 'Cheddar_PHP');
			
		curl_setopt($resource, CURLOPT_HEADER, false);
		curl_setopt($resource, CURLOPT_NOBODY, false);
		curl_setopt($resource, CURLOPT_MAXREDIRS, 2);
		
		if( is_array($this->post) ) /* A standard post */
			curl_setopt($resource, CURLOPT_POST, true);
			curl_setopt($resource, CURLOPT_POSTFIELDS, $this->post); 
			
		/* This is to allow the script to send additional headers */
		if(is_array($header))
			curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
			
		curl_setopt($resource, CURLOPT_FRESH_CONNECT, false);
		curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, false);
		
		curl_setopt($resource, CURLOPT_TIMEOUT, 15);
		curl_setopt($resource, CURLOPT_CONNECTTIMEOUT, 15);
			
		$result = curl_exec($resource);
		curl_close($resource);
		return json_decode($result);
	}
	
}

/* Let's our script know that Cheddar_PHP has initiated */
define('CHEDDAR_PHP', true);