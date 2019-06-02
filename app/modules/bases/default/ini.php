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
 * Time: 21:25
 */

use CrystalPHP\Dispatcher;

define("MODULE_BASE_DEFAULT", "base_default");
define("DIR_MODULE_BASE_DEFAULT", DIR_MODULES . "/bases/default");

define('RT_BASE_DEFAULT_PAGE', "base_default_page");

Dispatcher::addBaseController("page_default", "ControllerBaseDefaultPage", DIR_MODULE_BASE_DEFAULT . "/controller_page.php");
Dispatcher::selectBaseController("page_default");

