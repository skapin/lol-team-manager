<?php


$path=".:../../../sources/php";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
$path=".:../../sources/php";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
$path=".:./sources/php";
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

$GLOBALS['debug'] = true;
function __autoload( $class_name ) {
    if ( file_exists('Web/' . $class_name . '.php' ) ) {
        require 'Web/' .$class_name . '.php';
    }
    elseif ( file_exists( $class_name . '.php' ) ) {
        require $class_name . '.php';
    }

}

require("Web/Bdd.php");
require("Web/basics.php");
require("Globals/global_sgbd.php");


require("config.php");
require("API.php");
require("auth.php");


?>