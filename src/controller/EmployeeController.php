<?php

namespace ShuffleLunch;

use HttpNotFoundException;

class EmployeeController extends Controller
{
  public function index()
  {
    $errors = [];
    $pdo = dbConnect();
    $employeeRegisters = getEmployeesRegister($pdo);

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
    $employeeName['name'] = $_POST['name'];
    $errors = $this->validate($employeeName);
    $pdo = dbConnect();
    $employeeRegisters = getEmployeesRegister($pdo);
    if (!count($errors)) {
      registeringEmployee($pdo, $employeeName);
      header('Location: /employee');
    }

    return $this->render(
      [
        'title' => '社員の登録',
        'errors' => $errors,
        'employeeRegisters' => $employeeRegisters,
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
