<?php
// こちらでは社員の登録ページの内容を記載
use function  ShuffleLunch\escape;
?>

<div class="container px-0">
  <h2>社員の登録</h2>
  <form action="employee/create" method="POST">
    <?php if (count($errors)) : ?>
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li class="text-danger"><?php echo $error; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <div>
      <label for="name" class="fs-4">社員名</label>
      <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="mt-2">
      <button type="submit" class="btn btn-primary my-3">登録する</button>
      <a href="/" class="btn btn-primary mx-4">トップページへ戻る</a>
    </div>
  </form>
  <h2>社員の一覧</h2>
  <div class="card">
    <?php if (count($employeeRegisters) > 0) : ?>
      <?php foreach ($employeeRegisters as $employeeRegister) : ?>
        <div class="card-text fs-5">
          <?php echo escape($employeeRegister['name']) . "(ID:" . $employeeRegister['id'] . ")"; ?>&nbsp;
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
