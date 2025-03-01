<?php

namespace ShuffleLunch;

use HttpNotFoundException;

class EmployeeController extends Controller
{
  public function index()
  {
    $employeeRegisters = $this->databaseManager->get('Employee')->fetchAllNames();

    return $this->render(
      [
        'title' => '社員の登録',
        'errors' => [],
        'employeeRegisters' => $employeeRegisters,
      ]
    );
  }

  public function create()
  {
    if (!$this->request->isPost()) {
      throw new HttpNotFoundException();
    }
    $errors = [];
    $employee = $this->databaseManager->get('Employee');
    $employees = $employee->fetchAllNames();
    $errors = $this->validate($_POST);
    if (!count($errors)) {
      $employee->insert($_POST['name']);
    }

    return $this->render(
      [
        'title' => '社員の登録',
        'errors' => $errors,
        'employeeRegisters' => $employees,
      ],
      'index'
    );
  }

  private function validate(array $employeeName): array
  {
    $errors = [];
    if (!mb_strlen($employeeName['name'])) {
      $errors['name'] = '社員名を入力してください';
    } elseif (mb_strlen($employeeName['name']) > 100) {
      $errors['name'] = '社員名は100文字以内で入力してください';
    }
    return $errors;
  }
}
