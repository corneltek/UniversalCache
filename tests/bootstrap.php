<?php
require 'PHPUnit/TestMore.php';
require 'Universal/ClassLoader/SplClassLoader.php';
$loader = new \Universal\ClassLoader\SplClassLoader( array(  
    'UniversalCache' => 'src'
));
$loader->useIncludePath(true);
$loader->register();
