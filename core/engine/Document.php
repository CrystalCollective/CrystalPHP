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
 * Time: 21:47
 */

namespace CrystalPHP;


use CrystalPHP\Config\Config;

class Document{
	
	const DOCUMENT = 'document';
	const TITLE = 'title';
	const DESCRIPTION = 'description';
	const KEYWORDS = 'keywords';
	const CHARSET = 'charset';
	const LANG = 'language';
	const DIRECTION = 'direction';
	const BREADCRUMBS = 'breadcrumbs';
	const METADATA = 'metadata';
	const SCRIPTS = 'scripts';
	const STYLES = 'styles';
	const SCRIPT_FILES = 'script_files';
	const STYLE_FILES = 'style_files';
	const SCRIPT_LINKS = 'script_links';
	const STYLE_LINKS = 'style_links';
	
	private static $data = [];
	
	public static function reset(){
		self::init();
	}
	
	public static function getData(){
		return self::$data;
	}
	
	public static function get($res_name){
		return isset(self::$data[$res_name]) ? self::$data[$res_name] : "";
	}
	
	/**
	 * @return string
	 */
	public static function getTitle(){
		return self::$data[self::TITLE];
	}
	
	/**
	 * @param string $title
	 */
	public static function setTitle($title){
		self::$data[self::TITLE] = $title;
	}
	
	/**
	 * @return string
	 */
	public static function getDescription(){
		return self::$data[self::DESCRIPTION];
	}
	
	/**
	 * @param string $description
	 * @void
	 */
	public static function setDescription($description, $trim = false){
		if($trim){
			self::$data[self::DESCRIPTION] = self::trimText($description, 300, false, true);
		} else{
			self::$data[self::DESCRIPTION] = $description;
		}
	}
	
	/**
	 * trims text with set length and ellipes
	 * @param string $input text to trim
	 * @param int $length in characters to trim to
	 * @param bool $ellipses if ellipses (..ō.) are to be added
	 * @param bool $strip_html if html tags are to be stripped
	 * @return string
	 */
	public static function trimText($input, $length, $ellipses = true, $strip_html = false){
		//strip tags, if desired
		if($strip_html){
			$input = strip_tags($input);
		}
		
		//no need to trim, already shorter than trim length
		if(strlen($input) <= $length){
			return $input;
		}
		
		//find last space within length
		$last_space = strrpos(substr($input, 0, $length), ' ');
		$trimmed_text = substr($input, 0, $last_space);
		
		//add ellipses (...)
		if($ellipses){
			$trimmed_text .= '...';
		}
		
		return $trimmed_text;
	}
	
	/**
	 * @param $url
	 * @param bool $absolute
	 */
	public static function setOgUrl($url, $absolute = false){
		if($absolute){
			self::$data['og:url'] = $url;
		} else{
			self::$data['og:url'] = HTTPS_SERVER . $url;
		}
	}
	
	/**
	 * @return string
	 */
	public static function getOgUrl(){
		return self::$data['og:url'];
	}
	
	/**
	 * @param $keywords
	 * @param bool $reset
	 * @return bool|mixed
	 */
	public static function addKeywords($keywords, $reset = false){
		if($reset) self::$data[self::KEYWORDS] = [];
		
		if(is_array($keywords)){
			foreach($keywords as $keyword){
				array_unshift(self::$data[self::KEYWORDS], $keyword);
			}
			return self::$data[self::KEYWORDS];
		}
		
		if(is_string($keywords)){
			array_unshift(self::$data[self::KEYWORDS], $keywords);
			return self::$data[self::KEYWORDS];
		}
		
		return false;
	}
	
	/**
	 * @param bool $str
	 * @return string|mixed
	 */
	public static function getKeywords($str = false){
		if($str){
			$kw_str = "";
			for($i = 0; ($i < 10 && $i < sizeof(self::$data[self::KEYWORDS])); $i++){
				$kw_str .= self::$data[self::KEYWORDS][$i] . ",";
			}
			
			return $kw_str;
		}
		
		return self::$data[self::KEYWORDS];
	}
	
	/**
	 * @param $scripts
	 * @param bool $reset
	 * @return bool|mixed
	 */
	public static function addScript($scripts, $reset = false){
		
		if($reset){
			self::$data[self::SCRIPTS] = [];
		}
		
		if(is_array($scripts)){
			foreach($scripts as $script){
				array_push(self::$data[self::SCRIPTS], $script);
			}
			return self::$data[self::SCRIPTS];
		}
		
		if(is_string($scripts)){
			array_push(self::$data[self::SCRIPTS], $scripts);
			return self::$data[self::SCRIPTS];
		}
		
		return false;
	}
	
	/**
	 * @param bool $str
	 * @return mixed|string
	 */
	public static function getScripts($str = false){
		if($str){
			$kw_str = "";
			foreach(self::$data[self::SCRIPTS] as $kw){
				$kw_str .= $kw . " ";
			}
			return $kw_str;
		}
		return self::$data[self::SCRIPTS];
	}
	
	/**
	 * @param string|array $styles
	 * @param bool $reset
	 * @return bool|mixed
	 */
	public static function addStyle($styles, $reset = false){
		if($reset){
			self::$data[self::SCRIPTS] = [];
		}
		
		if(is_array($styles)){
			foreach($styles as $style){
				array_push(self::$data[self::STYLES], $style);
			}
			return self::$data[self::STYLES];
		}
		
		if(is_string($styles)){
			array_push(self::$data[self::STYLES], $styles);
			return self::$data[self::STYLES];
		}
		
		return false;
	}
	
	/**
	 * @param bool $str
	 * @return mixed|string
	 */
	public static function getStyles($str = false){
		if($str){
			$kw_str = "";
			foreach(self::$data[self::STYLES] as $kw){
				$kw_str .= $kw;
			}
			return minify_css($kw_str);
		}
		
		return self::$data[self::STYLES];
	}
	
	public static function getStylesStr(){
	}
	
	/**
	 * @param $for
	 * @param $page_path
	 * @return mixed
	 */
	public static function setStylePage($for, $page_path){
		self::$data[self::STYLE_FILES][$for] = $page_path;
		return self::$data[self::STYLE_FILES];
	}
	
	/**
	 * @param $for
	 * @return string
	 */
	public static function getStylePage($for){
		return isset(self::$data[self::STYLE_FILES][$for]) ? self::$data[self::STYLE_FILES][$for] : "";
	}
	
	public static function getStylesPageStr(){
		$kw_str = "";
		
		foreach(self::$data[self::STYLE_FILES] as $sp){
			$kw_str .= get_minified_css_from_file($sp);
		}
		return $kw_str;
	}
	
	/**
	 * @param $for
	 * @param $page_path
	 * @return mixed
	 */
	public static function setScriptPage($for, $page_path){
		self::$data[self::SCRIPT_FILES][$for] = $page_path;
		return self::$data[self::SCRIPT_FILES];
	}
	
	/**
	 * @param $for
	 * @return string
	 */
	public static function getScriptPage($for){
		return isset(self::$data[self::SCRIPT_FILES][$for]) ? self::$data[self::SCRIPT_FILES][$for] : "";
	}
	
	public static function getScriptsPageStr(){
		$kw_str = "";
		
		foreach(self::$data[self::SCRIPT_FILES] as $sp){
			$kw_str .= get_minified_css_from_file($sp);
		}
		return $kw_str;
	}
	
	/**
	 * @param $scripts
	 * @param int $priority
	 * @param bool $reset
	 * @return bool|mixed
	 */
	public static function addScriptLink($scripts, $priority = 5, $reset = false){
		
		if($reset){
			self::$data[self::SCRIPT_LINKS] = [];
		}
		
		if(count($scripts) == count($scripts, COUNT_RECURSIVE)){
			self::$data[self::SCRIPT_LINKS][$priority][] = $scripts;
			return self::$data[self::SCRIPT_LINKS];
		}
		
		if(is_array($scripts)){
			foreach($scripts as $script){
				self::$data[self::SCRIPT_LINKS][$priority][] = $script;
			}
			
			return self::$data[self::SCRIPT_LINKS];
		}
		return false;
	}
	
	/**
	 * @param int $priority
	 * @return mixed
	 */
	public static function getScriptLinks($priority = -1){
		if(is_int($priority) && $priority >= 0){
			return isset(self::$data[self::SCRIPT_LINKS][$priority]) ? self::$data[self::SCRIPT_LINKS][$priority] : [];
		}
		
		ksort(self::$data[self::SCRIPT_LINKS]);
		
		if(is_array($priority) && count($priority) == 2){
			foreach(self::$data[self::SCRIPT_LINKS] as $prio => $script){
				if($prio >= $priority[0] && $prio <= $priority[1]) $scripts[] = $script;
			}
			return call_user_func_array('array_merge', $scripts);
		}
		
		return call_user_func_array('array_merge', self::$data[self::SCRIPT_LINKS]);
	}
	
	/**
	 * @param $style
	 * @param int $priority
	 * @param bool $reset
	 * @return bool|mixed
	 */
	public static function addStyleLink($styles, $priority = 5, $reset = false){
		
		if($reset){
			self::$data[self::STYLE_LINKS] = [];
		}
		
		if(count($styles) == count($styles, COUNT_RECURSIVE)){
			self::$data[self::STYLE_LINKS][$priority][] = $styles;
			return self::$data[self::STYLE_LINKS];
		}
		
		if(is_array($styles)){
			foreach($styles as $style){
				self::$data[self::STYLE_LINKS][$priority][] = $style;
			}
			
			return self::$data[self::STYLE_LINKS];
		}
		return false;
	}
	
	/**
	 * @return array
	 */
	public static function getStyleLinks($priority = -1){
		if(is_int($priority) && $priority >= 0){
			return isset(self::$data[self::STYLE_LINKS][$priority]) ? self::$data[self::STYLE_LINKS][$priority] : [];
		}
		
		ksort(self::$data[self::STYLE_LINKS]);
		
		if(is_array($priority) && count($priority) == 2){
			foreach(self::$data[self::STYLE_LINKS] as $prio => $script){
				if($prio >= $priority[0] && $prio <= $priority[1]) $styles[] = $script;
			}
			return call_user_func_array('array_merge', $styles);
		}
		
		return call_user_func_array('array_merge', self::$data[self::STYLE_LINKS]);
	}
	
	/**
	 * @return string
	 */
	public static function getCharset(){
		return self::$data[self::CHARSET];
	}
	
	/**
	 * @param string $charset
	 */
	public static function setCharset($charset){
		self::$data[self::CHARSET] = $charset;
	}
	
	/**
	 * @param string $language
	 */
	public static function setLanguage($language){
		self::$data[self::LANG] = $language;
	}
	
	/**
	 * @return string
	 */
	public static function getLanguage(){
		return self::$data[self::LANG];
	}
	
	/**
	 * @return string
	 */
	public static function getDirection(){
		return self::$data[self::DIRECTION];
	}
	
	/**
	 * @param string $direction
	 */
	public static function setDirection($direction){
		self::$data[self::DIRECTION] = $direction;
	}
	
	/**
	 * @void
	 */
	public static function resetMetadata(){
		self::$data[self::METADATA] = array();
	}
	
	public static function addMetadata($key, $val){
		if($val){
			self::$data[self::METADATA][$key] = $val;
		}
	}
	
	public static function getMetadata($key){
		if(isset(self::$data[self::METADATA][$key])){
			return self::$data[self::METADATA][$key];
		} else{
			return false;
		}
	}
	
	public static function getMetadataAll(){
		return self::$data[self::METADATA];
	}
	
	/**
	 * method to initialize Breadcrumbs aray and add root attribute
	 *
	 * @param array $breadcrumb_item ("href"=>"", "text"=>"", "separator"=>)
	 * @void
	 */
	public static function initBreadcrumb($breadcrumb_item = []){
		self::resetBreadcrumbs();
		
		self::addBreadcrumb($breadcrumb_item);
	}
	
	/**
	 * method to reset breadcrumbs array
	 * @void
	 */
	public static function resetBreadcrumbs(){
		self::$data[self::BREADCRUMBS] = [];
	}
	
	/**
	 * method add new Breadcrumb item
	 *
	 * @param array $breadcrumb_item ("href"=>"", "text"=>"", "separator"=>)
	 * @void
	 */
	public static function addBreadcrumb($breadcrumb_item = array()){
		if($breadcrumb_item["href"]){
			self::$data[self::BREADCRUMBS][] = $breadcrumb_item;
		}
	}
	
	/**
	 * @return array
	 */
	public static function getBreadcrumbs(){
		return self::$data[self::BREADCRUMBS];
	}
	
	public function __instance(){
		self::init();
	}
	
	public static function init(){
		$data = [];
		$data[self::TITLE] = Config::get(Document::TITLE, "CrystalPHP - flexible MVC Framework", Document::DOCUMENT);
		$data[self::DESCRIPTION] = Config::get(Document::DESCRIPTION, "A flexible MVC Framework for fast web development", Document::DOCUMENT);
		$data[self::KEYWORDS] = Config::get(Document::KEYWORDS, ["CrystalPHP", "crystal collective", "Framework"], Document::DOCUMENT);
		$data[self::CHARSET] = Config::get(Document::CHARSET, 'utf-8', Document::DOCUMENT);
		$data[self::LANG] = Config::get(Document::LANG, 'en-gb', Document::DOCUMENT);
		$data[self::DIRECTION] = Config::get(Document::DIRECTION, 'ltr', Document::DOCUMENT);
		$data[self::BREADCRUMBS] = [];
		$data[self::METADATA] = [];
		$data[self::SCRIPTS] = [];
		$data[self::STYLES] = [];
		$data[self::STYLE_FILES] = [];
		$data[self::SCRIPT_FILES] = [];
		$data[self::STYLE_LINKS] = [];
		$data[self::SCRIPT_LINKS] = [];
		
		$data['og:url'] = defined('REQUEST_URI_PATH') ? HTTPS_SERVER . REQUEST_URI_PATH : $_SERVER['REQUEST_URI'];
		
		self::$data = $data;
	}
}

