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
 * Time: 12:45
 */

namespace CrystalPHP;


/**
 * Class Registry
 * @package CrystalPHP
 *
 * @property Registry $registry
 * @property Config\Config $config
 * @property Request $request
 * @property Response $response
 * @property Lib\Logger\Logger $logger
 */
class Registry{
	
	static private $instance = null;
	private $data_array_list = array();
	
	public function __construct(){
	}
	
	/**
	 * @return Registry
	 */
	static function getInstance(){
		if(self::$instance == null){
			self::$instance = new Registry();
		}
		return self::$instance;
	}
	
	/**
	 * @param $key string
	 * @return bool
	 */
	public function has($key){
		return isset($this->data_array_list[$key]);
	}
	
	public function __get($key){
		return $this->get($key);
	}
	
	public function __set($key, $value){
		return $this->set($key, $value);
	}
	
	/**
	 * @param $key
	 * @return mixed|null
	 */
	public function get($key){
		return (isset($this->data_array_list[$key]) ? $this->data_array_list[$key] : null);
	}
	
	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	public function set($key, $value){
		return $this->data_array_list[$key] = $value;
	}
	
	private function __clone(){
	}
}