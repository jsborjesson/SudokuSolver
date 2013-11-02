<?php

// Start autoloading
require_once('./vendor/autoload.php');

// Set template options
define('TEMPLATE_DIR', 'public/templates/');
define('TEMPLATE_SUFFIX', 'Tpl.html');

// Allow deeper recursion
ini_set('xdebug.max_nesting_level', 200);

// Don't allow slow execution times
set_time_limit(5); // TODO: Show nice error when this is hit

// Stop on error
assert_options(ASSERT_BAIL, true);

// Needed to "catch" the fatal execution time error
error_reporting(0);
