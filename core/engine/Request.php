<?php
/*******************************************************************************
 *
 *   CrystalPHP Framework by Crystal Collective
 *   An open source application development framework for PHP
 *
 *   This file is part of CrystalPHP which is released under the MIT License (MIT)
 *
 *   Copyright (c) 2019 - 2019, Crystal Collective
 *
 *   For the full copyright and license information,
 *   please view the LICENSE file that was distributed with this source code.
 *
 ******************************************************************************/

/**
 * User: Pankaj Vaghela
 * Date: 26-05-2019
 * Time: 00:37
 */

namespace CrystalPHP;


use CrystalPHP\Config\Config as Config;
use CrystalPHP\Config\Configs as Configs;

//use CrystalPHP\Lib\Logger\Logger;

class Request{
	public static $instance = null;
	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();
	
	private $http;
	private $version;
	private $browser;
	private $browser_version;
	private $platform;
	private $device_type;
	
	public function __construct(){
		$_GET = $this->clean($_GET);
		$_POST = $this->clean($_POST);
		$_COOKIE = $this->clean($_COOKIE);
		$_FILES = $this->clean($_FILES);
		$_SERVER = $this->clean($_SERVER);
		
		$this->get = $_GET;
		$this->post = $_POST;
		$this->cookie = $_COOKIE;
		$this->files = $_FILES;
		$this->server = $_SERVER;
		
		//check if there is any encrypted data
		if(array_key_exists('__e', $this->get)){
			$this->get = array_replace_recursive($this->get, $this->decodeURI($this->get['__e']));
		}
		if(array_key_exists('__e', $this->get)){
			$this->post = array_replace_recursive($this->post, $this->decodeURI($this->post['__e']));
		}
		$this->_detectBrowser();
		$this->_detectHostInfo();
	}
	
	/**
	 * Prevent hacks and non-browser requests with non-encoded data.
	 * @param string|array $data
	 * @return array|string
	 */
	public function clean($data){
		if(is_array($data)){
			foreach($data as $key => $value){
				unset($data[$key]);
				$data[$this->clean($key)] = $this->clean($value);
			}
		} else{
			$data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
		}
		return $data;
	}
	
	/**
	 * @param string - base64 $uri
	 * @return array
	 */
	public function decodeURI($uri){
		$params = array();
		$open_uri = base64_decode($uri);
		
		$split_parameters = explode('&', $open_uri);
		for($i = 0; $i < count($split_parameters); $i++){
			$final_split = explode('=', $split_parameters[$i]);
			$params[$final_split[0]] = $final_split[1];
		}
		//clean data before return
		return $this->clean($params);
	}
	
	private function _detectBrowser(){
		if(isset($_SERVER['HTTP_USER_AGENT'])){
			$nua = strtolower($_SERVER['HTTP_USER_AGENT']);
			
			$agent['http'] = isset($nua) ? $nua : "";
			$agent['version'] = 'unknown';
			$agent['browser'] = 'unknown';
			$agent['platform'] = 'unknown';
			$agent['device_type'] = '';
			
			$oss = array('win', 'mac', 'linux', 'unix');
			foreach($oss as $os){
				if(strstr($agent['http'], $os)){
					$agent['platform'] = $os;
					break;
				}
			}
			
			$browsers = array("mozilla", "msie", "gecko", "firefox", "konqueror", "safari", "netscape", "navigator", "opera", "mosaic", "lynx", "amaya", "omniweb");
			
			for($i = 0; $i < count($browsers); $i++){
				if(strlen(stristr($nua, $browsers[$i])) > 0){
					$agent["browser"] = $browsers[$i];
					break;
				}
			}
			
			//http://en.wikipedia.org/wiki/List_of_user_agents_for_mobile_phones - list of useragents
			$devices = array("iphone", "android", "blackberry", "ipod", "ipad", "htc", "symbian", "webos", "opera mini", "windows phone os", "iemobile");
			
			for($i = 0; $i < count($devices); $i++){
				if(stristr($nua, $devices[$i])){
					$agent["device_type"] = $devices[$i];
					break;
				}
			}
			
			$this->browser = $agent['browser'];
			$this->device_type = $agent['device_type'];
			$this->http = $agent['http'];
			$this->platform = $agent['platform'];
			$this->version = $agent['version'];
		}
	}
	
	public function _detectHostInfo(){
		define('LOCAL_NAME', Config::get(Configs::LOCAL_NAME));
		
		// Detect if localhost is used.
		if(!isset($_SERVER['HTTP_HOST']) || $_SERVER['HTTP_HOST'] == 'localhost'){
			$_SERVER['HTTP_HOST'] = 'localhost/' . LOCAL_NAME;
		}
		
		// Detect https
		define('HTTPS', (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == '1'))
			|| (isset($_SERVER['HTTP_X_FORWARDED_SERVER']) && ($_SERVER['HTTP_X_FORWARDED_SERVER'] == 'secure' || $_SERVER['HTTP_X_FORWARDED_SERVER'] == 'ssl'))
			|| (isset($_SERVER['SCRIPT_URI']) && (substr($_SERVER['SCRIPT_URI'], 0, 5) == 'https'))
			|| (isset($_SERVER['HTTP_HOST']) && (strpos($_SERVER['HTTP_HOST'], ':443') !== false))
		);
		
		// Get HTTP Referer
		define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "");
		
		// Detect http host
		define('REAL_HOST', isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
		
		// SEO URL Keyword separator & EMAIL REGEXP PATTERN
		define('SEO_URL_SEPARATOR', '-');
		define('EMAIL_REGEX_PATTERN', '/^[A-Z0-9._%-]+@[A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,16}$/i');
		define('INDEX_FILE', 'index.php');
		
		define('HTTP_DIR_NAME_REAL', preg_replace("/(\/" . INDEX_FILE . ")/", "", rtrim(dirname($_SERVER['PHP_SELF']), '/.\\'), 1));
		define('HTTP_DIR_NAME', preg_replace("/(\/" . LOCAL_NAME . ")/", "", HTTP_DIR_NAME_REAL, 1));
		
		define('AUTO_SERVER', '//' . REAL_HOST . '/');
		define('HTTP_SERVER', 'http:' . AUTO_SERVER);
		
		define('HTTPS_SERVER', (HTTPS === true) ? ('https:' . AUTO_SERVER) : HTTP_SERVER);
		
		$_SERVER['REQUEST_URI'] = str_replace("/" . LOCAL_NAME, "", $_SERVER['REQUEST_URI']);
		
		define('REQUEST_URI_REL', str_replace(HTTPS_SERVER . "/app/", "", substr($_SERVER['REQUEST_URI'], 1)));
		define('REQUEST_URI_PATH', explode("?", REQUEST_URI_REL)[0]);
		
		define('REQUEST_URI_FULL', HTTPS_SERVER . REQUEST_URI_REL);
		
		$uri = $_SERVER['REQUEST_URI'];
		$uri_nodes = explode("?", $uri);
		
		$route_ini = $uri_nodes[0];
		
		if($uri == null || ($route_ini == "" || $route_ini == "/")){
			define('ROUTE', Config::get(Configs::ROUTE_ROOT));
		} else{
			define('ROUTE', $route_ini);
		}
		
		define('rt', ROUTE);
	}
	
	/**
	 * @return Request
	 */
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new Request();
		}
		return self::$instance;
	}
	
	public function getBrowser(){
		return $this->browser;
	}
	
	public function getBrowserVersion(){
		return $this->browser_version;
	}
	
	public function getDeviceType(){
		return $this->device_type;
	}
	
	public function getHttp(){
		return $this->http;
	}
	
	public function getPlatform(){
		return $this->platform;
	}
	
	public function getVersion(){
		return $this->version;
	}
	
	public function getRemoteIP(){
		if(!empty($this->server['HTTP_CLIENT_IP'])){
			$ip = $this->server['HTTP_CLIENT_IP'];
		} elseif(!empty($this->server['HTTP_X_FORWARDED_FOR'])){
			$ip = $this->server['HTTP_X_FORWARDED_FOR'];
		} else{
			$ip = $this->server['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	/**
	 * @return bool
	 */
	public function isPOST(){
		return ($this->server['REQUEST_METHOD'] == 'POST' ? true : false);
	}
	
	/**
	 * @return bool
	 */
	public function isGET(){
		return ($this->server['REQUEST_METHOD'] == 'GET' ? true : false);
	}
	
	//todo: Include PHP module filter to process input params. http://us3.php.net/manual/en/book.filter.php
	
	/**
	 * function returns variable value from $_POST
	 * @param string $key
	 * @return string | null
	 */
	public function getGET($key, $default = null){
		if(isset($this->get[$key])){
			return $this->get[$key];
		}
		return $default;
	}
	
	/**
	 * function returns variable value from $_POST
	 * @param string $key
	 * @return string | null
	 */
	public function getPOST($key, $default = null){
		if(isset($this->post[$key])){
			return $this->post[$key];
		}
		return $default;
	}
	
	/**
	 * function returns variable value from $_GET first
	 * @param string $key
	 * @return string | null
	 */
	public function get_or_post($key){
		if(isset($this->get[$key])){
			return $this->get[$key];
		} elseif(isset($this->post[$key])){
			return $this->post[$key];
		}
		return null;
	}
	
	/**
	 * function returns variable value from $_POST first
	 * @param string $key
	 * @return string | null
	 */
	public function post_or_get($key, $default = null){
		if(isset($this->post[$key])){
			return $this->post[$key];
		} elseif(isset($this->get[$key])){
			return $this->get[$key];
		}
		return $default;
	}
	
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function deleteCookie($name){
		if(empty($name)){
			return false;
		}
		$path = dirname($this->server['PHP_SELF']);
		setcookie($name, null, -1, $path);
		unset($this->cookie[$name], $_COOKIE[$name]);
		return true;
	}
	
	
}


if(!function_exists("request")){
	function request(){
		return Request::getInstance();
	}
}