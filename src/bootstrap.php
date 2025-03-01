<?php

namespace ShuffleLunch;

require 'core/AutoLoader.php';

$loader = new AutoLoader();
$nameSpace = 'ShuffleLunch';
$loader->registerDir(__DIR__ . '/core');
$loader->registerDir(__DIR__ . '/controller');
$loader->registerDir(__DIR__ . '/models');
$loader->register();
