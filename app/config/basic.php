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

namespace CrystalPHP\Config;

Config::set_multiple([
	Configs::LOCAL_NAME => 'CrystalPHP',
	'VERSION' => '0.0.1',
	'MODE' => 'dev',
	'ENABLE_OUTPUT' => true,
]);

Config::set_multiple([
	Configs::ROUTE_ROOT => '/',
]);


/**
 * DEV TOOL Related Configs
 */
Config::set_multiple([
	'SHOW_TIME' => false,
]);