<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Ajax\GridApp\SquareGridBuilder;
use Ajax\GridApp\GridItemValidator;
use Ajax\GridApp\SquareGrid;

const GRID_SIZE = 3;

require '../vendor/autoload.php';

$configs = require '../configs/configs.php';
$grid = new SquareGrid(GRID_SIZE);
$validator = new GridItemValidator();
$builder = new SquareGridBuilder($grid, $validator);
$gridView = $builder->buildView($configs);

require ('../views/grid.html.php');
