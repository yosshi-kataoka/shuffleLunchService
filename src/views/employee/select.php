<?php
// こちらでは社員の登録ページの内容を記載
use function  ShuffleLunch\escape;
?>

<div class="container px-0">
  <h2>社員情報の変更</h2>
  <form action="update" method="POST">
    <div class="mb-3">
      <?php if (count($errors)) : ?>
        <ul>
          <?php foreach ($errors as $error) : ?>
            <li class="text-danger"><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <select class="form-select" name="dropdownValue" aria-label="select employee" required>
        <option value="default" selected>修正する社員を選択してください</option>
        <?php if (count($employeeRegisters) > 0) : ?>
          <?php foreach ($employeeRegisters as $employeeRegister) : ?>
            <option value='{"id": <?php echo escape($employeeRegister['id']); ?>, "name": "<?php echo escape($employeeRegister['name']); ?>"}' ?><?php echo escape($employeeRegister['name']) . "(ID:" . $employeeRegister['id'] . ")"; ?>&nbsp;</option>
          <?php endforeach; ?>
      </select>
      <div class="card my-3">
        <div class="card-body">
          <h4>修正する内容</h4>
          <div class="my-3">
            <label for="updateEmployeeName" class="form-label">修正後の従業員名を入力してください</label>
            <input type="text" class="form-control" id="updateEmployeeName" placeholder="こちらに更新後の名前を入力してください" name="updateEmployeeName">
          </div>
          <div class="mb-3">
            <label for="updateEmployeeId" class="form-label">修正後の従業員idの値を整数で入力してください</label>
            <input type="number" class="form-control" id="updateEmployeeId" name="updateEmployeeId" placeholder="こちらに更新後のidを整数で入力してください">
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary my-3">修正へ進む</button>
    <?php else : ?>
      <h2>社員情報が登録されておりません</h2>
    <?php endif; ?>
    </div>
  </form>
</div>
