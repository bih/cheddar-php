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

/**
 * This hides all errors. We will automatically enable it on a stable release.
 */
// error_reporting(0);

/**
 * Registering the Cheddar namespace to avoid conflictions with old scripts.
 */
namespace Cheddar;

/**
 * Cheddar_PHP requires 5.3.0 and above to support namespaces.
 */
if(PHPVERSION() < floatval('5.3.0'))
	die("Cheddar_PHP only works with PHP 5.3.0 and above. Please upgrade.");

/**
 * JavaScript Object Notation (JSON) is needed to communicate with Cheddar.
 */
if(!function_exists('json_encode') || !function_exists('json_decode'))
	throw new Exception('Cheddar_PHP requires the PHP JSON package to run.');

/**
 * Declaration of the Cheddar\API class object.
 */
class API {

	/**
	 * Important settings to making Cheddar_PHP easier to use and modify.
	 * These cannot be modified as they are settings only designed to be edited in-code.
	 *
	 * @access   protected
	 * @since    1.1.0
	 */
	protected $is_debug = false;
	protected $version = '1.1.0';
	protected $api_server = 'https://api.cheddarapp.com';
	
	
	
	/**
	 * Important and private settings used to make authenticated requests.
	 *
	 * @access   private
	 */
	private $app_id;
	private $app_secret;
	private $access_token;
	
	
	
	/**
	 * Cheddar\API::__construct()
	 *
	 * @param    string/array
	 * @access   public
	 */
	public function __construct( $config ) {
		
		/**
		 * We need to make sure the $config contains a valid string.
		 */
		if(empty($config))
			die("You need enter your Cheddar credentials. See examples included in the package.");
		
		/**
		 * This enables $config to be either an array, or text-based parameters which are converted to array.
		 *
		 * @example   $config = "app_id=1&app_secret=abcdef";
		 * @since     1.1.0
		 */
		if(!is_array($config))
			parse_str($config, $config);
		
		/**
		 * We need the application ID and secret given by Cheddar Developer website.
		 */
		if(empty($config['app_id']) or empty($config['app_secret']) or $config['app_id'] == 'APP ID HERE' or $config['app_secret'] == 'APP SECRET HERE')
			die("You need to register a Cheddar app. Register one at https://cheddarapp.com/developer/apps");
		
		/**
		 * We need to make sure the $config contains a valid string.
		 *
		 * @access    private
		 */
		$this->app_id = $config['app_id'];
		$this->app_secret = $config['app_secret'];
		$this->access_token = $config['access_token'] ? $config['access_token'] : null;
	}
	
	
	
	/**
	 * Cheddar\API::authorize()
	 *
	 * @param    string
	 * @access   public
	 * @since    1.1.0
	 */
	public function authorize( $config = '' ) {
	
		/**
		 * We need to redirect them to the Cheddar authorisation page. Let's do that.
		 */
		if(!headers_sent()) {
			$url = $this->api_server;
			$uri .= '/oauth/authorize?client_id='.$this->app_id;
			$url .= !empty($config) ? '&'.$config : '';
			
			header('Location: ' . $url);
		} else {
			die("Cheddar_PHP could not send the request. Try declaring this function before printing any output.");
		}
		
	}
	
	
	
	/**
	 * Cheddar\API::set_access_token()
	 *
	 * @param    string
	 * @access   public
	 * @since    1.1.0
	 * @example  $cheddar->set_access_token('abcdef');
	 */
	public function set_access_token($access_token) {
		/**
		 * This is the access token used to authenticate requests. If we have one in the database, put it here.
		 */
		$this->access_token = $access_token;
	}
	
	
	
	/**
	 * Cheddar\API::get_access_token()
	 *
	 * @access   public
	 * @since    1.1.0
	 */
	public function get_access_token() {
		/**
		 * If we already have an access token, we're already there.
		 */
		if($this->access_token)
			return $this->access_token;
		
		/**
		 * Cheddar sends us a code after authentication. Let's convert that into an access code.
		 */
		if(!empty($_GET['code'])) {
		
			$user = $this->http('/oauth/token', array(
					'grant_type' => 'authorization_code',
					'code' => $_GET['code']
				), array(
					'X-User-Authorization' => $this->app_id.':'.$this->app_secret
				)
			);
						
			if(empty($user->access_token)) {
				die("Cheddar_PHP could not validate the OAuth authorization code.");
			} else {
				$this->set_access_token($user->access_token);
				return $user->access_token;
			}
		}
		
		/**
		 * If we're here, there's no access token so let's tell the code that.
		 */
		return NULL;
	}
	
	
	
	/**
	 * Cheddar\API::call()
	 *
	 * @param   string
	 * @param   array
	 * @param   string
	 * @access  public
	 * @since   1.0.0
	 * @return  object
	 */
	public function call( $address, $post = null, $access_token = null ) {
		
		/**
		 * Firstly, we need to see if it's an authenticated request.
		 */
		if($access_token == null && $this->access_token)
			$access_token = $this->access_token;
		
		/**
		 * Next up, detect if it is an array or a string with parameters.
		 */
		if($post != null && !is_array($post))
			parse_str($post, $post);
		
		/**
		 * We have managed to integrate all of Cheddar's functionality under this function.
		 * The pattern coded below detects whether or not to HTTP PUT the request to Cheddar.
		 */
		if($post != null && $address != '/pusher/auth') {
			$split_addr = explode('/', $address);
			
			if(is_numeric(end($split_addr))) {
				$post['X-User-Method'] = 'PUT';
			}
		}
		
		/**
		 * Declare a blank $headers to avoid PHP notice errors.
		 */
		$headers = null;
		
		/**
		 * This checks if there is an access token, and if so, set the header accordingly.
		 */
		if(!empty($access_token))
			$headers = array( 'Authorization: Bearer '.$access_token );
		
		/**
		 * Send the request to self::http, and return the value.
		 */
		return $this->http( $address, $post, $headers);
	}
	
	
	
	/**
	 * Cheddar\API::http()
	 *
	 * @param    string
	 * @param    array
	 * @param    array
	 * @since    1.0.0
	 * @access   private
	 */
	private function http($uri, $post = false, $header = false) {
	
		/**
		 * Without cURL, we are hopeless. Let's tell the user that.
		 */
		if( !function_exists('curl_init') )
			die("Cheddar_PHP requires the libcurl extension (curl.haxx.se) to run.");
		
		/**
		 * With cURL, we can dominate the world. Let's do exactly that.
		 */
		$resource = curl_init();
		
		/**
		 * These are the common configuration options. Play about with these.
		 */
		curl_setopt($resource, CURLOPT_URL, $this->api_server.$uri );
		curl_setopt($resource, CURLOPT_REFERER, 'http://github.com/bilawal360/cheddar-php');
		curl_setopt($resource, CURLOPT_USERAGENT, 'Cheddar_PHP/'.$this->version);
		
		/**
		 * And the not so common options. Some of these are important, so read up on them first.
		 *
		 * @see http://www.php.net/curl
		 */
		curl_setopt($resource, CURLOPT_HEADER, (bool) ($this->is_debug) ? true : false);
		curl_setopt($resource, CURLOPT_VERBOSE, (bool) ($this->is_debug) ? true : false);
		curl_setopt($resource, CURLOPT_NOBODY, false);
		curl_setopt($resource, CURLOPT_MAXREDIRS, 2);
		curl_setopt($resource, CURLOPT_FRESH_CONNECT, (bool) ($this->is_debug) ? true : false);
		curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($resource, CURLOPT_TIMEOUT, (bool) ($this->is_debug) ? 40 : 15);
		curl_setopt($resource, CURLOPT_CONNECTTIMEOUT, (bool) ($this->is_debug) ? 20 : 15);
		
		/**
		 * These identify PUT requests and configure them with cURL.
		 */
		if( is_array($post) && count($post) > 0 ) {
			
			/**
			 * For now, we will only allow PUT, GET, POST and DELETE requests.
			 */
			if(!empty($post['X-User-Method']) && in_array($post['X-User-Method'], array('PUT', 'POST', 'DELETE'))) {
				curl_setopt($resource, CURLOPT_CUSTOMREQUEST, $post['X-User-Method']);
				unset($post['X-User-Method']);
			} else {
				curl_setopt($resource, CURLOPT_POST, true);
			}
			
			/**
			 * And the data to be sent through POST, PUT, GET, or DELETE.
			 */
			curl_setopt($resource, CURLOPT_POSTFIELDS, $post); 
		}
		
		/**
		 * When converting the oAuth auth code into the access token, we need HTTP authentication.
		 */
		if(!empty($header['X-User-Authorization'])) {
			curl_setopt($resource, CURLOPT_USERPWD, $header['X-User-Authorization']);
			unset($header['X-User-Authorization']);
		}
				
		/**
		 * Headers are an important part of REST APIs.
		 * The Expect: solves a bug within some requests, so it would be best left intact.
		 */
		if(is_array($header)) {
			$header[] = 'Expect: ';
			curl_setopt($resource, CURLOPT_HTTPHEADER, $header);
		}
		
		/**
		 * We can't just return curl_exec() because we need to close cURL first (and debug).
		 */
		$result = curl_exec($resource);
		curl_close($resource);
		
		/**
		 * If we have the self::is_debug as true, we can print the follow below.
		 */
		if($this->is_debug) {
			echo '<h1>Debug</h1><code>' . nl2br($result) . '</code>';
		}
		
		/**
		 * Everything is all good. We can JSON decode the value and return it!
		 */
		return json_decode($result);
	}
	
}