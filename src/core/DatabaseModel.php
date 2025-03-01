<?php

namespace ShuffleLunch;

use PDOException;

abstract class DatabaseModel
{
  protected $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function fetchAll($sql)
  {
    $statement = $this->pdo->prepare($sql);
    $statement->execute();
    $results = [];
    while ($row = $statement->fetch($this->pdo::FETCH_ASSOC)) {
      $results[] = $row;
    }
    return $results;
  }

  public function execute($sql, $params = [])
  {
    $this->pdo->beginTransaction();
    try {
      $statement = $this->pdo->prepare($sql);
      if ($params) {
        foreach ($params as $index => $value) {
          $statement->bindValue($index + 1, $value);
        }
      }
      $statement->execute();
      $this->pdo->commit();
    } catch (PDOException $e) {
      error_log('Error: failed to register in the database') . PHP_EOL;
      error_log('Debugging Error:' . $e->getMessage());
      $this->pdo->rollBack();
    }
  }
}
