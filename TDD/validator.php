<?php 
// WebIS validator Copyright 2014 by Timothy Middelkoop License Apache 2.0
// Project version
namespace WebIS;

require_once 'PHPUnit/Autoload.php';
require_once 'HTTP/Request2.php';

if(!defined('STDERR')){
    define('STDERR',fopen('php://stderr','w'));
}

abstract class Validator extends \PHPUnit_Framework_TestCase {

	static $tidy="\\WebIS\\bin\\tidy.exe";
	static $tidyoptions="-errors -quiet -utf8";
	static $workspace="/WebIS/workspace";
	static $web="http://localhost:8000";
	
	protected function setUp() {
		if(!isset($this->project)){
			$this->project='/Work-Cell-Scheduler';
		}
		parent::setUp();
	}

	/**
	 * PHPUnit test validation of a page, returns rendered page.
	 * @param string $file to be validated
	 * @param string $contains simple verfication that page loaded
	 * @param array $variables to pass via GET
	 * @param string $message to display on failure
	 * @return string the entire doc for additional processing
	 */
	public function assertValidHTML($file,$contains='</html>',$variables=array(),$message=''){
		# parent declared variables
		$web=self::$web;
		$tidy=self::$tidy;
		$tidyoptions=self::$tidyoptions;
		
		## Get document
		$url="$web/$this->project/$file";
		$request=new \HTTP_Request2($url, \HTTP_Request2::METHOD_GET);
		$request->getURL()->setQueryVariables($variables);
		$doc=$request->send()->getBody();

		## Verify server is running and content exists fist
		$this->assertContains($contains,$doc,$url,$message);
		
		## Call validator

		# open
		$fdspec = array(
				0 => array("pipe", "r"), // stdin
				1 => array("pipe", "w"), // stdout
				2 => array("pipe", "w")  // stderr
		);
		$proc = proc_open("$tidy $tidyoptions",$fdspec,$fd);

		# write write document
		fwrite($fd[0],$doc);
		fclose($fd[0]); # finsh write before read.
		
		# read result
		fwrite(STDERR,stream_get_contents($fd[1]));
		fclose($fd[1]);				
		fwrite(STDERR,stream_get_contents($fd[2]));
		fclose($fd[2]);
		
		# close
		$return = proc_close($proc);
		
		# report
		$this->assertEquals(0,$return,$message);
		
		return $doc; // return doc for further processing
	}

	protected function tearDown() {
		parent::tearDown();
	}

	// Static loader, must be called from subclass (see Test/TDD/validatorTest.php for example)
	static function main() {
		## Subclass must declare 'protected static $__CLASS__'
		$suite = new \PHPUnit_Framework_TestSuite(static::$__CLASS__);
		$parameters=array('verbose'=>TRUE);
		\PHPUnit_TextUI_TestRunner::run($suite,$parameters);
	}
	
}

?>
