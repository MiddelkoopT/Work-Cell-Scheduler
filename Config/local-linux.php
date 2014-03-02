<?php
// Local Linux Configuration Copyright 2014 by WebIS Spring 2014 License Apache 2.0
if(class_exists('WebIS\Validator')){
	WebIS\Validator::$web="http://localhost/";
	WebIS\Validator::$tidy="/var/www/Work-Cell-Scheduler/bin/tidy";
}
if(class_exists('WebIS\OS')){
	WebIS\OS::$solver="/var/www/Work-Cell-Scheduler/bin/OSSolverService";
}
