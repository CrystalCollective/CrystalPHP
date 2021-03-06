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
 * Date: 27-05-2019
 * Time: 15:25
 */

use CrystalPHP\Router\Router;

Router::get("/api", function(){
	$rest = new \CrystalPHP\REST();
	$rest->setResponse(true, [], "Welcome to CrystalPHP API");
	$rest->sendResponse(200, []);
})->name("api.get.home");

Router::get("/api/a", function(){
	
	\CrystalPHP\Dispatcher::dispatchApi(DIR_MODULES . "/" . MODULE_PUBLIC . "/ControllerModulePublicApi.php",
		"ControllerModulePublicApi@index");
})->name("api.get.home");