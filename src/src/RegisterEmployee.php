<?php

namespace ShuffleLunch;

require_once(__DIR__ . '/lib/Escape.php');
require_once(__DIR__ . '/lib/Pdo.php');

$employeeName = [
  'name' => '',
];
$errors = [];
$title = 'シャッフルランチサービス';
$contents = __DIR__ . '/views/RegisterEmployee.php';
include __DIR__ . '/views/Layout.php';
