<?php
echo "osbasics";

// problem 1
echo "1";

assert(TRUE);

// problem 2
echo "2";

function tddStringEquals($a,$b){
	if (!($a===$b)){
		return FALSE;
	}
	return TRUE;
}
assert(tddStringEquals("One","One"));

// problem 3
echo "3";

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
echo "4";

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


// problem 5

echo "5";

$xml = <<<XML
<?xml version="1.0"?>
<osil><instanceHeader></osil>
XML;


function osil(){
	$osil = new simpleXMLElement ("<osil/>");
	$osil -> addChild ('instanceHeader');
	return $osil -> asXML();

}
//assertEquals($xml,osil());


// problem 6a
echo "6";

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


// problem 7
echo "7";

exec("\\WebIS\\bin\\OSsolverservice.exe -h", $output, $result);
print_r($output);


assertEquals(0,$result);

// problem 8
echo "8";

function write($file){
	$osil = new simpleXMLElement ("<osil/>");
	$osil -> addChild ('instanceHeader');
	return $osil -> asXML($file);
}
write("test.xml");
//read file
$xml = file_get_contents("test.xml");
assertEquals($xml,osil());

// problem 9
echo "9";

function solve(){
	exec("\\WebIS\\bin\\OSsolverservice.exe -osil test.xml -osrl solution.xml", $output, $result);
	if($result !==0){
		throw new Exception("Solve function failed!\n".implode("\n",$output));
	}
	return TRUE;
}
$osil = new simpleXMLElement ('<osil/>');
$osil -> addChild("instanceHeader");
$osil -> addChild("instanceData") -> addChild ("objectives") -> addChild("obj") -> addAttribute("objCoeffiencts", 0);
$osil -> asXML('test.xml');
assert(solve());

//problem 10
echo "10";

function solution(){
	$xml = file_get_contents(asXML('solution.xml'));
	$osrl = new simpleXMLElement($xml);
	$result = (string)$osrl -> Optimization -> solution -> status -> attributes() -> type();
	$value = (double)$osrl -> Optimization -> solution -> objectives -> values -> obj;
	return $value;
}
echo "11";
 
?>