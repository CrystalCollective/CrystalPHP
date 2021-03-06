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
 * Time: 15:33
 */
class ControllerModulePublicPage extends \CrystalPHP\Controller\Controller{
	
	
	function home(){
		
		$this->view->setView(DIR_MODULE_PUBLIC . "/views/home.php");
		
		
		$this->render();
	}
}