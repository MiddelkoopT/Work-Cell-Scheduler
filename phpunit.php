<?php // Unit test entire project.
header("Content-type: text/plain");
require_once 'PHPUnit/Autoload.php';
foreach(array('TDD','Test','WCS','App') as $dir) {
	$command = new PHPUnit_TextUI_Command;
	$ret = $command->run(array('phpunit.php',$dir), FALSE);
	if($ret){
		echo "Test $dir failed";
		exit($ret);
	}
}
exit(0);
?>

