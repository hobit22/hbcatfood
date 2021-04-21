<?php
include "vendor/autoload.php";
function exception_error_handler($errno, $errstr, $errfile, $errline ) { 
     throw new ErrorException($errstr, $errno, 0, $errfile, $errline); 
 } 
set_error_handler("exception_error_handler"); 

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
