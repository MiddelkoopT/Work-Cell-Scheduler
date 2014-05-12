<?php
// Model basics Copyright 2014 by WebIS Spring 2014 License Apache 2.0
echo "<html><title>problembasic.php</title><body>\n";
require_once 'Work-Cell-Scheduler/WCS/os.php';
require_once 'tdd.php';

// F: Refactor the "data" out of the class into a $data and $problem.

class SimpleProblemData {

	// E1
	private $workers=5;
	private $cells=4;
	private $products=6;
	
	// E1
	function loadProblem($workers,$cells,$products){
		$this->workers=$workers;
		$this->cells=$cells;
		$this->products=$products;
		
		$worker=array();
		for($i=0;$i<$workers;$i++){
			$worker[]="worker-${i}";
		}
		$this->worker=$worker;
		
		$cell=array();
		for($i=0;$i<$cells;$i++){
			$cell[]="cell-${i}";
		}
		$this->cell=$cell;
		
		$product=array();
		for($i=0;$i<$products;$i++){
			$product[]="product-${i}";
		}
		$this->product=$product;
	}
	
	// E2
	function loadDemand(){
		$demand=array();
		foreach($this->product as $p){
			$c=$this->cell[array_rand($this->cell)];
			$d=rand(1,3);
			$var="${p}_${c}";
			$demand[$var]=new Demand($p,$c,$d);
		}
		$this->demand=$demand;
	}
	
	// E3
	function loadTraining() {
		$training=new Training;
		for($i=0;$i<20;$i++){
			$training->set($this->worker[array_rand($this->worker)],$this->cell[array_rand($this->cell)],rand(70,100)/100.0);
		}
		$this->training=$training;
	}
	
	// E4
	function calculate() {
		$celltotal=array();
		foreach($this->cell as $c){
			$celltotal[$c]=0.0;
		}
		foreach($this->demand as $var=>$d){
			$celltotal[$d->cell]+=$d->hours;
		}
		$this->celltotal=$celltotal;
		
		$required=0.0;
		foreach($celltotal as $c=>$v){
			$required+=$v;
		}
		$this->required=$required;
	}

}


class ProblemModel {

	/**
	 * Solver
	 * @var \WebIS\OS
	 */
	private $os=NULL;
	private $data=NULL;
	
	// F
	function __construct($data){
		$this->data=$data;
	}
	
	// E5
	function displayWorkers() {
		$data=$this->data;
		$output=array();
		$solution='';
		if($this->os){
			$solution=$this->os->getSolution();
		}
		$output[]="<table border='1'><tr><td>$solution\n";
		foreach($data->cell as $c){
			$output[]="<th colspan='3'>$c</th>";
		}
		$output[]="<th>Total\n";
		$total=0.0;
		foreach($data->worker as $w){
			$output[]="<tr><th>${w}";
			$hours=0.0;
			foreach($data->cell as $c){
				$var="${w}_${c}";
				$t=$data->training->get($w,$c);
				if($this->os){
					$val=$this->os->getVariable($var);
					$hours+=$val;
					$total+=$val*$t;
				}else{
					$val='';
				}
				$output[]="<td>$val<td>$t<td>".$val*$t;
			}
			$output[]="<td>$hours</tr>";
		}
		$output[]="<tr><th>Total</th>";
		foreach($data->celltotal as $ct){
			$output[]="<td colspan='3'>$ct</td>";
		}
		$output[]="<td>$total</tr>";
		
		$output[]="\n</table>\n";
		return implode(" ",$output);
	}
	
	// E6
	function displayProblem() {
		$data=$this->data;
		$output=array();
		$output[]="<table border='1'><tr><td>\n";
		foreach($data->cell as $c){
			$output[]="<th colspan='1'>$c</th>";
		}
		$output[]="<th>Total\n";
		foreach($data->product as $p){
			$output[]="<tr><th>${p}";
			$total=0.0;
			foreach($data->cell as $c){
				$hours=0.0;
				$var="${p}_${c}";
				if(array_key_exists($var,$data->demand)){
					$d=$data->demand[$var];
					$hours=$d->hours;
				}
				$output[]="<td>$hours";
				$total+=$hours;
			}
			$output[]="<td>$hours</tr>";
		}
		$output[]="<tr><th>Total</th>";
		$total=0.0;
		foreach($data->celltotal as $ct){
			$output[]="<td colspan='1'>$ct</td>";
			$total+=$ct;
		}
		$output[]="<td>$total</tr>";
		
		$output[]="\n</table>\n";
		return implode(" ",$output);
	}
	
	// E7 Solve
	function solve(){
		$os=new \WebIS\OS;
		
		$worker=$this->data->worker;
		$cell=$this->data->cell;
		
		// Variables and objective function
		foreach($worker as $w){
			foreach($cell as $c){
				$var="${w}_${c}";
				$os->addVariable($var);
				$os->addObjCoef($var,1);
			}
		}
		
		// Production constraints (use effective hours for productivity)
		$celltotal=$this->data->celltotal;
		$training=$this->data->training;
		foreach($celltotal as $c=>$lb){
			$os->addConstraint($lb,NULL);
			foreach($worker as $w){
				$var="${w}_${c}";
				$val=$training->get($w,$c);
				if($val!==FALSE){
					$os->addConstraintCoef("${w}_${c}",$val);
				}
			}
		}
		// Maximum 8 hours per week.
		foreach($worker as $w){
			$os->addConstraint(NULL,8);
			foreach($cell as $c){
				$var="${w}_${c}";
				$val=$training->get($w,$c);
				if($val!==FALSE){
					$os->addConstraintCoef("${w}_${c}",1);
				}
			}
		}
		
		$this->os=$os;
		return $os->solve();
	}
	
}


class Demand {
	// E2
	public $product=NULL;
	public $cell=NULL;
	public $hours=NULL;
	
	// E2
	function __construct($product,$cell,$hours){
		$this->product=$product;
		$this->cell=$cell;
		$this->hours=$hours;
	}
}

class Training {
	// E3
	private $default=FALSE;
	private $matrix=array();
	
	// E3
	function set($worker,$cell,$productivity){
		$this->matrix["${worker}_${cell}"]=$productivity;
	}

	// E3
	function get($worker,$cell){
		if(array_key_exists("${worker}_${cell}",$this->matrix)){
			return $this->matrix["${worker}_${cell}"];
		}
		return $this->default;
	}
}


$d=new SimpleProblemData;
$d->loadProblem(5,4,6);

$d->loadDemand();
$d->loadTraining();
$d->calculate();

$m=new ProblemModel($d);
$m->solve();
echo $m->displayWorkers();
echo $m->displayProblem();

// G: Replace the generated $data with one supplied by a database $data.

echo "\n</body></html>\n";
?>