<?php

namespace ShuffleLunch;

use PDO;
use PDOException;
use Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

function dbConnect(): PDO
{
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__  . '/../');
  $dotenv->load();

  try {
    $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] .  ';
    charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
  } catch (PDOException $e) {
    error_log('Error: fail to databaseAccess') . PHP_EOL;
    error_log($e->getMessage());
  }
}

// データベースより社員名と社員idを取得する処理
function getEmployeesRegister(PDO $pdo): array
{
  try {
    $statement = $pdo->prepare('SELECT id,name FROM list_employees');
    $statement->execute();
    $results = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $results[] = $row;
    }
    return $results;
  } catch (PDOException $e) {
    error_log('Error: fail to  get database information') . PHP_EOL;
    error_log($e->getMessage());
  }
}

//　入力フォームに入力した社員名をデータベースに登録する処理
function registeringEmployee(PDO $pdo, array $employeeName): void
{
  $pdo->beginTransaction();
  try {
    $statement = $pdo->prepare('INSERT INTO list_employees (name) values (:name)');
    $statement->bindValue(':name', $employeeName['name'], PDO::PARAM_STR);
    $statement->execute();
    $pdo->commit();
  } catch (PDOException $e) {
    error_log('Error: failed to register in the database') . PHP_EOL;
    error_log('Debugging Error:' . $e->getMessage());
    $pdo->rollBack();
  }
}
