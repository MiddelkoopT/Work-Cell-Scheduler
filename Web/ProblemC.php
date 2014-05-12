<?php
//
require_once "Work-Cell-Scheduler/WCS/os.php";
///
Class Problemdata{

	private $supplierNum=3;
	private $departmentNum=3;

	//build the array: supplier,department,demand,capacity,profit


   function loadProblem($supplierNum,$departmentNum){

		$this->supplierNum=$supplierNum;
		$this->departmentNum=$departmentNum;

		$department= array();
		for($i=1;$i<=$departmentNum;$i++){
			$department[]="department-$i";
		}
		$this->department=$department;

		$supplier=array();
		for($i=1;$i<=$supplierNum;$i++){
			$supplier[]="supplier-$i";
		}
		$this->supplier=$supplier;
	  
		$capacity = array();
		foreach($supplier as $S){
			$capacity["$S"]=rand(300,600);
		}
		$this->capacity=$capacity;
	  
		$demand = array();
		foreach ($department as $D){
			$demand["$D"]=rand(200,500);
		}
		$this->demand=$demand;
	  
		$profit = array();
		foreach($department as $D){
			$profit["$D"]=rand(20,50);
		}
		$this->profit=$profit;


	}

// build the distance array

	function loadCost(){

		$distance=array();
		foreach ($this->supplier as $S){
			foreach ($this->department as $D){
				$distance["{$S}_{$D}"]= new Cost($S,$D,rand(2,8));
				 
			}
		}
		$this->distance=$distance;
	}
	 
// calculate the paralist = profit - distance
	 
	function Calculate(){
		$profit = $this->profit;
		$distance=$this->distance;
		$paralist=array();
		 
		foreach ($distance as $key => $d){
			$paralist[$key]=$profit[$d->department] - $d->distance;
		}
		$this->paralist=$paralist;
	}



}


Class Model{
	
	private $of = NULL;
	private $data = NULL;
	
	function __construct($data){
		$this->data=$data;
	}
	
	function Solve(){
		$paralist = $this->data->paralist;
		$OF = new WebIS\OS;
		foreach ($this->data->supplier as $S){
			foreach ($this->data->department as $D){
				$OF->addVariable("{$S}_{$D}");
				$OF->addObjCoef("{$S}_{$D}", $paralist["{$S}_{$D}"]);
			}
		}
		
		//add constrains
		foreach ($this->data->capacity as $key => $C){
			$OF->addConstraint(NULL,$C);
			foreach ($this->data->department as $D){
				$OF->addConstraintCoef("{$key}_{$D}",1);
	
			}
		}
	
		foreach ($this->data->demand as $key => $D){
			$OF->addConstraint($D,NULL);
			foreach ($this->data->supplier as $S){
				$OF->addConstraintCoef("{$S}_{$key}",1);
	
			}
		}
			
		$this->of=$OF;
		return $this->of->solve();
			
	}
	
	
   function displayProblem(){
		
      echo "<h3>Jianghong Li</h3>";
      echo "<h3>14149339</h3>";
      echo "<h3>Pawprint: jlrzf</h3>";
        
		$capacity=$this->data->capacity;
		echo "Supplier Capacity:\n";
		echo "<table border='1'>\n";
		foreach($this->data->supplier as $S){
			echo "<tr><th>$S</th>";
			echo "<td>$capacity[$S]</td>";
		}
		echo "</table>\n";
		echo "</br>";
	
		echo "Department Demand:\n";
		$demand=$this->data->demand;
		echo "<table border='1'>\n";
		foreach($this->data->department as $D){
		     echo "<tr><th>$D</th>";
		     echo"<td>$demand[$D]</td>";
	       }
		echo "</table>\n";
		echo "</br>";
	
		echo "Department Profit:\n";
		$profit=$this->data->profit;
		echo "<table border='1'>\n";
		foreach($this->data->department as $D){
		   echo "<tr><th>$D</th>";
		    echo"<td>$profit[$D]</td>";
				}
		echo "</table>\n";
		echo "</br>";
	
		echo "Distance:\n";
		$distance=$this->data->distance;
		echo "<table border='1'><tr><td>\n";
		foreach($this->data->supplier as $S){
				echo "<th>$S</th>";
					}
		foreach($this->data->department as $D){
				echo "<tr><th>$D</th>";
					foreach($this->data->supplier as $S){
								$var = $distance["{$S}_{$D}"]->distance;
								echo "<td>$var</td>";				 
								}
					}					
	echo "</table>\n";
	echo "</br>";
	
	}
	
	
	function displaySolution(){
	
		if(($this->of->getSolution()==NULL))
			echo "<h4>this total number of demand larger than capacity total, you cannot get the solution.Please change other numbers<h4>";
		else
		{echo "The solution:\n";
		print_r($this->of->getSolution());}
	
		echo "<table border='1'><tr><td>\n";
		foreach($this->data->supplier as $S){
			echo "<th>$S</th>";
		}
		foreach($this->data->department as $D){
		     echo "<tr><th>{$D}: ";
		     foreach($this->data->supplier as $S){
		          $var="${S}_${D}";
		          $var=$this->of->getVariable($var);
		          echo "<td>$var</td>";
	          }
	         echo "<tr>\n";
	      }
	
	echo "</table>";
	echo "</br>";
	
	echo "\n</body></html>\n";
	
	
	}

}


Class Cost{

	public $department = NULL;
    public $supplier = NULL;
	public $distance = NULL;

		function __construct($supplier,$department,$distance){
		     $this->department=$department;
		     $this->supplier=$supplier;
		     $this->distance=$distance;
		}

}


$test = new Problemdata();

$test->loadProblem(3,3);

$test->loadCost();

$test->Calculate();
		
$solution = new Model($test);

$solution->Solve();

$solution->displayProblem();

$solution->displaySolution();

?>
