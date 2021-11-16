<?php

require_once('./src/Generator.php');

use Glfromd\Generator;

$generator = new Generator('./database.sqlite');

$generator->run();
