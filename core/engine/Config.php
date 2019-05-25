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
 * Time: 13:30
 */

namespace CrystalPHP;

class Config{
	
	public static $config = [];
	
	/**
	 * Load Config files
	 */
	public static function load(){
		require_once DIR_APP . DIR_EXT_CONFIG . "/basic.php";
	}
	
	/**
	 * @param array $configs
	 * @return mixed
	 */
	public static function set_multiple($configs = []){
		$result = [];
		foreach($configs as $key => $value)
			$result[$key] = Config::set($key, $value);
		
		return $result;
	}
	
	/**
	 * @param $name
	 * @param $val
	 * @return mixed
	 */
	public static function set($name, $val){
		$nodes = explode(".", $name);
		
		$reference = &self::$config;
		foreach($nodes as $key){
			if(!array_key_exists($key, $reference)){
				$reference[$key] = [];
			}
			$reference = &$reference[$key];
		}
		$reference = $val;
		unset($reference);
		
		return $val;
	}
	
	/**
	 * @param $name
	 * @param null $default
	 * @return mixed|null
	 */
	function get($name, $default = null){
		
		$nodes = explode(".", $name);
		$val = self::$config;
		
		foreach($nodes as $node){
			$node = isset($val[strtolower($node)]) ? strtolower($node) : $node;
			$node = isset($val[strtoupper($node)]) ? strtoupper($node) : $node;
			
			if(isset($val[$node])){
				$val = $val[$node];
			} else{
				return $default;
			}
		}
		
		return $val;
	}
	
	
}