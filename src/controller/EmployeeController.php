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
    if ($_POST['dropdownValue'] === 'default') {
      $errors['select'] = '修正する社員が未選択です。';
    } else {
      $selectEmployee = json_decode($_POST['dropdownValue'], true);
      $selectEmployeeName = $selectEmployee['name'];
      $selectEmployeeId = $selectEmployee['id'];
      $employees = $this->databaseManager->get('Employee');
      $employeesList = $employees->fetchAllNames();
      $existsIdNumbers = array_column($employeesList, 'id');
      $errors = $this->validateSelect($_POST,  $selectEmployeeName, $existsIdNumbers);
    }
    if ($errors) {
      return $this->render(
        [
          'title' => '社員情報の修正',
          'errors' => $errors,
          'employeeRegisters' => $employees,
        ],
        'select'
      );
    }
    $updateDetails = $this->checkUpdate($_POST, $selectEmployeeName, $selectEmployeeId);
    $employees->update($updateDetails, $selectEmployeeId);
    // todo 選択した社員情報を表示するupdateページを作成
    return $this->render(
      [
        'title' => '社員情報の更新完了',
      ]
    );
  }

  private function validateSelect($post, $selectEmployeeName, $existsIdNumbers): array
  {
    $errors = [];
    if ($post['updateEmployeeName'] === '' && $post['updateEmployeeId'] === '') {
      $errors['update'] = '修正する内容が入力されておりません。';
    }
    if ($selectEmployeeName === $post['updateEmployeeName']) {
      $errors['updateName'] = '修正後の従業員名が選択された従業員名と同じ名前になっています。';
    }
    if ($this->isIdExists($post['updateEmployeeId'], $existsIdNumbers)) {
      $errors['updateId'] = '修正後の従業員idは既に存在しております。別の値のidを入力してください。';
    }
    return $errors;
  }

  private function isIdExists($updateEmployeeId, $existsIdNumbers)
  {
    return in_array($updateEmployeeId, $existsIdNumbers);
  }
  private function checkUpdate($updateDetails, $selectEmployeeName, $selectEmployeeId)
  {
    if ($updateDetails['updateEmployeeName'] === '') {
      $updateDetails['updateEmployeeName'] = $selectEmployeeName;
    } elseif ($updateDetails['updateEmployeeId'] === '') {
      $updateDetails['updateEmployeeId'] = $selectEmployeeId;
    }
    return $updateDetails;
  }

  public function delete()
  {
    $employeeRegisters = $this->databaseManager->get('Employee')->fetchAllNames();
    return $this->render(
      [
        'title' => '社員の削除',
        'errors' => [],
        'employeeRegisters' => $employeeRegisters,
      ]
    );
  }

  // 選択した社員を削除してよいかの確認画面を表示
  public function deleteCheck()
  {
    if (!$this->request->isPost()) {
      throw new HttpNotFoundException();
    }
    if ($_POST['dropdownValue'] === 'default') {
      $errors['select'] = '削除する社員が未選択です。';
      $employeeRegisters = $this->databaseManager->get('Employee')->fetchAllNames();
      return $this->render(
        [
          'title' => '社員の削除',
          'errors' => $errors,
          'employeeRegisters' => $employeeRegisters,
        ],
        'delete'
      );
    }
    $deleteEmployee = json_decode($_POST['dropdownValue'], true);
    $deleteEmployeeName = $deleteEmployee['name'];
    $deleteEmployeeId = $deleteEmployee['id'];

    return $this->render(
      [
        'title' => '削除する社員の確認',
        'deleteEmployeeName' => $deleteEmployeeName,
        'deleteEmployeeId' => $deleteEmployeeId,
      ]
    );
  }

  public function deleteComplete()
  {
    if (!$this->request->isPost()) {
      throw new HttpNotFoundException();
    }
    $deleteEmployee = json_decode($_POST['deleteEmployee'], true);
    $deleteEmployeeId = $deleteEmployee['id'];
    $employee = $this->databaseManager->get('employee');
    $employee->delete($deleteEmployeeId);
    return $this->render(
      [
        'title' => '社員を削除しました',
      ]
    );
  }
}
