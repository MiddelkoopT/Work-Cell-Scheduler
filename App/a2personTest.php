<?php

require_once 'a2personApp.php';
 
class personTest {

	function test_personApp(){
		$p=new personApp();
		$this->assertTrue($p->setPerson("Tim_Merkel"));
		$this->assertFalse($p->setPerson("Tim_Merkel "));
		$this->assertEquals("{person: Tim_Merkel}",$p->display());
		
		$this->assertTrue($p->setName("Tim Kurt Merkel"));
		$this->assertEquals("{person: Tim_Merkel name: Tim Kurt Merkel}",$p->display());
		$this->assertTrue($p->delete());
		$this->assertTrue($p->delete()); 
		$this->assertTrue($p->insert());
		$this->assertFalse($p->insert(),"record exists, should return false");
		
		$p=new personApp();
		$this->assertTrue($p->setPerson("Tim_Merkel"));
		$this->assertTrue($p->get());
		$this->assertEquals("{person: Tim_Merkel name: Tim Kurt Merkel}",$p->display());
		}
		
		
		
	}
	
?>
		



?>