<?php // Unit test entire project.
header("Content-type: text/plain");
require_once 'PHPUnit/Autoload.php';
echo "Work-Cell-Scheduler TDD\n";
$tests=array('TDD','Test','WCS','App');
$passed=0;
foreach($tests as $dir) {
	$command = new PHPUnit_TextUI_Command;
	$ret = $command->run(array('phpunit.php',$dir), FALSE);
	if($ret){
		echo "Test $dir failed";
		exit($ret);
	}else{
		$passed+=1;
	}
}
echo "\nWork-Cell-Scheduler TDD $passed of ",sizeof($tests)," tests passed.\n";
exit(sizeof($tests)-$passed);
?>

