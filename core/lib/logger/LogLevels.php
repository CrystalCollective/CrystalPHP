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
 * Time: 02:06
 */

namespace CrystalPHP\Lib\Logger;


class LogLevels{
	const EMERGENCY = 'emergency';
	const ALERT = 'alert';
	const CRITICAL = 'critical';
	const ERROR = 'error';
	const WARNING = 'warning';
	const NOTICE = 'notice';
	const INFO = 'info';
	const DEBUG = 'debug';
	const VERBOSE = 'verbose';
	
	/**
	 * Log Levels
	 * Label to code
	 * @var array
	 */
	static $logLevelCodes = array(
		LogLevels::EMERGENCY => 0,
		LogLevels::ALERT => 1,
		LogLevels::CRITICAL => 2,
		LogLevels::ERROR => 3,
		LogLevels::WARNING => 4,
		LogLevels::NOTICE => 5,
		LogLevels::INFO => 6,
		LogLevels::DEBUG => 7,
		LogLevels::VERBOSE => 8,
	);
	
	/**
	 * Log Levels
	 *
	 * code to label
	 *
	 * @var array
	 */
	static $logLevelLabels = array(
		LogLevels::EMERGENCY,
		LogLevels::ALERT,
		LogLevels::CRITICAL,
		LogLevels::ERROR,
		LogLevels::WARNING,
		LogLevels::NOTICE,
		LogLevels::INFO,
		LogLevels::DEBUG,
		LogLevels::VERBOSE,
	);
}