<?php

function tddStringEquals($input, $expected) {
	return $input === $expected;
}

assert ( tddStringEquals ( "One", "One" ) );

function tddAssertStringEquals($input, $expected) {
	assert ( $input === $expected );
}

tddAssertStringEquals ( "One", "One" );

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


$xml = <<<XML
<?xml version="1.0"?>
<osil/>

XML;
function osil() {
	$osil = new SimpleXMLElement( '<osil/>' );
	return $osil->asXML ();
}
assertEquals ( $xml, osil () );
	

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
exec("\\WebIS\\bin\\OSSolverService.exe -h",$output,$result);
assert($result===0);
assertContains("OS Version: 2.",$output);


function write($file){
	$a = new SimpleXMLElement('<osil/>');
	$a->addChild ( 'instanceHeader' );
	$b=$a->addChild ( 'instanceData' );
	$c=$b->addChild ( 'variables' );
	$c->addAttribute('numberOfVariables','2');
	$c->addChild ( 'var' )->addAttribute('name','x');
	$c->addChild ( 'var' )->addAttribute('name','y');
	$d=$b->addChild ( 'objectives' );
	$e=$d->addChild ( 'obj' );
	$e->addAttribute('maxOrMin','min');
	$e->addAttribute('numberOfObjCoef',"2");
	$e->addChild ( 'coef',-1 )->addAttribute('idx',"0");
	$e->addChild ( 'coef',-2 )->addAttribute('idx',"1");
	$f=$b->addChild('constraints');
	$f->addAttribute('numberOfConstraints',"2");
	$f->addChild('con')->addAttribute('ub',"40");
	$f->addChild('con')->addAttribute('ub',"60");
	$g=$b->addChild('linearConstraintCoefficients');
	$g->addAttribute('numberOfValues',"4");
	$h=$g->addChild('start');
	$h->addChild('el',0);
	$h->addChild('el',2);
	$h->addChild('el',4);
	$i=$g->addChild('colIdx');
	$i->addChild('el',0);
	$i->addChild('el',1);
	$i->addChild('el',0);
	$i->addChild('el',1);
	$j=$g->addChild('value');
	$j->addChild('el',1);
	$j->addChild('el',1);
	$j->addChild('el',2);
	$j->addChild('el',1);
	
	print_r($a);
	return $a->asXML ($file);
}

write('thing.xml');


function solve($filename){
	$xml=file_get_contents("${filename}");
	exec("\\WebIS\\bin\\OSSolverService.exe -osil ${filename} -osrl solution.xml",$output,$result);
	if($result!==0){
		throw new Exception ( "Your problem sucks" );
	}
	return TRUE;
	
}


solve('thing.xml');

//$value is wrong!!!!!!!
function solution(){
	$xml=file_get_contents('solution.xml');
	$osrl = new SimpleXMLElement($xml);
	$result = (string)$osrl->optimization->solution->status->attributes()->type;
	echo "\n";
	if($result=="optimal"){
		$value=(double)$osrl->optimization->solution->objectives->values->obj;
		echo "Solution is Optimal and = $value \n";
		return TRUE;
	}
	else{
		echo "Solution is NOT Optimal \n";
		return FALSE;
	}
}

solution('thing.xml');




echo "\n";
echo "COMPLETE";
?>