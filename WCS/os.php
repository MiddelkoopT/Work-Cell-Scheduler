<?php
// Optimization Services Copyright 2014 by WebIS Spring 2014 License Apache 2.0
namespace WebIS;

class OS {
	static $solver="\\WebIS\\bin\OSSolverService.exe";
	static $tmp="\\WebIS\\tmp\\"; // trailing slash required.
	private $osil=NULL;
	private $osrl=NULL;
	
	function __construct($maxOrMin='min') {
		$osil=new \SimpleXMLElement('<osil/>');
		$osil->addChild('instanceHeader')->addChild('name',php_uname('n').' '.date('c'));
		$data=$osil->addChild('instanceData');
		$data->addChild('objectives')->addChild('obj')->addAttribute('numberOfObjCoef',0);
		$data->objectives->obj['maxOrMin']=$maxOrMin;
		$data->addChild('constraints')->addAttribute('numberOfConstraints',0);
		//$constraints=$data->addChild('linearConstraintCoefficients');
		//$constraints->addAttribute('numberOfValues',0);
		//$constraints->addChild('start')->addChild('el');
		//$constraints->addChild('colIdx');
		//$constraints->addChild('value');
		//print_r($osil);
		$this->osil=$osil;
	}
	
	function solve(){
		$osilfile=tempnam(OS::$solver,'OS-');
		$osrlfile=tempnam(OS::$solver,'OS-');
		$this->osil->asXML($osilfile);
		exec(OS::$solver." -osil $osilfile -osrl $osrlfile",$output,$result);
		//print_r($output);
		if($result!==0){
			$message="solve: error $result\n".implode("\n",$output);
			throw new \Exception($message);
		}
		$xml=file_get_contents($osrlfile);
		if($xml==FALSE){
			return FALSE;
		}
		if(strpos($xml,'<generalStatus type="error">')!==FALSE){
			throw new \Exception("solve: error in OSrL:".$xml);
		}
		unlink($osilfile);
		unlink($osrlfile);
		$xml=preg_replace('/"os.optimizationservices.org"/','"http://os.optimizationservices.org"',$xml);
		//print_r($xml);
		$this->osrl=new \SimpleXMLElement($xml);
		//print_r($this->osrl->optimization);
		$result=(string)$this->osrl->optimization->solution->status->attributes()->type;
		if($result!=='optimal'){
			return FALSE;
		}
		return (double)$this->osrl->optimization->solution->objectives->values->obj;
	}
	
}

?>