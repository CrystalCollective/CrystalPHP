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
 * Time: 01:46
 */

namespace CrystalPHP\Lib\Logger;


class Logger implements LoggerInterface{
	
	use LoggerTrait;
	
	public static $logs = [];
	
	public function log($level, $message, array $context = array()){
		// TODO: Implement log() method.
		$log = [
			'level' => $level,
			'msg' => $message,
			'time' => microtime(true),
			'timeb' => microtime(),
		];
		
		$log['e'] = $e = new \Exception();
		self::$logs[] = $log;
	}
	
	public function getLogs(){
		foreach(static::$logs as $log){
			$a[] = $log['msg'];
		}
		return $a;
	}
	
	
}