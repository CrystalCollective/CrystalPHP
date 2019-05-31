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
 * Time: 13:26
 */

namespace CrystalPHP;

class Loader{
	
	public const MODULE = "module";
	
	private static $loaders = [];
	
	public static function all(){
	
	
	}
	
	public static function register($type, $val){
		if(isset(self::$loaders[$type])){
			self::$loaders[$type] = array_merge(self::$loaders[$type], $val);
		} else{
			self::$loaders[$type] = $val;
		}
	}
	
	public function boot(){
		require_once DIR_MODULES . "/ini.php";
	}
	
	public function module($name = ''){
		
		if($name === ''){
			foreach(self::$loaders[Loader::MODULE] as $key => $module){
				self::module($key);
			}
		}
		
		if(isset(self::$loaders[Loader::MODULE][$name])){
			$module = self::$loaders[Loader::MODULE][$name];
			$ini_file = DIR_MODULES . "/" . $name . "/" . $module['ini'];
			if(is_file($ini_file)){
				require_once $ini_file;
			}
		}
	}
	
	
}