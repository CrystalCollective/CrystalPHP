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
 * Time: 11:51
 */

namespace CrystalPHP\Router;

class Route{
	/**
	 * @var string $url
	 */
	public $url;
	
	/**
	 * @var string $method
	 */
	public $method;
	
	/**
	 * @var \Closure $callback
	 */
	public $callback;
	
	/**
	 * @var string $name
	 */
	public $name = "";
	
	public function __construct($method, $url, $callback, $name = ""){
		$this->url = $url;
		$this->method = $method;
		$this->callback = $callback;
		$this->name = $name;
	}
	
	/**
	 * @param $name
	 * @return $this
	 */
	public function name($name){
		$this->name = $name;
		Router::addRoutesByName($this->name, $this->method, $this->url);
		return $this;
	}
}