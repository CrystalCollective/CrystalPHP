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
 * Date: 24-05-2019
 * Time: 06:59
 */

namespace CrystalPHP;

/**
 * Class View
 * @package CrystalPHP
 *
 * @property App $app;
 */
class View{
	/**
	 * @var array
	 */
	public $data = array();
	/**
	 * @var $registry Registry
	 */
	protected $registry;
	/**
	 * @var
	 */
	protected $id;
	/**
	 * @var string
	 */
	protected $view = '';
	/**
	 * @var string
	 */
	protected $default_view;
	/**
	 * @var int
	 */
	protected $instance_id;
	/**
	 * @var bool
	 */
	protected $enableOutput = false;
	/**
	 * @var string
	 */
	protected $output = '';
	protected $render;
	
	/**
	 * @param Registry $registry
	 * @param int $id
	 * @param int $instance_id
	 */
	public function __construct($registry, $id, $instance_id){
		$this->registry = $registry;
		$this->id = $id;
		$this->instance_id = $instance_id;
	}
	
	public function __get($key){
		return $this->registry->get($key);
	}
	
	public function __set($key, $value){
		$this->registry->set($key, $value);
	}
	
	/**
	 * @param bool $enable
	 * set false to disable
	 */
	public function enableOutput($enable = true){
		$this->enableOutput = $enable;
	}
	
	
	/**
	 * @param string $view
	 */
	public function setView($view){
		$this->view = $view;
	}
	
	/**
	 * @return string
	 */
	public function getTemplate(){
		return $this->view;
	}
	
	/**
	 * Return array with available variables and types in the view
	 * @param string $key - optional parameter to specify variable type of array.
	 * @return array | mixed
	 */
	public function getVariables($key = ''){
		$variables = array();
		if($key){
			$scope = $this->data[$key];
		} else{
			$scope = $this->data;
		}
		if(is_array($scope)){
			foreach(array_keys($scope) as $var){
				$variables[$var] = gettype($scope[$var]);
			}
		}
		return $variables;
	}
	
	/**
	 * @param string $key - optional parameter for better access from hook that called by "_UpdateData".
	 * @return array | mixed - reference to $this->data
	 */
	public function &getData($key = ''){
		if($key){
			return $this->data[$key];
		} else{
			return $this->data;
		}
	}
	
	/**
	 * @param $template_variable
	 * @param string $value
	 * @param string $default_value
	 * @return null|bool
	 */
	public function assign($template_variable, $value = '', $default_value = ''){
		if(empty($template_variable)){
			return null;
		}
		if(!is_null($value)){
			$this->data[$template_variable] = $value;
		} else{
			$this->data[$template_variable] = $default_value;
		}
		return true;
	}
	
	/**
	 * Call append if you need to add values to earlier assigned value
	 * @param string $template_variable
	 * @param string $value
	 * @param string $default_value
	 * @return null
	 */
	public function append($template_variable, $value = '', $default_value = ''){
		if(empty($template_variable)){
			return null;
		}
		if(!is_null($value)){
			$this->data[$template_variable] = $this->data[$template_variable] . $value;
		} else{
			$this->data[$template_variable] = $this->data[$template_variable] . $default_value;
		}
		return true;
	}
	
	/**
	 * @param array $assign_arr - associative array
	 * @return null
	 */
	public function batchAssign($assign_arr){
		if(empty($assign_arr) || !is_array($assign_arr)){
			return null;
		}
		
		foreach($assign_arr as $key => $value){
			//when key already defined and type of old and new values are different send warning in debug-mode
			if(isset($this->data[$key]) && is_object($this->data[$key])){
				$warning_text = 'Warning! Variable "' . $key . '" in template "' . $this->view . '" overriding value and data type "object." ';
				$warning_text .= 'Possibly need to review your code! (also check that extensions do not load language definitions in UpdateData hook).';
				$this->app->logger->warning($warning_text);
				continue; // prevent overriding.
			} elseif(isset($this->data[$key]) && gettype($this->data[$key]) != gettype($value)){
				$warning_text = 'Warning! Variable "' . $key . '" in template "' . $this->view . '" overriding value and data type "' . gettype($this->data[$key]) . '" ';
				$warning_text .= 'Forcing new data type ' . gettype($value) . '. Possibly need to review your code!';
				$this->app->logger->warning($warning_text);
			}
			$this->data[$key] = $value;
		}
		return true;
	}
	
	// Render html output
	
	/**
	 * @throws \Exception
	 */
	public function render(){
		// If no template return empty. We might have controller that has no templates
		if(!empty($this->view) && $this->enableOutput){
			$compression = '';
			
			if(!empty($this->output)){
				$this->setOutput($this->output, $compression);
			} else{
				$this->setOutput($this->fetch($this->view), $compression);
			}
		}
		
	}
	
	/**
	 * Process the template
	 * @param $filename
	 * @return string
	 * @throws \Exception
	 */
	public function fetch($filename){
		$this->app->logger->info('Template Render : fetch ' . $filename . ' start ');
		
		//#PR First see if we have full path to template file. Nothing to do. Higher precedence!
		if(is_file($filename)){
			//#PR set full path
			$file = $filename;
		} else{
			throw new \Exception("Template File : $filename File Not Found");
		}
		
		if(empty($file)){
			$this->app->logger->error('Error: Unable to identify file path to template ' . $filename
				. '! Check blocks in the layout or enable debug mode to get more details. ');
			return '';
		}
		
		if(is_file($file)){
			$content = '';
			/*$file_pre - File Pre fetching implement*/
			
			$content .= $this->_fetch($file);
			
			/*$file_post - File Post fetching implement*/
			$this->app->logger->info('Template Render : fetch ' . $filename . ' end');
			return $content;
		} else{
			$this->app->logger->error('Error: Cannot load template ' . $filename . '! File ' . $file .
				' is missing or incorrect. Check blocks in the layout or enable debug mode to get more details. ');
		}
		
		return '';
	}
	
	/**
	 * @param $file - full path
	 * @param array $data_extra
	 * @return string
	 * @throws \Exception
	 */
	public function _fetch($file, $data_extra = []){
		
		if(!file_exists($file)) return '';
		
		$this->app->logger->info('Template Load : _fetch ' . $file . ' start');
		
		if(!is_array($data_extra)){
			throw new \Exception("Not an array");
		}
		if(!is_array($this->data)){
			throw new \Exception("Not an array");
		}
		
		extract($this->data);
		extract($data_extra);
		
		ob_start();
		/** @noinspection PhpIncludeInspection */
		require($file);
		$content = ob_get_contents();
		ob_end_clean();
		
		$this->app->logger->info('Template Load : _fetch ' . $file . ' end');
		return $content;
	}
	
	/**
	 * @return string
	 * @throws \Exception
	 */
	public function getOutput(){
		return (!empty($this->output)) ? ($this->output) : (!empty($this->view) ? $this->fetch($this->view) : '');
	}
	
	/**
	 * @param string $output
	 * @param string $compression
	 * @void
	 */
	public function setOutput($output, $compression = ''){
		$this->output = $output;
	}
	
	
}