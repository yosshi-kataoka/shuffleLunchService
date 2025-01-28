<?php

namespace ShuffleLunch;

use PDO;
use PDOException;

require_once(__DIR__ . '/lib/Pdo.php');
require_once(__DIR__ . '/lib/Escape.php');


const NUMBER_OF_DIVISION = 3;

function shuffleEmployeesRegister(array $employeesRegisters): array
{
  shuffle($employeesRegisters);
  $results = splitOfArray($employeesRegisters);
  return $results;
}

function splitOfArray($shuffleEmployeesRegisters): array
{
  $splitArray = array_chunk($shuffleEmployeesRegisters, NUMBER_OF_DIVISION);
  return $splitArray;
}

// メインルーチン
$pdo = dbConnect();
$employeesRegisters = getEmployeesRegister($pdo);
$shuffleEmployeesRegisters =  shuffleEmployeesRegister($employeesRegisters);
$title = 'シャッフルランチサービス';
$contents = __DIR__ . '/views/Top.php';
include __DIR__ . '/views/Layout.php';
