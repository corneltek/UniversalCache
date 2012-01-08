<?php
require 'tests/helpers.php';
require 'Universal/ClassLoader/SplClassLoader.php';
$loader = new \Universal\ClassLoader\SplClassLoader( array(  
    'CacheKit' => 'src'
));
$loader->useIncludePath(true);
$loader->register();
