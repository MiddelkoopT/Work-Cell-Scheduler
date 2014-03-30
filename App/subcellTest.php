<?php
// Subcell Test Copyright 2014 by WebIS Spring 2014 License Apache 2.0
require_once 'Work-Cell-Scheduler/TDD/validator.php';
include 'Work-Cell-Scheduler/Config/local.php';
require_once 'subcellApp.php';

class SubcellTestCase extends WebIS\Validator {
	protected static $__CLASS__=__CLASS__;
	
	
	
	function testSubcell(){
		$s=new\WCS\Subcell();
		$this->assertTrue($s->setSubcell("j100"));
		$this->assertFalse($s->setSubcell("j.100"));
		
		
		
		
		
		
		
		
		
	}
	
	
	
	
	
	
	
	
	
}