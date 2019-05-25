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
 * Created by PhpStorm.
 * User: Pankaj Vaghela
 * Date: 22-05-2019
 * Time: 01:53
 */

namespace CrystalPHP\Lib\Logger;


trait LoggerTrait{
	
	public function emergency($message, array $context = array()){
		$this->log(LogLevels::EMERGENCY, $message, $context);
	}
	
	public function alert($message, array $context = array()){
		$this->log(LogLevels::ALERT, $message, $context);
	}
	
	public function critical($message, array $context = array()){
		$this->log(LogLevels::CRITICAL, $message, $context);
	}
	
	
	public function error($message, array $context = array()){
		$this->log(LogLevels::ERROR, $message, $context);
	}
	
	public function warning($message, array $context = array()){
		$this->log(LogLevels::WARNING, $message, $context);
	}
	
	public function notice($message, array $context = array()){
		$this->log(LogLevels::NOTICE, $message, $context);
	}
	
	
	public function info($message, array $context = array()){
		$this->log(LogLevels::INFO, $message, $context);
	}
	
	
	public function debug($message, array $context = array()){
		$this->log(LogLevels::DEBUG, $message, $context);
	}
	
	
	public function verbose($message, array $context = array()){
		$this->log(LogLevels::VERBOSE, $message, $context);
	}
	
	
	abstract public function log($level, $message, array $context = array());
	
}