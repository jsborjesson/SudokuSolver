<?php

// Start autoloading
require_once('./vendor/autoload.php');

// Set template dir
SudokuSolver\View\Template::setTemplateDirectory('public/templates/');

// Allow deeper recursion
ini_set('xdebug.max_nesting_level', 200);

// Don't allow slow execution times
set_time_limit(5); // TODO: Show nice error when this is hit

// Stop on error
assert_options(ASSERT_BAIL, true);
