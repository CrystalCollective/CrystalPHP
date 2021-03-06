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

use CrystalPHP\Dispatcher;
use CrystalPHP\Router\Router;
use CrystalPHP\App;

Router::get("/", function(){
	Dispatcher::dispatchPage(DIR_MODULE_PUBLIC . "/controller_page.php", "ControllerModulePublicPage@home");
	
});

Router::get("/home", function(){
	Dispatcher::dispatchPage(DIR_MODULE_PUBLIC . "/controller_page.php", "ControllerModulePublicPage@home");
});

Router::get("/login", function(){
	App::app()->response->sendResponse(200, "Welcome to login");
})->name("login.get");

Router::setDefaultRoute("GET", function(){
	echo "Default Get";
});

