<?php
function assertEquals($expected,$result) {
	if(!($expected===$result)){
		$message="assertEquasl: |$expected|$result|\n";
		throw new Exception($message);
	}
}

function assertNotEquals($expected,$result) {
	if(($expected===$result)){
		$message="assertNoeEquasl: |$expected|$result|\n";
		throw new Exception($message);
	}
}

function assertContains($needle, $haystack) {
	foreach ( $haystack as $hay ) {
		if (strpos ( $hay, $needle ) !== FALSE) {
			return TRUE;
		}
	}
	throw new Exception ( "assertContains: |$needle|" );
}
$failed = FALSE;
try {
	assertContains ( "Needle", array (
	"nothing",
	"try again",
	"not happening"
			) );
} catch ( Exception $e ) {
	$failed = TRUE;
}

function ContainsString($needle, $haystack) {
	if (strpos ( $haystack, $needle ) === FALSE) {
		return FALSE;
	}
	return TRUE;
}
/**if(ContainsString("toot", "poop poop tfdf poop")==TRUE){
	echo "success";
}
else{
	echo "failure";
}
echo "\nDone";
*/
?>