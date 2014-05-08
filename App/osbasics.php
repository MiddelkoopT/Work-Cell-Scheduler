<?php

echo "osbasics\n";

//problem 1

assert(TRUE);

//problem 2

function tddStringEquals($expected,$result){
	if (!($expected===$result)){
		return FALSE;
	}
return TRUE;
}

assert(tddStringEquals("one","one"));


//assert(tddAssertStringEquals("one","two"));


//problem 3

function AssertEquals($expected,$result){
	if($expected!==$result){
		throw new Exception("Assert Equals failed");
	}
return TRUE;
}	
	
function AssertNotEquals($expected,$result){
	if($expected===$result){
		throw new Exception("Assert Not Equals Failed");
	}
	return TRUE;
}
	
AssertEquals("one","one");
//AssertEquals("one","two");

AssertNotEquals("one","two");
//AssertNotEquals("one","one");
	
//problem 4

$failed=FALSE;
try{
	AssertEquals("one","two");
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

$failed=FALSE;
try{
	AssertNotEquals("one","one");
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);
	
//problem 5

$xml=<<<XML
	<?xml version="1.0" ?>
	<osil><instanceHeader></osil>
XML;
		
function osil(){
	$osil=new SimpleXMLElement('<osil/>');
	$osil-> addChild('instanceHeader');
	return $osil-> asXML();
			
AssertEquals($xml,$osil);
}
	
//Problem 6a
	
function AssertContainsString($needle,$haystack){
	if (strpos($haystack,$needle)===FALSE){
		throw new Exception("AssertContainsString failed");
	}
}
AssertContainsString("needle","haystack needle");
//AssertContainsString("needle","nada");	

//AssertContainsString("needle","nada");
$failed=FALSE;
try{
	//AssertContainsString("needle","needle");
	AssertContainsString("needle","HAY");
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

//echo "passed\n";

//Problem 6b

function AssertContains($needle,$hay){
	foreach($hay as $h)
	if (strpos($h,$needle)!==FALSE){
		return TRUE;
	}	
	throw new Exception("AssertContains failed");
}
AssertContains("needle",array("needle hay","hay needle"));
//AssertContains("needle",array("hay hay","hay hay hay"));

$failed=FALSE;
try{
	AssertContains("needle",array("hay","hay no sharp objects"));
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

//Problem 7

exec("\\WebIS\\bin\\OSSolverService.exe -h",$output,$result);

AssertEquals(0,$result);

//print_r ($output);

$failed=FALSE;
try{
	AssertContains("OS Version X.Y.Z",$output);
	//AssertContains("OS Version: 2.",$output);
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

AssertContains("OS Version: 2.",$output);

//problem 8

function write($file){
	$osil=new SimpleXMLElement('<osil/>');
	$osil -> addchild('instanceHeader');
	return $osil-> asXML($file);
}

write('test.xml');
$xxml=file_get_contents('test.xml');

//print_r($xxml);
//print_r(osil());
AssertEquals($xxml,osil());


//Problem 9

function solve(){
	exec("\\WebIS\\bin\\OSSolverService.exe -osil test.xml -osrl solution.xml",$output,$result);
	if ($result!==0){
		throw new Exception("Solve function failed\n".implode("\n",$output));
	}
	return TRUE;
}

$osil=new SimpleXMLElement('<osil/>');
$osil -> addchild('instanceHeader');
$osil -> addChild('instanceData') -> addChild('objectives') -> addChild('obj') -> addAttribute('numberOfObjCoef',0);
$osil -> asXML('test.xml');

assert(solve());


//problem 10


function solution(){
	$xml=file_get_contents('solution.xml');
	//print_r($xml);
	$osrl=new simpleXMLElement($xml);
	//print_r($osrl);
	$result=(string)$osrl -> optimization->solution->status->attributes()->type();
	//print_r($result);
	$value=(double)$osrl->optimization->solution->objectives->values->obj;
	//print_r($value);
	return $value;
	//AssertEquals("optimal",$result);
	//problem 11
	//AssertContains("PARSER ERROR",$xml);
}
//solution();
//assertEquals(solution(),0);

//problem 12



echo "done";

?>