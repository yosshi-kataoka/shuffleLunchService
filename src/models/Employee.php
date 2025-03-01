<?php

namespace ShuffleLunch;

class Employee extends DatabaseModel
{
  public function fetchAllNames()
  {
    return  $this->fetchAll('SELECT id,name FROM list_employees');
  }

  public function insert($name)
  {
    $this->execute('INSERT INTO list_employees (name) VALUES(?)', [$name]);
  }
}
