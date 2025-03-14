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

  public function update($updateEmployee, $selectEmployeeId)
  {
    $this->execute('UPDATE list_employees SET id = ?, name = ? WHERE id = ?;', [$updateEmployee['updateEmployeeId'], $updateEmployee['updateEmployeeName'], $selectEmployeeId]);
  }

  public function delete($deleteEmployeeId)
  {
    $this->execute('DELETE FROM list_employees WHERE id = ?', [$deleteEmployeeId]);
  }
}
