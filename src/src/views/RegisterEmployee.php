<?php

namespace ShuffleLunch;

require_once(__DIR__ . '/../lib/Escape.php');

use function  ShuffleLunch\escape;
?>

<div class="container px-0">
  <h2>社員の登録</h2>
  <form action="create.php" method="POST">
    <div>
      <label for="name" class="fs-4">社員名</label>
      <input type="text" class="form-control" name="name" id="name" value="<?php echo $employeeName['name']; ?>">
    </div>
    <button type="submit" class="btn btn-primary my-3">登録する</button>
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
