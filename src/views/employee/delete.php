<?php

use function  ShuffleLunch\escape;
?>

<div class="container px-0">
  <h3>削除する社員を選択</h3>
  <form action="deleteCheck" method="POST">
    <div class="mb-3">
      <?php if (count($errors)) : ?>
        <ul>
          <?php foreach ($errors as $error) : ?>
            <li class="text-danger"><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <select class="form-select" name="dropdownValue" aria-label="select employee" required>
        <option value="default" selected>削除する社員を選択してください</option>
        <?php if (count($employeeRegisters) > 0) : ?>
          <?php foreach ($employeeRegisters as $employeeRegister) : ?>
            <option value='{"id": <?php echo escape($employeeRegister['id']); ?>, "name": "<?php echo escape($employeeRegister['name']); ?>"}' ?><?php echo escape($employeeRegister['name']) . "(ID:" . $employeeRegister['id'] . ")"; ?>&nbsp;</option>
          <?php endforeach; ?>
      </select>
      <button type="submit" class="btn btn-danger my-3">削除へ進む</button>
    <?php else : ?>
      <h2>社員情報が登録されておりません</h2>
    <?php endif; ?>
    </div>
  </form>
</div>
