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
 * Time: 21:26
 */

use CrystalPHP\Controller\BaseController;
use CrystalPHP\Controller\ControllerException;


class ControllerBaseDefaultPage extends BaseController{
	
	function init(){
		parent::init();
	}
	
	public function setupPage(){
		//Set Root template
		$this->view->setView(DIR_MODULE_BASE_DEFAULT . "/views/template.php");
	}
	
	/**
	 * @throws ControllerException
	 */
	public function pageRender(){
		$this->getCommons();
		$this->render();
	}
	
	
	public function getCommons(){
		$this->addChild('navbar_top', 0, DIR_MODULE_BASE_DEFAULT . "/controller_commons.php", "ControllerBaseDefaultCommons", "navbar_top");
		$this->addChild('footer', 0, DIR_MODULE_BASE_DEFAULT . "/controller_commons.php", "ControllerBaseDefaultCommons", "footer");
		$this->addChild('foot', 0, DIR_MODULE_BASE_DEFAULT . "/controller_commons.php", "ControllerBaseDefaultCommons", "foot");
		$this->addChild('head', 0, DIR_MODULE_BASE_DEFAULT . "/controller_commons.php", "ControllerBaseDefaultCommons", "head");
	}
	
	public function render(){
		parent::render();
	}
	
	public function dispatch(){
		return parent::dispatch();
	}
	
	public function setRootTemplate($filename, $fullpath = false){
		if($fullpath){
			$this->view->setView($filename);
		} else{
			$this->view->setView(DIR_MODULES . "template/page/$filename.php");
		}
	}
	
}