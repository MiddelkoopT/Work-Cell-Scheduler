<!DOCTYPE HTML>
<?php
	
	function sampleProfit(){
	
	/* Cost array is the cost to get from the suppliers to the stores. 
		The "keys" are going to be concatenation of the supplier name
		and the store name
	*/
		$cost = array(
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
				
	// Printing array locations and their values:
	foreach($cost as $key => $value){
		echo "cost[$key]:\t$value<br>";
	}
	echo "<br><br>";
	
	
	/* Supplier array; key => value as storeName => supplyQuantity */ 
	$suppliers = array("s1" => 50, "s2" => 60, "s3" =>70);
	
	// Printing array loctions and their values:
	foreach($suppliers as $key => $value){
		echo "suppliers[$key]:\t$value<br>";
	}
	echo "<br><br>";
		/* Store array (two dimensional); key => value as storeName => [profitValue, demandQuantity] */
		$stores["t1"] = array(40,20);
		$stores["t2"] = array(40,30);
		$stores["t3"] = array(40,40);
		
	// Printing array locations and their values (which are also arrays):
	foreach($stores as $storeKey => $storeValue){
		echo "stores[$storeKey]:\t . {";
		foreach($storeValue as $valueValue){
			echo "$valueValue  ";
		}
		echo "}<br>";
	}
	
	echo "<br><br>";
		
		foreach( $suppliers as $key => $value){
			foreach( $stores as $k => $v){	// Note that $v is an array
				$newkey = "$key" . "$k"; // newkey is the concatenation of supplyName and storeName
				$profit[$newkey] = $v[0] - $cost[$newkey];
				echo "newkey = $newkey, profit = $profit[$newkey]<br>";
			}
		}
	}
	sampleProfit();		
	?>