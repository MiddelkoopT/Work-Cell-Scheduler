<?php // Unit test entire project.
require_once 'PHPUnit/Autoload.php';
foreach(array('../Test','../TDD','../App') as $dir) {
	$command = new PHPUnit_TextUI_Command;
	$ret = $command->run(array('phpunit.php',$dir), FALSE);
	if($ret){
		echo "Test $dir failed";
		exit($ret);
	}
}
exit(0);
?>

