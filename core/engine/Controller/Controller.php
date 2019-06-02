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
 * Time: 14:00
 */

namespace CrystalPHP\Controller;

use CrystalPHP\Config\Config;
use CrystalPHP\Config\Configs;
use CrystalPHP\Registry;
use CrystalPHP\View;

/**
 * Class Controller
 *
 * @property \CrystalPHP\Registry $registry
 */
class Controller{
	
	protected $registry;
	
	protected $id;
	
	protected $instance_id;
	
	protected $enableDispatch = false;
	/**
	 * @var array Controller
	 */
	protected $childs = array();
	
	/**
	 * @var View
	 */
	protected $view;
	
	protected $_data;
	
	/**
	 * Controller constructor.
	 * @param Registry $registry
	 * @param $id
	 * @param $instance_id
	 * @param null $data \
	 */
	public function __construct($registry, $id, $instance_id, $data = null){
		$this->registry = $registry;
		
		$this->view = new View($this->registry, $id, $instance_id);
		$this->view->batchAssign($data);
		
		$this->_data = $data;
		$this->init();
	}
	
	public function init(){
	
	}
	
	public function __get($key){
		return $this->registry->get($key);
	}
	
	public function __set($key, $value){
		$this->registry->set($key, $value);
	}
	
	public function isDispatchEnabled(){
		return $this->enableDispatch;
	}
	
	public function getView(){ }
	
	/**
	 * @return string
	 * @throws ControllerException
	 * @throws \Exception
	 */
	public function dispatch(){
		if(!$this->enableDispatch){
			$this->render();
		}
		
		return $output = $this->view->getOutput();
	}
	
	/**
	 * @throws ControllerException
	 * @throws \Exception
	 */
	public function render(){
		$child_dispatch = $this->getChildrenDispatch();
		$this->view->batchAssign($child_dispatch);
		$this->view->enableOutput();
		$this->view->render();
		
		$this->enableDispatch(true);
	}
	
	/**
	 * @return array
	 * @throws ControllerException
	 */
	public function getChildrenDispatch(){
		$childContent = array();
		foreach($this->childs as $id => $child_group){
			foreach($child_group as $index => $child){
				$filename = $child['file'];
				$controllerClass = $child['class'];
				$controllerMethod = $child['method'];
				
				if(is_file($filename)){
					require_once($filename);
					
					
					$controllerClass = Config::get(Configs::NAMESPACE, "/") . $controllerClass;
					
					if(class_exists($controllerClass)){
						
						/**
						 * @var $controller Controller
						 */
						$controller = new $controllerClass($this->registry, $child['id'], $child['instance_id'], $child['data']);
						
						call_user_func_array(array($controller, $controllerMethod), ['data' => $child['data']]);
						
						if(sizeof($child_group) > 1){
							$childContent[$id][$index] = $controller->dispatch();
						} else{
							$childContent[$id] = $controller->dispatch();
						}
					} else{
						throw new ControllerException(__FUNCTION__ . " class Does not exist : " . $controllerClass);
					}
				} else{
					throw new ControllerException($filename . " File not found " . __FUNCTION__);
				}
			}
		}
		return $childContent;
	}
	
	public function enableDispatch($enable){
		return $this->enableDispatch = $enable;
	}
	
	/**
	 * @param $id
	 * @param int $instance_id
	 * @param $filename
	 * @param $class
	 * @param string $method
	 * @param array $data
	 * @return array
	 */
	public function addChild($id, $instance_id = 0, $filename, $class, $method = "index", $data = array()){
		
		$this->childs[$id][$instance_id] = array(
			'id' => $id,
			'instance_id' => $instance_id,
			'file' => $filename,
			'class' => $class,
			'method' => $method,
			'data' => $data,
		);
		return $this->childs;
	}
	
	public function getChilds(){
		return $this->childs;
	}
	
	
}