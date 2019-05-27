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
 * Date: 19-05-2019
 * Time: 12:25
 */

namespace CrystalPHP;

use CrystalPHP\Config\Config as Config;
use CrystalPHP\Lib\Logger\Logger as Logger;
use CrystalPHP\Router\Router;

/**
 * Class CrystalPHP
 * @package CrystalPHP
 *
 * @property Registry $registry
 * @property Config $config
 * @property Request $request
 * @property Response $response
 * @property Logger $logger
 */
class App{
	static $app = null;
	
	protected $registry;
	
	/**
	 * CrystalPHP constructor.
	 * @param Registry $registry
	 */
	public function __construct($registry){
		$this->registry = $registry;
	}
	
	/**
	 * @param Registry|null $registry
	 * @return App|null
	 */
	public static function app($registry = null){
		if(self::$app === null){
			self::$app = ($registry instanceof Registry) ? new App($registry) : null;
		}
		return self::$app;
	}
	
	/**
	 * @return $this
	 */
	public function initialize(){
		$this->config = Config::getInstance(true);
		$this->logger = new Logger();
		$this->request = Request::getInstance();
		
		Router::boot();

		$this->logger->info("Crystal App initialized");
		return $this;
	}
	
	/**
	 * @return Response
	 */
	public function run(){
		$this->response = new Response();
		
		try{
			(new Router())->resolve(ROUTE);
		} catch (\Exception $e){
			$this->logger->error($e->getMessage());
		}
		
		return $this->response;
	}
	
	
	public function __get($name){
		return $this->registry->get($name);
	}
	
	public function __set($name, $value){
		$this->registry->set($name, $value);
	}
}

/**
 * @param null $registry
 * @return App|null
 */
function app($registry = null){
	return App::app($registry);
}