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

use CrystalPHP\Document;

Config::set_multiple([
	Configs::LOCAL_NAME => 'CrystalPHP',
	Configs::VERSION => '0.0.1',
	Configs::MODE => 'dev',
	Configs::NAMESPACE => '\\', //Always put \ at start and end
	
	Configs::ENABLE_OUTPUT => true,
]);

Config::set_multiple([
	Configs::ROUTE_ROOT => '/',
]);


Config::set(Document::DOCUMENT, [
	Document::TITLE => "CrystalPHP - flexible MVC Framework",
	Document::DESCRIPTION => "A flexible MVC Framework for fast web development",
	Document::KEYWORDS => ["CrystalPHP", "crystal collective", "Framework"],
	Document::CHARSET => 'utf-8',
	Document::LANG => 'en-gb',
	Document::DIRECTION => 'ltr',
]);


/**
 * DEV TOOL Related Configs
 */
Config::set_multiple([
	'SHOW_TIME' => false,
]);


