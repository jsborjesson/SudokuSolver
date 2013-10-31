<?php
// Setup
require_once('config.php');
use SudokuSolver\Controller\App;

// Start!
$app = new App();
$app->run();
