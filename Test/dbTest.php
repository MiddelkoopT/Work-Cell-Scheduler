<?php
// Database Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';

class MyTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;
	
	function execute($db,$sql){
		$stmt=$db->prepare($sql);
		$this->assertNotEquals(FALSE,$stmt,$db->error);
		$this->assertTrue($stmt->execute(),$db->error);
		$stmt->close();
	}
	
	function testDatabase() {
		// mysqli module
		$this->assertTrue(extension_loaded('mysqli'),"mysqli module not loaded, make sure php.ini is loaded");
		$this->assertTrue(function_exists('mysqli_init'),"mysqli module not loaded, make sure php.ini is loaded");
		
		// Test connection and create test database
		$db=new mysqli('127.0.0.1','root','webis','');
		$this->assertNotNull($db,"Unable to create database handle");
		$this->execute($db,'DROP DATABASE IF EXISTS WCSTDD;');
		$this->execute($db,'CREATE DATABASE WCSTDD;');
		$db->close();

		// Connect to database and create test table with data
		$db=new mysqli('127.0.0.1','root','webis','WCSTDD');
		$this->assertNotNull($db,"Unable to create database handle");
		$this->execute($db,'CREATE TABLE Map (k integer, v varchar(30));');
		$this->execute($db,"INSERT INTO Map (k,v) VALUES (2,'世界')");

		// Test SELECT and utf-8 data.
		$id=2;
		$stmt=$db->prepare("SELECT v FROM Map WHERE k=?");
		$this->assertNotEquals(FALSE,$stmt,$db->error);
		$this->assertTrue($stmt->bind_param("d",$id),$db->error);
		$this->assertTrue($stmt->execute(),$db->error);
		$this->assertTrue($stmt->bind_result($value));
		$this->assertTrue($stmt->fetch());
		$this->assertEquals('世界',$value,"SELECT value does not match INSERT");
		$this->assertEquals(FALSE,$stmt->fetch(),"Unexpected results");
		$stmt->close();
		$db->close();
	}
						
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	MyTEstCase::main();
}

?>

