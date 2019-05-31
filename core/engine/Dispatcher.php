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
 * Date: 24-05-2019
 * Time: 06:58
 */

namespace CrystalPHP;

use CrystalPHP\Config\Config;
use CrystalPHP\Config\Configs;
use CrystalPHP\Controller\ApiController;
use CrystalPHP\Controller\BaseController;
use CrystalPHP\Controller\SectionController;
use CrystalPHP\Controller\PageController;
use CrystalPHP\Controller\Controller;
use CrystalPHP\Controller\ControllerException;

class Dispatcher{
	
	public static $base_controllers = [
		"base" => ["class" => "\CrystalPHP\Controller\PageController"],
		"section" => ["class" => "\CrystalPHP\Controller\SectionController"],
		"rest_api" => ['class' => "\CrystalPHP\Controller\ApiController"],
	];
	
	public static $base_controller = "base";
	public static $main_base_controller = "base";
	
	/**
	 * @var Registry
	 */
	protected $registry;
	/**
	 * @var string
	 */
	protected $file;
	/**
	 * @var string
	 */
	protected $controller;
	/**
	 * @var string
	 */
	protected $method;
	/**
	 * @var string
	 */
	protected $controller_type;
	/**
	 * @var array
	 */
	protected $data = array();
	
	
	/**
	 * Dispatcher constructor.
	 * @param $file
	 * @param $controllerClassMethod
	 * @param $data
	 * @param string $base_controller
	 */
	public function __construct($file, $controllerClassMethod, $data = [], $base_controller = 'base'){
		
		$this->registry = Registry::getInstance();
		$this->data = $data;
		
		$this->file = $file;
		
		$cont = preg_split("/@/", $controllerClassMethod);
		$this->controller = $cont[0];
		$this->method = isset($cont[1]) ? $cont[1] : "index";
		
		self::$base_controller = $base_controller;
	}
	
	/**
	 * @param $filename
	 * @param $controllerClassMethod
	 * @param string $base_controller
	 * @param array $data
	 * @throws ControllerException
	 */
	public static function dispatchRoute($filename, $controllerClassMethod, $base_controller = '', $data = []){
		self::$main_base_controller = $base_controller == '' ? 'base' : $base_controller;
		self::dispatchPage($filename, $controllerClassMethod, $data, false, $base_controller);
	}
	
	/**
	 * @param $filename
	 * @param $controllerClassMethod
	 * @param array $data
	 * @param bool $return
	 * @param string $base_controller
	 * @return string
	 * @throws ControllerException
	 */
	public static function dispatchPage($filename, $controllerClassMethod, $data = [], $return = false, $base_controller = 'base'){
		$registry = Registry::getInstance();
		$registry->dispatch_data = $data;
		
		$b = Dispatcher::selectBaseController($base_controller, true);
		self::$main_base_controller = $b;
		$dispatcher = new Dispatcher($filename, $controllerClassMethod, $data, $b);
		return $dispatcher->dispatch($base_controller, $return);
	}
	
	public static function selectBaseController($name, $toBase = false){
		if(isset(self::$base_controllers[$name])){
			return self::$base_controller = $name;
		} elseif($toBase){
			return self::$base_controller = "base";
		}
		
		return null;
	}
	
	// Clear function is public in case controller needs to be cleaned explicitly
	
	/**
	 * @param string $base
	 * @param bool $return
	 * @return string
	 * @throws ControllerException
	 */
	public function dispatch($base = 'base', $return = false){
		
		Dispatcher::selectBaseController($base, true);
		$c = Dispatcher::getSelectedBaseController();
		if(isset($c['file'])){
			require_once($c['file']);
		}
		$c = $c['class'];
		
		/**
		 * @var $baseController PageController|SectionController|BaseController|ApiController|Controller
		 */
		$baseController = new $c($this->registry, "page", 0);
		
		$baseController->setupPage();
		$baseController->addChild("content", 0, $this->file, $this->controller, $this->method, $this->data);
		
		$baseController->pageRender();
		$output = $baseController->dispatch();
		
		if(Config::get(Configs::ENABLE_OUTPUT) && !$return){
			echo $output;
			return "";
		} else{
			return $output;
		}
	}
	
	public static function getSelectedBaseController(){
		if(isset(self::$base_controllers[self::$base_controller])){
			return self::$base_controllers[self::$base_controller];
		} else{
			return self::$base_controllers['base'];
		}
	}
	
	/**
	 * @param $filename
	 * @param $controllerClassMethod
	 * @param array $data
	 * @param bool $return
	 * @param string $base_controller
	 * @return string
	 * @throws ControllerException
	 */
	public static function dispatchSection($filename, $controllerClassMethod, $data = [], $return = false, $base_controller = 'section'){
		$registry = Registry::getInstance();
		$registry->dispatch_data = $data;
		
		$b = Dispatcher::selectBaseController($base_controller, true);
		
		$dispatcher = new Dispatcher($filename, $controllerClassMethod, $data, $b);
		return $dispatcher->dispatch($base_controller, $return);
	}
	
	/**
	 * @param $filename
	 * @param $controllerClassMethod
	 * @param array $data
	 * @param bool $return
	 * @param string $base_controller
	 * @return string
	 * @throws ControllerException
	 */
	public static function dispatchApi($filename, $controllerClassMethod, $data = [], $return = false, $base_controller = 'rest_api'){
		$registry = Registry::getInstance();
		$registry->dispatch_data = $data;
		
		$b = Dispatcher::selectBaseController($base_controller, true);
		
		$dispatcher = new Dispatcher($filename, $controllerClassMethod, $data, $b);
		return $dispatcher->dispatch($base_controller, $return);
	}
	
	public static function addBaseController($name, $class, $filepath){
		self::$base_controllers[$name] = ['class' => $class, "file" => $filepath];
	}
	
	public static function getBaseControllers(){
		return self::$base_controllers;
	}
	
	public static function getBaseController($name){
		return self::$base_controllers[$name] ?? null;
	}
	
	public function __destruct(){
		$this->clear();
	}
	
	public function clear(){
		$vars = get_object_vars($this);
		foreach($vars as $key => $val){
			$this->$key = null;
		}
	}
	
	public function __get($key){
		return $this->registry->get($key);
	}
	
	public function __set($key, $value){
		$this->registry->set($key, $value);
	}
	
	
}