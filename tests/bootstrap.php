<?php
require 'tests/helpers.php';
require 'Universal/ClassLoader/SplClassLoader.php';
$loader = new \Universal\ClassLoader\SplClassLoader( array(  
    'UniversalCache' => 'src'
));
$loader->useIncludePath(true);
$loader->register();
