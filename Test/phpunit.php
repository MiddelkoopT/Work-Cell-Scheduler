<?php // Unit test entire project.
require_once 'PHPUnit/Autoload.php';
$command = new PHPUnit_TextUI_Command;
return $command->run(array('phpunit.php','../'), TRUE);
?>

