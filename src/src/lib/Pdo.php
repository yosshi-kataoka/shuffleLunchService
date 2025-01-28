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
    $pdo = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] .  '; charset=utf8mb4', $_ENV['DB_USER'],  $_ENV['DB_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
  } catch (PDOException $e) {
    error_log('Error: fail to databaseAccess') . PHP_EOL;
    error_log($e->getMessage());
  }
}

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
