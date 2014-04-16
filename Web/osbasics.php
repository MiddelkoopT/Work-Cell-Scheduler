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

// Problem 7:

function assertContains($needle,$haystack){
	foreach($haystack as $hay){
		if(strpos($hay,$needle)!==FALSE){
			return TRUE;
		}
	}
	throw new Exception("assertContains: |$needle|");
}

$failed=FALSE;
try {
	assertContains("Needle",array("Nada"));
} catch (Exception $e){
	$failed=TRUE;
}
assert($failed);

assertContains("needle",array('hay','hay needle','hay'));

exec("\\WebIS\\bin\\OSSolverService.exe -h",$output,$result);
//print_r($output);

assertEquals(0,$result);
assertContains("OS Version: 2",$output);

// Problem 8:

function write($file) {
	$osil=new SimpleXMLElement('<osil/>');
	$osil->addChild('instanceHeader');
	return $osil->asXML($file);
}

write("test.xml");
$xml=file_get_contents("test.xml");
assertEquals($xml,osil());

// Problem 9:

function solve(){
	exec("\\WebIS\\bin\\OSSolverService.exe -osil test.xml -osrl solution.xml",$output,$result);
	if($result!==0){
		throw new Exception("solve:\n".implode("\n",$output));
	}
	return TRUE;
}

solve();

// Problem 10:

$osil=new SimpleXMLElement('<osil/>');
$osil->addChild('instanceHeader');
$osil->addChild('instanceData')->addChild('objectives')->addChild('obj')->addAttribute('numberOfObjCoef',0);
//print_r($osil);
$osil->asXML('test.xml');

assert(solve());

// Problem 11:

function solution(){
	$xml=file_get_contents('solution.xml');
	$xml=preg_replace('/"os.optimizationservices.org"/','"http://os.optimizationservices.org"',$xml);
	$osrl=new SimpleXMLElement($xml);
	//print_r($osrl);
	$result=(string)$osrl->optimization->solution->status->attributes()->type;
	if($result!=="optimal"){
		return FALSE;
	}
	$value=(double)$osrl->optimization->solution->objectives->values->obj;
	return $value;
}

solve();
assertEquals(0.0,solution());


echo "Done.";
?>
