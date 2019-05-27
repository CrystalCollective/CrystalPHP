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
 * Time: 17:39
 */

namespace CrystalPHP;

use CrystalPHP\Lib\JSON as JSON;

class REST{
	
	const DEFAULT_RESPONSE_FORMAT = 'json';
	private $responseData;
	private $registry; // Default response format
	
	public function __construct(){
		$this->registry = Registry::getInstance();
	}
	
	/*
	* Adding to the response array
	*/
	
	public function setResponseFail($msg = null){
		$this->setResponse(false, [], $msg ? $msg : "Sorry, Request failed.");
	}
	
	public function setResponse($result, $data, $msg = ""){
		$this->setResponseData($data);
		$this->setResponseResult($result);
		$this->setResponseMsg($msg);
	}
	
	public function setResponseData($response_arr){
		$this->responseData = $response_arr;
	}
	
	public function setResponseResult($result = false){
		$this->responseData['result'] = $result;
	}
	
	public function setResponseMsg($response_msg){
		$this->responseData['message'] = $response_msg;
	}
	
	public function sendResponse($status, $response_arr = array()){
		
		$this->responseData = array_merge($response_arr, $this->responseData);
		
		$this->registry->response->addJSONHeader();
		$this->registry->response->sendResponse($status, JSON::encode($this->responseData));
	}
	
	public function __get($name){
		return $this->registry->get($name);
	}
	
	public function __set($name, $value){
		$this->registry->set($name, $value);
	}
	
}

