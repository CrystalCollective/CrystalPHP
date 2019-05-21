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
 *   OR here it is
 *
 *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *   of this software and associated documentation files (the "Software"), to deal
 *   in the Software without restriction, including without limitation the rights
 *   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *   copies of the Software, and to permit persons to whom the Software is
 *   furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 *
 *   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *   THE SOFTWARE.
 *
 *   @package	CrystalPHP
 *   @author	Crystal Collective
 *   @copyright	Copyright (c) 2019 - 2019, Crystal Collective
 *   @license	http://opensource.org/licenses/MIT	 MIT License
 *   @link	https://github.com/CrystalCollective/CrystalPHP
 *   @since	Version 1.0.0
 *   @filesource
 *
 ******************************************************************************/

/**
 * Created by PhpStorm.
 * User: Pankaj Vaghela
 * Date: 22-05-2019
 * Time: 01:53
 */

namespace CrystalPHP;


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
	
	public function e($message, array $context = array()){
		$this->error($message, $context);
	}
	
	public function error($message, array $context = array()){
		$this->log(LogLevels::ERROR, $message, $context);
	}
	
	public function w($message, array $context = array()){
		$this->warning($message, $context);
	}
	
	public function warning($message, array $context = array()){
		$this->log(LogLevels::WARNING, $message, $context);
	}
	
	public function n($message, array $context = array()){
		$this->notice($message, $context);
	}
	
	public function notice($message, array $context = array()){
		$this->log(LogLevels::NOTICE, $message, $context);
	}
	
	public function i($message, array $context = array()){
		$this->info($message, $context);
	}
	
	public function info($message, array $context = array()){
		$this->log(LogLevels::INFO, $message, $context);
	}
	
	public function d($message, array $context = array()){
		$this->debug($message, $context);
	}
	
	public function debug($message, array $context = array()){
		$this->log(LogLevels::DEBUG, $message, $context);
	}
	
	public function v($message, array $context = array()){
		$this->verbose($message, $context);
	}
	
	public function verbose($message, array $context = array()){
		$this->log(LogLevels::VERBOSE, $message, $context);
	}
	
	abstract public function log($level, $message, array $context = array());
	
}