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
 * Date: 31-05-2019
 * Time: 15:28
 */

use CrystalPHP\Loader;


Loader::register(Loader::MODULE,
	[
		"base_default" => [
			"ini" => "bases/default/ini.php",
		],
		"public" => [
			// Don't need to define ini because its in root and named ini.php
		],
	
	]);

