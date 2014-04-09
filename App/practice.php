<?php
//Problem 1
assert(TRUE);
//assert(FALSE);

//Problem 2
function tddStringEquals($expected,$result){

	return $expected===$result;

}

assert(tddStringEquals("one","one"));
//assert(tddStringEquals("one", "two"));

//Problem 3
function tddAssertStringEquals($expected,$result){

	assert($expected===$result);

}
tddAssertStringEquals("one", "one");
//tddAssertStringEquals("one", "two");

//Problem 3(refactor)

function assertEquals($expected,$result){

	if($expected===$result){
		throw new Exception ("assertEquals:|$expected|$result|\n");
	}

}

$fail=FALSE;

try{
	assertEquals("one","one");
	echo "they are not equal~~";
	 
}
catch(Exception $e){
	$fail=TRUE;
}
assert($fail);


function assertnotEquals($expected,$result){
	//do not remember the !();
	if(!($expected===$result)){
		throw new Exception ("assertnotEquals:|$expected|$result|\n");
	}

}
$fail=FALSE;
try{
	assertnotEquals("one","two");
	echo "they are equal~~";

}
catch(Exception $e){
	$fail=TRUE;
}
assert($fail);

//Problem 5??

$XML=<<<XML
 <? xml version="1.0"?>
<osil><instanceHeader/><osil/>
XML;
function osil(){

	$osil = new SimpleXMLElement('<osil/>');
	$osil->addChild('instanceHeader/');
	return $osil->asXML();

}


echo $XML."\n";
echo osil();
?>
