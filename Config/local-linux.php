<?php
// Local Linux Configuration Copyright 2014 by WebIS Spring 2014 License Apache 2.0
if(class_exists('WebIS\Validator')){
	WebIS\Validator::$web="http://localhost/";
	WebIS\Validator::$tidy="/var/www/Work-Cell-Scheduler/bin/tidy";
}
if(class_exists('WebIS\OS')){
	WebIS\OS::$solver="/var/www/Work-Cell-Scheduler/bin/OSSolverService";
	// OS temporary directory. Should have 775 permissions and owned by the webserver group (www-data)
	WebIS\OS::$tmp="/var/www/Work-Cell-Scheduler/tmp/"; // trailing slash required
	
}
