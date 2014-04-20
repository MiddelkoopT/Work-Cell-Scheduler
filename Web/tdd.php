<?php
// TDD basics Copyright 2014 by WebIS Spring 2014 License Apache 2.0

function assertEquals($expected,$result) {
	if(!($expected===$result)){
		$message="assertEquals: |$expected|$result|\n";
		throw new Exception($message);
	}
}

function assertNotEquals($expected,$result) {
	if(($expected===$result)){
		$message="assertNotEquals: |$expected|$result|\n";
		throw new Exception($message);
	}
}

function assertContainsString($needle,$haystack){
	if(strpos($haystack,$needle)===FALSE){
		$message="assertContainsString: |$needle|$haystack|";
		throw new Exception($message);
	}
}

function assertContains($needle,$haystack){
	if(is_string($haystack)){
		return assertContainsString($needle,$haystack);
	}
	foreach($haystack as $hay)
	if(strpos($hay,$needle)!==FALSE){
		return;
	}
	$message="assertContains: |$needle|$haystack|";
	throw new Exception($message);
}

function assertTrue($result){
	return assertEquals(TRUE,$result);
}

function assertFalse($result){
	return assertEquals(FALSE,$result);
}


?>
