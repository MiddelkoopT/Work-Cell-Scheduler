<?php
// Optimization Services Copyright 2014 by Timothy Middelkoop Spring 2014 License Apache 2.0
namespace WebIS;

class OS {
	static $DEBUG=FALSE;
	static $solver="\\WebIS\\bin\OSSolverService.exe";
	static $tmp="\\WebIS\\tmp\\"; // trailing slash required.
	private $linear=FALSE;
	
	private $osil=NULL;
	private $osrl=NULL;
	private $var=array(); // Reverse IDX mapping ($idx->$name).
	private $value=NULL;  // Solution value.
	private $solution=NULL;

	
	function __construct($maxOrMin='min') {
		$osil=new \SimpleXMLElement('<osil/>');
		$osil->addChild('instanceHeader')->addChild('name',php_uname('n').' '.date('c'));
		$data=$osil->addChild('instanceData');
		$data->addChild('variables')->addAttribute('numberOfVariables',0);
		$data->addChild('objectives')->addChild('obj')->addAttribute('numberOfObjCoef',0);
		$data->objectives->obj['maxOrMin']=$maxOrMin;
		$data->addChild('constraints')->addAttribute('numberOfConstraints',0);
		//print_r($osil);
		$this->osil=$osil;
	}
	
	function addLinearConstraints() {
		$constraints=$this->osil->instanceData->addChild('linearConstraintCoefficients');
		$constraints->addAttribute('numberOfValues',0);
		$constraints->addChild('start')->addChild('el',0);
		$constraints->addChild('colIdx');
		$constraints->addChild('value');
		$this->linear=TRUE;
	}
	
	function getName(){
		if(is_null($this->osrl)){
			return FALSE;
		}
		return (string)$this->osrl->general->instanceName;
	}
	
	function addVariable($name,$type=NULL){
		$variables=$this->osil->instanceData->variables; // shortcut
		$this->var[$name]=$variables->var->count(); // $name to $idx (zero based -- preinsert)
		$var=$variables->addChild('var');
		$var['name']=$name;  // assign name attribute to var tag
		if(isset($type)){
			$var['type']=$type;
		}
		$variables['numberOfVariables']=$variables->var->count(); // update variables tag
	}
	
	function getVariable($name){
		if(is_null($this->value)){
			return FALSE; // no solutions
		}
		return $this->value[$name];
	}
	
	function getOsil(){
		return $this->osil->asXML();
	}

	function addObjCoef($name,$value){
		$idx=$this->var[$name]; // find $idx from variable $name
		$obj=$this->osil->instanceData->objectives->obj;
		$coef=$obj->addChild('coef',$value);
		$coef['idx']=$idx;
		$obj['numberOfObjCoef']=$obj->coef->count();
	}

	function addConstraint($lb,$ub){
		$constraints=$this->osil->instanceData->constraints;
		$con=$constraints->addChild('con');
		if(!is_null($lb)){
			$con['lb']=$lb;
		}
		if(!is_null($ub)){
			$con['ub']=$ub;
		}
		$constraints['numberOfConstraints']=$constraints->con->count();

		// Setup linear constraints, move if to support other constraints.
		if(!$this->linear){
			$this->addLinearConstraints();
		}
		
		$lcc=$this->osil->instanceData->linearConstraintCoefficients;
		$lcc->start->el[]=$lcc->value->el->count();
	}
	
	function addConstraintCoef($name,$value){
		$lcc=$this->osil->instanceData->linearConstraintCoefficients;
		$lcc->colIdx->addChild('el',$this->var[$name]);
		$lcc->value->addChild('el',$value);
		// Update count and start
		$count=$lcc->value->el->count();
		$lcc['numberOfValues']=$count;
		// Update the last start element to match value index.
 		$lcc->start->el[$lcc->start->el->count()-1]=$count;
	}
	
	function solve(){
		$osilfile=tempnam(OS::$tmp,'OS-');
		$osrlfile=tempnam(OS::$tmp,'OS-');
		if(self::$DEBUG){
			$osilfile='osil.xml';
			$osrlfile='osrl.xml';
		}
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
			throw new \Exception("solve: error in OSrL($osilfile,$osrlfile):\n".$xml);
		}
		if(!self::$DEBUG){
			unlink($osilfile);
			unlink($osrlfile);
		}
		// Fix for strict parser used by PHP.
		$xml=preg_replace('/"os.optimizationservices.org"/','"http://os.optimizationservices.org"',$xml);
		//print_r($xml);
		$this->osrl=new \SimpleXMLElement($xml);
		$result=(string)$this->osrl->optimization->solution->status->attributes()->type;
		if($result!=='optimal'){
			$this->solution=NULL;
			return $result;
		}

		// save values to array
		$this->value=array();
		$solution=$this->osrl->optimization->solution;
		$variables=$this->osil->instanceData->variables;
		foreach($solution->variables->values->var as $var){
			$this->value[(string)$variables->var[(integer)$var['idx']]['name']]=(float)$var;
			if(self::$DEBUG) print $var['idx'].": ";
			if(self::$DEBUG) print (float)$var."\n";
		}

		$this->solution=(double)$this->osrl->optimization->solution->objectives->values->obj;
		return TRUE;
	}
	
	function getSolution(){
		return $this->solution;
	}
	
}

?>