<?php
function AssertEquals($expected,$result){
	if(!($expected==$result)){
		throw new Exception("Assert Equals failed");
	}
}

assertEquals("1","1");

function AssertNotEquals($expected,$result){
	if($expected===$result){
		throw new Exception("Assert Not Equals Failed");
	}
	return TRUE;
}

function assertTrue($result){
	return assertEquals(TRUE,$result);
}

function assertFalse($result){
	return assertEquals(FALSE,$result);
}

?>