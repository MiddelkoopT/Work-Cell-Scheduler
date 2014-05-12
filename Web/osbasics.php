<?php
// Problem 1
assert ( TRUE );
// assert(FALSE);

// Problem 2
function tddStringEquals($input, $expected) {
	return $input === $expected;
}

assert ( tddStringEquals ( "One", "One" ) );
// assert(tddStringEquals("One", "Two" ));

// Problem 3
function tddAssertStringEquals($input, $expected) {
	assert ( $input === $expected );
}

tddAssertStringEquals ( "One", "One" );
// tddAssertStringEquals("One","Two");

// Problem 4
function assertEquals($input, $expected) {
	if (! ($input === $expected)) {
		throw new Exception ( "assertEquals:|$input|$expected|\n" );
	}
}
$failed = FALSE;
try {
	assertEquals ( "One", "Two" );
} catch ( Exception $e ) {
	$failed = TRUE;
}
assert ( $failed );

assertEquals ( "One", "One" );

// Problem 5
$xml = <<<XML
<?xml version="1.0"?>
<osil/>

XML;
function osil() {
	$osil = new SimpleXMLElement( '<osil/>' );
	return $osil->asXML ();
}
assertEquals ( $xml, osil () );
	
// Problem 6a
function assertContainsString($needle, $haystack) {
	if (strpos ( $haystack, $needle ) === FALSE) {
		throw new Exception ( "No Needle in the Haystack" );
	}
}
$failed = FALSE;
try {
	assertContainsString ( "Needle", "There's nothing here, dork" );
} catch ( Exception $e ) {
	$failed = TRUE;
}
assert ( $failed );

assertContainsString('Needle','hay hay Needle hay');

//Problem 6b
function assertContains($needle, $haystack) {
	foreach ( $haystack as $hay ) {
		if (strpos ( $hay, $needle ) !== FALSE) {
			return TRUE;
		}
	}
	throw new Exception ( "assertContains: |$needle|" );
}
$failed = FALSE;
try {
	assertContains ( "Needle", array("nothing","try again","not happening") );
} catch ( Exception $e ) {
	$failed = TRUE;
}
assert ( $failed );

assertContains("Needle",array("Hay","More Hay","Hay with Needle Hay","Last Hay"));

//Problem 7
exec("\\WebIS\\bin\\OSSolverService.exe -h",$output,$result);
//assert($result!==0);
assert($result===0);
assertContains("OS Version: 2.",$output);
//print_r($output);
//print_r($result);

//Problem 8 + 10
function write($file){
	$osil = new SimpleXMLElement('<osil/>');
	$osil->addChild ( 'instanceHeader' );
	$osil->addChild ( 'instanceData' )->addChild ( 'objectives' )->addChild ( 'obj' )->addAttribute('numberOfObjCoef',0);
	return $osil->asXML ($file);
}

write('thing.xml');


//Problem 9
function solve($filename){
	exec("\\WebIS\\bin\\OSSolverService.exe -osil ${filename} -osrl solution.xml",$output,$result);
	if($result!==0){
		throw new Exception ( "Your problem sucks" );
	}
	return TRUE;
	
}
//solve();

//Problem 10 cont.

$xml=file_get_contents('thing.xml');
//print $xml;
solve('thing.xml');

//Problem 12   PROBLEM!!!!!!
function solution(){
	$xml=file_get_contents('solution.xml');
	$osrl = new SimpleXMLElement($xml);
	$result = (string)$osrl->optimization->solution->status->attributes()->type;
	echo "\n";
	if($result=="optimal"){
		echo "Solution is Optimal \n";
		return TRUE;
	}
	else{
		echo "Solution is NOT Optimal \n";
		return FALSE;
	}
	$value=(double)$osrl->optimization->solution->objectives->value->obj;
	return $value;
}

solution('thing.xml');

echo "\n";
echo "COMPLETE";
?>
