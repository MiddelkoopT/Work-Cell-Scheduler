<?php
// Ping Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WCS;
require_once 'Work-Cell-Scheduler/Config/global.php';

class Ping{

	/**
	 * Returns TRUE
	 * @return bool
	 */
	function config(){
		return Config::$config;
	}
	
	/**
	 * Ping method
	 * @param string $string Ping string
	 * @return string Ping string with 'pong:' prepended
	 */
	function ping($string){
		return "pong:".$string;
	}
	
}

?>
