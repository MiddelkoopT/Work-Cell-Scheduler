<?php
echo "OSBasics\n";

// Problem 1:

assert(TRUE);
//assert(FALSE);

// Problem 2

function tddStringEquals($expected,$result){
	return $expected===$result;
}

assert(tddStringEquals("One","One"));
//assert(tddStringEquals("One","Two"));

function tddAssertStringEquals($expected,$result){
	assert($expected===$result);
}

tddAssertStringEquals("One","One");
//tddAssertStringEquals("One","Two");

function assertEquals($expected,$result){
	if(!($expected===$result)){
		throw new Exception("assertEquals: |$expected|$result|\n");
	}
}

assertEquals("One","One");

$failed=FALSE;
try {
	assertEquals("One","Two");
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

// TDD is now usable.


$xml=<<<XML
<?xml version="1.0"?>
<osil><instanceHeader/></osil>

XML;

function osil() {
	$osil=new SimpleXMLElement('<osil/>');
	$osil->addChild('instanceHeader');
	return $osil->asXML();
}

assertEquals($xml,osil());


// Problem 6:


function assertContainsString($needle,$haystack){
	if(strpos($haystack,$needle)===FALSE){
		throw new Exception("assertContainsString: |$needle|$haystack");
	}
}

assertContainsString('Needle','Haystack Needle Hay Hay');
$failed=FALSE;
try {
	assertContainsString("Needle","Nada");
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);




echo "Done.";
?>
