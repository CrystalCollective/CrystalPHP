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
 * Time: 01:49
 */

namespace CrystalPHP\Lib\Logger;


interface LoggerInterface{
	
	public function emergency($message, array $context = array());
	
	public function alert($message, array $context = array());
	
	public function critical($message, array $context = array());
	
	public function error($message, array $context = array());
	
	public function warning($message, array $context = array());
	
	public function notice($message, array $context = array());
	
	public function info($message, array $context = array());
	
	public function debug($message, array $context = array());
	
	public function verbose($message, array $context = array());
	
	public function log($level, $message, array $context = array());
	
}