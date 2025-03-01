<?php

namespace ShuffleLunch;

use PDO;
use PDOException;

require __DIR__ . '../../controller/ShuffleController.php';
class DatabaseManager
{
  protected $models;
  protected $pdo;

  public function connect($params)
  {
    try {
      $pdo = new PDO('mysql:host=' . $params['hostname'] . ';dbname=' . $params['database'] .  ';
    charset=utf8mb4', $params['username'], $params['password']);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $this->pdo = $pdo;
    } catch (PDOException $e) {
      error_log('Error: fail to databaseAccess') . PHP_EOL;
      error_log($e->getMessage());
    }
  }

  public function get(string $modelName)
  {
    $modelName = 'ShuffleLunch\\' . $modelName;
    if (!isset($this->models[$modelName])) {
      $model = new $modelName($this->pdo);
      $this->models[$modelName] = $model;
    }
    return $this->models[$modelName];
  }
}
