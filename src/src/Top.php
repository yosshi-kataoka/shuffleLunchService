<?php

namespace ShuffleLunch;

require_once(__DIR__ . '/lib/Escape.php');

$shuffleEmployees = [];
$title = 'シャッフルランチサービス';
$contents = __DIR__ . '/views/Top.php';
include __DIR__ . '/views/Layout.php';
