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
 * Date: 22-05-2019
 * Time: 02:27
 */

namespace CrystalPHP\Router;

class Router{
	/**
	 * @var string
	 */
	public static $req_rt;
	/**
	 * @var array(Route[])
	 */
	public static $routes = [];
	public static $routes_by_name = [];
	public static $routeCount = 0;
	public static $defaultRoutes = array();
	private static $url_data_keys = array();
	private static $url_data_vals = array();
	public $cur_rt;
	
	public function __construct($req = false, $cur_rt = ''){
		$this->cur_rt = $cur_rt;
		if($req){
			static::$req_rt = "/" . ROUTE;
			$this->cur_rt = static::$req_rt;
		}
	}
	
	/**
	 * @param $url
	 * @param $callback
	 * @return Route
	 */
	public static function get($url, $callback){
		return static::addRoute("GET", $url, $callback);
	}
	
	/**
	 * @param $method
	 * @param $url
	 * @param $callback
	 * @param string $name
	 * @return Route
	 */
	public static function addRoute($method, $url, $callback, $name = ''){
		static::$routeCount++;
		static::$routes[$method][$url] = new Route($method, $url, $callback, $name);
//		$ref =& static::$routes[$method][$url];
		static::addRoutesByName($name, $method, $url);
		return static::$routes[$method][$url];
//		return $ref;
	}
	
	/**
	 * @param $name
	 * @param $route
	 */
	public static function addRoutesByName($name, $method, $url){
		if($name != ''){
			static::$routes_by_name[$name] =& static::$routes[$method][$url];;
		}
	}
	
	/**
	 * @param $url
	 * @param $callback
	 * @return Route
	 */
	public static function post($url, $callback){
		return static::addRoute("POST", $url, $callback);
	}
	
	public static function setDefaultRoute($method, $callback){
		static::$defaultRoutes[$method] = ['callback' => $callback];
	}
	
	public static function getUrlKeys(){ return self::$url_data_keys; }
	
	public static function getUrlVals(){ return self::$url_data_vals; }
	
	public static function getUrlValue($key, $default = false){
		$keys = self::$url_data_keys;
		$vals = self::$url_data_vals;
		
		for($i = 0; $i < sizeof($keys); $i++){
			if($keys[$i] === $key){
				return $vals[$i];
			}
		}
		
		return $default;
	}
	
	/**
	 * @param $to
	 * @param null $continue_url
	 */
	public static function redirect($to, $continue_url = null){
		try{
			$url = HTTPS_SERVER . Router::get_url($to) . "?" . append_callback_url($continue_url);
			redirect($url);
		} catch (\Exception $e){
			echo __METHOD__ . $e->getMessage();
		}
	}
	
	/**
	 * @param $route_name
	 * @param array $data
	 * @param bool $absolute
	 * @return null|string|string[]
	 * @throws RouteArgumentMismatchException
	 */
	public static function get_url($route_name, $data = [], $absolute = false){
		
		$route = isset(static::$routes_by_name[$route_name]) ? static::$routes_by_name[$route_name] : null;
		
		if($route){
			preg_match_all("/:\w+/", $route->url, $keys);
			
			$a = count($keys[0]);
			$b = count($data);
			
			if($a > $b) throw  new RouteArgumentMismatchException("url keys : $a, provided $b values ");
			
			$url = $route->url;
			foreach($data as $str){
				$url = preg_replace("/:\w+/", $str, $url, 1);
			}
			
			if($url[0] === "/") $url = substr($url, 1);
			if($absolute) $url = HTTPS_SERVER . $url;
			
			return $url;
		} else{
			return null;
		}
	}
	
	/**
	 * @param string $rt
	 * @return mixed
	 * @throws RouteException
	 */
	public function resolve($rt = ''){
		if($rt == ''){
			$rt = ($this->cur_rt == null) ? static::$req_rt : $this->cur_rt;
		}
		
		$reqUrl = ($rt[0] == "/" ? "" : "/") . $rt;
		$reqMet = $_SERVER['REQUEST_METHOD'];
		
		/**
		 * @var $route Route
		 */
		foreach(static::$routes[$reqMet] as $route){
			// convert urls like '/users/:uid/posts/:pid' to regular expression
			$pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9_\-]+/', '([a-zA-Z0-9\@.\-_]+)', preg_quote($route->url)) . "$@D";
			
			// check if the current request matches the expression
			if(preg_match($pattern, $reqUrl, $matches)){
				// remove the first match
				array_shift($matches);
				
				preg_match_all("/:\w+/", $route->url, $keys);
				
				$keys = $keys[0];
				foreach($keys as $x => $key){
					$keys[$x] = substr($key, 1);
				}
				
				self::$url_data_keys = $keys;
				self::$url_data_vals = $matches;
				
				// call the callback with the matched positions as params
				return call_user_func_array($route->callback, []);
			}
		}
		
		foreach(static::$defaultRoutes as $method => $route){
			if($reqMet == $method){
				return call_user_func_array($route['callback'], array());
			}
		}
		
		throw new RouteException("No Route Found. Current Route : " . $rt);
	}
	
}

if(!function_exists('get_url')){
	function get_url($route_name, $default = null, $data = [], $absolute = true){
		if(!$default) $default = HTTPS_SERVER;
		try{
			$default = Router::get_url($route_name, $data, $absolute);
		} catch (\Exception $e){
			echo $e->getMessage();
		} finally {
			return $default;
		}
	}
}

if(!function_exists('callback_url')){
	function get_callback_url($default = null){
//		return ($url = TRequest::getInstance()->get_or_post('continue')) ? $url : $default;
	}
}

if(!function_exists('append_callback_url')){
	function append_callback_url($url = null, $pre = false, $post = false){
		return $url ? (($pre ? '&' : '') . "continue=$url" . ($post ? '&' : '')) : "";
	}
}
