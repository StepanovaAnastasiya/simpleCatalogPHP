<?php
ini_set( "display_errors", true );
date_default_timezone_set( "Europe/Kiev" );
define( "DB_DSN", "mysql:host=localhost;dbname=catalog" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "" );
require( "classes/Article.php" );
?>
