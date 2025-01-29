<?php

namespace ShuffleLunch;

require_once __DIR__ . "/lib/Pdo.php";

function validate(array $employeeName): array
{
  $errors = [];
  if (!mb_strlen($employeeName['name'])) {
    $errors['name'] = '社員名を入力してください';
  } elseif (mb_strlen($employeeName['name']) > 100) {
    $errors['name'] = '社員名は100文字以内で入力してください';
  }
  return $errors;
}

// メインルーチン
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $employeeName['name'] = $_POST['name'];
  $errors = validate($employeeName);
  if (!count($errors)) {
    $pdo = dbConnect();
    registeringEmployee($pdo, $employeeName);
    header("Location: RegisterEmployee.php");
  }
}

// 入力値にエラーがある場合は、社員登録画面にてエラー内容を表示させる
$title = 'シャッフルランチサービス';
$contents = __DIR__ . '/views/RegisterEmployee.php';
include 'views/Layout.php';
