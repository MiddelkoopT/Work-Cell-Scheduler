<?php
// problem 1
//echo "1";

assert(TRUE);

// problem 2
//echo "2";

function tddStringEquals($a,$b){
	if (!($a===$b)){
		return FALSE;
	}
	return TRUE;
}
assert(tddStringEquals("One","One"));

// problem 3
//echo "3";

function assertEquals($expected,$result){
	if ($expected!==$result){
		throw new Exception("Expected string does not match result");
	}
	return TRUE;
}

function assertNotEquals($expected, $result){
	if ($expected===$result){
		throw new Exception("Expected string matches result");
	}
	return TRUE;
}

assertEquals("One","One");
assertNotEquals("One","Two");


// To trigger Exceptions

//assertEquals("One","Two");
//assertNotEquals("One","One");


//problem 4
//echo "4";

try {
	assertEquals("One", "Two");
}
catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

try {
	assertNotEquals("One", "One");
}
catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

// problem 6a
//echo "6";

function assertContainsString($needle, $haystack){
	if(strpos($haystack, $needle)===FALSE){
		throw new Exception("assertContainsString: |$needle |$haystack");
	}
	return TRUE;
}

assertContainsString("one", "one two three");
//assertContainsString("zero", "one two three");

// problem 6b
function assertContains($needle, $hay){
	foreach ($hay as $h)
	if(strpos($h, $needle)===FALSE){
		throw new Exception("assertContains: |$needle |$hay");
	}
	return TRUE;
}

assertContains("needle", array("needle hay", "hay needle"));




?>