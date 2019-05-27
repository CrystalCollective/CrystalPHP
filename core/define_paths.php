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
 * Time: 03:12
 */

define('DIR_APP', DIR_ROOT . "/app");
define('DIR_CORE', DIR_ROOT . "/core");

define("DIR_EXT_ENGINE", "/engine");
define("DIR_EXT_DB", "/database");
define("DIR_EXT_LIB", "/lib");
define("DIR_EXT_LIB_EXT", "/lib_ext");
define("DIR_EXT_CONFIG", "/config");
define("DIR_EXT_ROUTES", "/routes");
define("DIR_EXT_CACHE", "/cache");
define("DIR_EXT_LOGS", "/logs");

define('DIR_ENGINE', DIR_CORE . DIR_EXT_ENGINE);
define('DIR_LIB', DIR_CORE . DIR_EXT_LIB);

// relative paths for extensions
define('DIR_EXT_CORE', '/core');

define('DIR_EXT_FRONTEND', '/frontend');
define('DIR_FRONTEND', DIR_ROOT . DIR_EXT_FRONTEND);

define('DIR_EXT_CONTROLLER', '/controllers');
define('DIR_EXT_MODEL', '/models');
define('DIR_EXT_VIEW', '/views');


define('DIR_EXT_MODULES', '/modules');
define('DIR_MODULES', DIR_APP . DIR_EXT_MODULES);

//resources
define('DIR_EXT_RES', '/res');
define('DIR_RESOURCE', DIR_FRONTEND . DIR_EXT_RES);

define('DIR_EXT_CSS', '/css');
define('DIR_EXT_JS', '/js');
define('DIR_EXT_IMG', '/img');

define('DIR_CSS', DIR_RESOURCE . DIR_EXT_CSS);
define('DIR_JS', DIR_RESOURCE . DIR_EXT_JS);
define('DIR_IMG', DIR_RESOURCE . DIR_EXT_IMG);

define('DIR_MEDIA', DIR_ROOT . "/media");
define('DIR_UPLOADS', DIR_MEDIA . '/uploads');
define('DIR_UPLOADS_IMG', DIR_UPLOADS . '/img');
