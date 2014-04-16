<?php
// Person Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'personApp.php';

class PersonTestCase extends WebIS\Validator {

	protected static $__CLASS__=__CLASS__;

	function testPerson() {
		$p=new \WCS\Person();
		$this->assertTrue($p->setPerson("DrMiddelkoop"));
		$this->assertFalse($p->setPerson("Dr.Middelkoop"));
		$this->assertEquals("{person: DrMiddelkoop}",$p->display(),"display only person");
		$this->assertTrue($p->setName("Dr. Middelkoop"));
		$this->assertFalse($p->setName(""));
		$this->assertFalse($p->setName(" "));
		$this->assertEquals("Dr. Middelkoop",$p->getName());
		$this->assertEquals("{person: DrMiddelkoop name: Dr. Middelkoop}",$p->display(),"adding name to object");
		// echo $p->display();
		$this->assertTrue($p->delete());
		$this->assertTrue($p->write());
		$this->assertTrue($p->setName("None"));
		$this->assertEquals("None",$p->getName());
		$this->assertTrue($p->read(),"Cannot read person from database");
		$this->assertEquals("Dr. Middelkoop",$p->getName(),"Dr. Middelkoop name does not match");
	}

	/**
	 * @depends testPerson
	 */
	function testPersonApp(){
		$p=new \WCS\Person();
		$this->assertTrue($p->setName("Dr. Middelkoop"));
		$a=new \WCS\PersonApp();
		$this->assertTrue($a->add($p),"Unable to add person to edit app");
		$this->assertContains("Dr. Middelkoop",$a->edit("person.php"),"Edit app does not edit");

		$a=new \WCS\PersonApp();
		$this->assertFalse($a->load(),"Should not load empty person");
		$_REQUEST['action']='Load';
		$_REQUEST['person']='DrMiddelkoop';
		$this->assertTrue($a->load(),"person:DrMiddelkoop is not in the database");
		$this->assertContains("Dr. Middelkoop",$p->getName(),"Person object does not contain name");
		$_REQUEST['action']='Update';
		$_REQUEST['person']='DrMiddelkoop';
		$_REQUEST['name']='Dr. Middelkoop';
		$this->assertTrue($a->save(),"Cannot save");
	}
	
	/**
	 * @depends testPersonApp
	 */
	function testPersonWeb(){
		$this->assertValidHTML('Web/person.php');
		$this->assertValidHTML('Web/person.php','Dr. Middelkoop',
				array('action'=>'Load','person'=>'DrMiddelkoop'),
				"unable to load from page");
		$this->assertValidHTML('Web/person.php','Dr. Timothy Middelkoop',
				array('action'=>'Update','person'=>'DrMiddelkoop','name'=>'Dr. Timothy Middelkoop'),
				"unable to save from page");
	}
	
}

if (!defined('PHPUnit_MAIN_METHOD')) {
	PersonTestCase::main();
}
?>