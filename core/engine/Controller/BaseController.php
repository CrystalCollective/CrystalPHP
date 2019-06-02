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
 * Time: 15:56
 */

namespace CrystalPHP\Controller;


class BaseController extends Controller{
	
	
	function init(){
		parent::init();
	}
	
	public function setupPage(){
		//Set Root template
		//$this->view->setView("<file path>");
	}
	
	/**
	 * @throws ControllerException
	 */
	public function pageRender(){
		$this->getCommons();
		$this->render();
	}
	
	public function getCommons(){
		//Add Common Layouts as childs like header, footer, navbar main, side
	}
	
	public function render(){
		parent::render();
	}
	
	public function dispatch(){
		return parent::dispatch();
	}
	
	public function setRootTemplate($filename){
		$this->view->setView($filename);
	}
}