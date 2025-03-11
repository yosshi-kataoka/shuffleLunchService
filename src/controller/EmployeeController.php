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
    $errors = $this->validateEmployeeName($_POST);
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

  private function validateEmployeeName(array $employeeName): array
  {
    $errors = [];
    if (!mb_strlen($employeeName['name'])) {
      $errors['name'] = '社員名を入力してください';
    } elseif (mb_strlen($employeeName['name']) > 100) {
      $errors['name'] = '社員名は100文字以内で入力してください';
    }
    return $errors;
  }

  public function select()
  {
    $employees = $this->databaseManager->get('Employee')->fetchAllNames();
    return $this->render(
      [
        'title' => '社員情報の修正',
        'errors' => [],
        'employeeRegisters' => $employees,
      ]
    );
  }

  public function update()
  {
    if (!$this->request->isPost()) {
      throw new HttpNotFoundException();
    }
    $errors = $this->validateSelect($_POST);
    if ($errors) {
      $employees = $this->databaseManager->get('Employee')->fetchAllNames();
      return $this->render(
        [
          'title' => '社員情報の修正',
          'errors' => $errors,
          'employeeRegisters' => $employees,
        ],
        'select'
      );
    }
    //todo 選択した社員の情報を表示させるロジックを実装
    $selectEmployee = json_decode($_POST['dropdownValue'], true);
    // todo 選択した社員情報を表示するupdateページを作成
    return $this->render(
      [
        'title' => '社員情報の修正',
        'selectEmployee' => $selectEmployee,
      ]
    );
  }

  private function validateSelect($post): array
  {
    $errors = [];
    if ($post['dropdownValue'] === 'default') {
      $errors['notSelectEmployee'] = '修正する社員が未選択です。';
    } elseif ($post['updateEmployeeName'] === '' && $post['updateEmployeeId'] === '') {
      $errors['notSelectUpdate'] = '修正する内容が入力されておりません。';
    }
    return $errors;
  }
}
