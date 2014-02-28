<?php
// Database Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/Config/global.php';
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';

class DbTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function execute($db,$sql){
		$stmt=$db->prepare($sql);
		$this->assertNotEquals(FALSE,$stmt,$db->error);
		$this->assertTrue($stmt->execute(),$db->error);
		$stmt->close();
	}
	
	function testMysqli() {
		// mysqli module
		$this->assertTrue(extension_loaded('mysqli'),"mysqli module not loaded, make sure php.ini is loaded");
		$this->assertTrue(function_exists('mysqli_init'),"mysqli module not loaded, make sure php.ini is loaded");
	}

	/**
	 * @depends testMysqli
	 */
	function testConnection() {
		// Test connection and create test database
		$db=new mysqli(WCS\Config::$dbhost,WCS\Config::$dbuser,WCS\Config::$dbpassword,'');
		$this->assertNotNull($db,"Unable to create database handle");
		$this->execute($db,'DROP DATABASE IF EXISTS WCSTDD;');
		$this->execute($db,'CREATE DATABASE WCSTDD;');
		$db->close();

		// Connect to database and create test table with data
		$db=new mysqli(WCS\Config::$dbhost,WCS\Config::$dbuser,WCS\Config::$dbpassword,'WCSTDD');
		$this->assertNotNull($db,"Unable to create database handle");
		$this->execute($db,'CREATE TABLE Map (k integer, v varchar(30));');
		$this->execute($db,"INSERT INTO Map (k,v) VALUES (2,'世界')");

		// Test SELECT and utf-8 data.
		$id=2;
		$stmt=$db->prepare("SELECT v FROM Map WHERE k=?");
		$this->assertNotEquals(FALSE,$stmt,$db->error);
		$this->assertTrue($stmt->bind_param("d",$id),$db->error);
		$this->assertTrue($stmt->bind_result($value));
		$this->assertTrue($stmt->execute(),$db->error);
		$this->assertTrue($stmt->fetch());
		$this->assertEquals('世界',$value,"SELECT value does not match INSERT");
		$this->assertEquals(FALSE,$stmt->fetch(),"Unexpected results");
		$stmt->close();
		$db->close();
	}
	
	/**
	 * @depends testMysqli
	 */
	function testDatabase() {
		// Test proper database configuration, CREATE WCS if it does not exist
		$db=new mysqli(WCS\Config::$dbhost,WCS\Config::$dbuser,WCS\Config::$dbpassword,'');
		$this->assertNotNull($db,"Unable to create database handle");
		//$this->execute($db,'DROP DATABASE IF EXISTS WCS;'); // Force reload
		$stmt=$db->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'WCS'");
		$this->assertNotEquals(FALSE,$stmt,$db->error);
		$this->assertTrue($stmt->bind_result($name));
		$this->assertTrue($stmt->execute(),$db->error);
		$result=$stmt->fetch();
		$stmt->close();
		if($result==TRUE){
			$this->assertEquals("wcs",$name,"Database name does not match query");
			$db->close();
			return;
		}
		// Database needs to be created
		$this->execute($db,'CREATE DATABASE WCS;');
		$db->close();

		// Reconnect with WCS
		$db=new mysqli(WCS\Config::$dbhost,WCS\Config::$dbuser,WCS\Config::$dbpassword,'WCS');
		$this->assertNotNull($db,"Unable to create database handle to connect to WCS database");

		// Load schema 
		$schema=file_get_contents('../Config/database.sql');
		$this->assertContains("TrainingMatrix",$schema);
		$this->assertNotEquals(FALSE,$schema);
		$this->assertTrue($db->multi_query($schema),"schmea did not execute:".$db->error);
		$db->close();
	}
						
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	DbTestCase::main();
}

?>

