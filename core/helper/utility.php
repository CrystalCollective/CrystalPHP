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
 * Time: 04:07
 */

if(!function_exists("a")){
	function a($msg = ""){ echo $msg . " [abc]"; }
}

if(!function_exists("dd")){
	function dd($msg = ""){ echo $msg . " [abc]"; }
}

if(!function_exists('dd')){
	function dd($var = 0, $show_time = false){
		var_dump($var);
		
		show_time_of_exec($show_time);
		echo(genExecTrace());
		
		exit(0);
	}
}
if(!function_exists('vd')){
	function vd($var = 0, $show_time = false){
		var_dump($var);
		
		show_time_of_exec($show_time);
		echo(genExecTrace());
	}
}

function show_time_of_exec($show = false){
	$etime = (microtime(true) - TIME_START);
	
	if($show){
		echo "\n<div>Total Execution Time : $etime Secs</div>";
	}
}

function redirect($url){
	if(!$url){
		return false;
	}
	header('Location: ' . str_replace('&amp;', '&', $url));
	exit;
}

/*
 * Return formatted execution back stack
 *
 * @param $depth int/string  - depth of the trace back ('full' to get complete stack)
 * @return string
*/
function genExecTrace($depth = 5){
	$e = new Exception();
	$trace = explode("\n", $e->getTraceAsString());
	array_pop($trace); // remove call to this method
//	if($depth == 'full'){
	$length = count($trace);
//	} else{
	//	$length = $depth;
//	}
	$result = array();
	for($i = 0; $i < $length; $i++){
		$result[] = ' - ' . substr($trace[$i], strpos($trace[$i], ' '));
	}
	
	return "Execution stack: \t" . implode("\n<br>\t", $result);
}
