<?php
// Problem 1 ^_^
assert ( TRUE );
// assert(FALSE);

// Problem 2
function tddStringEquals($expected, $result) {
	return $expected === $result;
}

assert(tddStringEquals("one","one"));
//assert(tddStringEquals("one", "two"));

//Problem 3
function tddAssertStringEquals($expected, $result) {
	assert ( $expected === $result );
}
tddAssertStringEquals("one", "one");
//tddAssertStringEquals("one", "two");

//Problem 3(refactor)

function assertEquals($expected,$result){

	if($expected!==$result){
		throw new Exception ("assertEquals:|$expected|$result\n");
	}

}

$fail=FALSE;

try{
	assertEquals("one","two");	 
}
catch(Exception $e){
	$fail=TRUE;
}
assert($fail);



//Problem 5??

$XML=<<<XML
<?xml version="1.0"?>
<osil><instanceHeader/></osil>

XML;
function osil(){

	$osil = new SimpleXMLElement('<osil/>');
	//do not need to add one more "/"
	$osil->addChild('instanceHeader');                                                                                                                       
	return $osil->asXML();

}


echo $XML."\n";
echo osil();
assertEquals($XML,osil());

//Problem 6

function assertContainsString($needle,$haystack){
	//in_array or foreach(strpos)
	
	if(in_array($haystack,$needle)===FALSE){
		
	    throw new Exception ("assertContainString:|$needle|$haystack");	
	}
	
}
$fail=FALSE;
try{assertContainsString(array('Needl','hay','hello'),"Needle");}
catch(Exception $e){
	$fail=TRUE;
}
assert($fail);

//Problem 7

exec("..\\..\\..\\bin\OSSolverService.exe -v",$output,$result);
//exec("..\\..\\..\\bin\OSSolverService.exe -h",$output,$result);
print_r($output);
print_r($result);

//Problem 8 
function writeXML($file){
	
		$osil = new SimpleXMLElement('<osil/>');
		//do not need to add one more "/"
		$osil->addChild('instanceHeader');
		$osil->asXML($file);
	
	
}
writeXML('test.xml');
$xml = file_get_contents("test.xml");
//echo $xml;

//Problem 9

function solve($file1,$file2){
	exec("..\\..\\..\bin\OSSolverService.exe -osil $file1 -osrl $file2",$output,$result);
	if($result==1){
		throw new Exception("solve:\n".implode("\n",$output));
	}
	return TRUE;
	
}

//Problem 10
//format ctrl+shift+f

$osil = new SimpleXMLElement('<osil/>');
$osil->addChild('instanceHeader');
$osil->addChild('instanceData')->addChild('objectives')->addChild('obj')->addAttribute('numberOfObjCoef',0);
$osil->asXML('test1.xml');
//solve();




//Problem 12
function solution($file){
	$xml = file_get_contents("$file");
    
	$osrl = new SimpleXMLElement($xml);
	print_r($osrl);
	$result = (String) $osrl->optimization->solution->status->attributes()->type;
	if($result!=="optimal"){
		
		return FALSE;		
	}
	$value = (double)$osrl->optimization->solution->objectives->values->obj;
	return $value;
	
	
}

//Problem assignment
$XML=<<<XML
<?xml version="1.0"?>
<osil><instanceHeader/>
  <instanceData>
		<variables numberOfVariables="2">
		     <var name="x" />
		     <var name="y" />
	    </variables>
        <objectives>
		     <obj maxOrMin="min" numberOfObjCoef="2">
		         <coef idx="0">-1</coef>
		         <coef idx="1">-2</coef>
		     </obj>
		</objectives>
		<constraints numberOfConstraints="2">
		     <con ub="40" />
		     <con ub="60" />
		</constraints>
		<linearConstraintCoefficients numberOfValues="4">
		     <start>
		        <el>0</el>
		        <el>2</el>
		        <el>4</el>
		     </start>
		     <colIdx>
		         <el>0</el><el>1</el>
		         <el>0</el><el>1</el>
		     </colIdx>
		     <value>
		         <el>1</el><el>1</el>
		         <el>2</el><el>1</el>
		     </value>
		</linearConstraintCoefficients>
	</instanceData>
</osil>

XML;
$osil = new SimpleXMLElement($XML);
$osil->asXML('assign.xml');
solve("assign.xml","solution2.xml");
assertEquals(-80.0,solution("solution2.xml"));
echo "optimal solution :".solution("solution2.xml")."\n";


echo "done";

?>
