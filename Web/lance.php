<!DOCTYPE HTML>
<?php
	// lrmr47@mail.missouri.edu
	
	function view(){
		
		// Initial view
		if(!isset($_POST['submit'])){
			echo "<form id='simpleForm' action='lance.php' method='POST'>
						<label for='numberOfSuppliers'>How many Suppliers?</label>
						<input type='text' name='numberOfSuppliers'> <br>
						<label for='numberOfStores'>How many Stores?</label>
						<input type='text' name='numberOfStores'> <br>
						<input type='submit' name='submit' value='Submit'><br>
						<input type='reset' name='reset' value='Reset'><br>
					</form>";
		}
		
		// Submission from first page was received
		else if(isset($_POST['numberOfStores']) and isset($_POST['numberOfSuppliers'])){	
			echo "<form id='getCosts' action='lance.php' method='POST'> ";
			
			// Generate supplier fields
			for($i = 0; $i < $_POST['numberOfSuppliers']; $i++){
				echo " <label for='s[]'>Supply amount for supplier $i: </label>
						<input type='text' name='s[]'> <br>";
			}
			
			// Generate Store fields
			for($i = 0; $i < $_POST['numberOfStores']; $i++){
				echo " <label for='t[]'>Demand amount for store $i: </label>
						<input type='text' name='t[]'> <br>
						<label for='p[]'>Profit amount for store $i: </label>
						<input type='text' name='p[]'> <br>";
			}
			
			// Generate Cost fields
			for($i = 0; $i < $_POST['numberOfSuppliers']; $i++){
				for($j = 0; $j < $_POST['numberOfStores']; $j++){				
				echo " <label for=cost[]>Cost from supplier $i to store $j?</label>
						<input type='text' name='cost[]'> <br>";		
				}
			}
				echo "	<input type='hidden' name='hidNumberOfSuppliers' value={$_POST['numberOfSuppliers']}>
						<input type='hidden' name='hidNumberOfStores' value={$_POST['numberOfStores']}>
						<input type='submit' name='submit' value='Submit'><br>
						<input type='reset' name='reset' value='Reset'><br>
						</form>";
		}
		
		// Submission received from second page
		else if(isset($_POST['hidNumberOfStores']) and isset($_POST['hidNumberOfSuppliers'])){
			$sCount = 0;
			$tCount = 0;
			
			// Sets supplier array
			if(isset($_POST["s"])){
				foreach($_POST["s"] as $key => $value){
					$suppliers["s".$key] = $value;
					echo "suppliers[s$key" . "]:"."\t{$suppliers["s".$key]}<br>";
				}
			}
			
			// Sets Stores array
			if(isset($_POST["t"]) and isset($_POST["p"])){
				foreach($_POST["t"] as $key => $value){
					$stores["t".$key] = array($_POST["p"][$key], $value);
					echo "stores[t$key" . "]:"."\t{$stores["t".$key][0]}, {$stores["t".$key][1]}<br>";
				}
			}
			
			// Sets Cost array
			if(isset($_POST["cost"])){
				foreach($_POST["cost"] as $key => $value){
					$cost["s" . $sCount . "t" . $tCount] = $value;
					echo "cost[s$sCount" . "t$tCount" . "]:"."\t{$cost["s".$sCount."t".$tCount]}<br>";
					$tCount = ($tCount + 1) % $_POST['hidNumberOfStores'];
					if($tCount == 0)
						$sCount++;
				}
			}
			
			// Once all arrays have been created, we call the profit function
			sampleProfit($suppliers, $stores, $cost);
		}	

			// Something wasn't submitted right
		else{
			die("Something wasn't submitted");//header("Location:lance.php");
		}
	}
	function sampleProfit($suppliers, $stores, $cost){
	
	/* Cost array is the cost to get from the suppliers to the stores. 
		The "keys" are going to be concatenation of the supplier name
		and the store name
	*/
	/*	$cost = array(
					"s1t1" => 10,
					"s1t2" => 20,
					"s1t3" => 30,
					"s2t1" => 10,
					"s2t2" => 20,
					"s2t3" => 30,
					"s3t1" => 10,
					"s3t2" => 20,
					"s3t3" => 30
				);
	*/
		/* Supplier array; key => value as storeName => supplyQuantity */ 
	//	$suppliers = array("s1" => 50, "s2" => 60, "s3" =>70);
		
		/* Store array (two dimensional); key => value as storeName => [profitValue, demandQuantity] */
	//	$stores["t1"] = array(40,20);
	//	$stores["t2"] = array(40,30);
	//	$stores["t3"] = array(40,40);
		
		foreach( $suppliers as $key => $value){
			foreach( $stores as $k => $v){	// Note that $v is an array
				$newkey = "$key" . "$k"; // newkey is the concatenation of supplyName and storeName
				$profit[$newkey] = $v[0] - $cost[$newkey];
				echo "newkey = $newkey, profit = $profit[$newkey]<br>";
			}
		}
	}
	
	//sampleProfit();
				
	?>

<html>
<head>
<title> Test Interface </title>
</head>
<body>
	<?php	
		view();
	?>
</body>