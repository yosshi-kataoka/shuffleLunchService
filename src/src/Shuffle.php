<?php

namespace ShuffleLunch;

use PDO;
use PDOException;

require_once(__DIR__ . '/lib/Pdo.php');
require_once(__DIR__ . '/lib/Escape.php');


const NUMBER_OF_THREE_DIVISION = 3;
const NUMBER_OF_TWO_DIVISION = 2;

function shuffleEmployeesRegister(array $employeesRegisters): array
{
  shuffle($employeesRegisters);
  $results = splitOfArray($employeesRegisters);
  return $results;
}

function splitOfArray(array $employeesRegisters): array
{
  $cnt = count($employeesRegisters);
  if ($cnt % 3 === 0) {
    $splitArray = array_chunk($employeesRegisters, NUMBER_OF_THREE_DIVISION);
  } elseif ($cnt % 2 === 0) {
    $splitArray = array_chunk($employeesRegisters, NUMBER_OF_TWO_DIVISION);
  } else {
    $extra = array_pop($employeesRegisters);
    $splitArray = array_chunk($employeesRegisters, NUMBER_OF_TWO_DIVISION);
    array_push($splitArray[0], $extra);
  }
  return $splitArray;
}

// メインルーチン
$pdo = dbConnect();
$employeesRegisters = getEmployeesRegister($pdo);
$shuffleEmployees =  shuffleEmployeesRegister($employeesRegisters);
$title = 'シャッフルランチサービス';
$contents = __DIR__ . '/views/Top.php';
include __DIR__ . '/views/Layout.php';
