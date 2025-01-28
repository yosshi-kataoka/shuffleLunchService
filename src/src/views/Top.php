<?php
require_once(__DIR__ . '/../lib/Escape.php');

use function  ShuffleLunch\escape;
?>


<div class="container px-0">
  <a href="/src/RegisterEmployee.php" class="fs-2 inline-block text-decoration-none"><span class="fa-solid fa-user"></span>社員を登録する</a><br>
  <button onclick="location.href= '/src/Shuffle.php'" type="button" class="btn btn-primary my-3">シャッフルする</button>
  <h2>グループ結果</h2>
  <div class="card">
    <?php if (count($shuffleEmployeesRegisters) > 0) : ?>
      <?php foreach ($shuffleEmployeesRegisters as $groupIndex => $group) : ?>
        <div class="card-title">
          グループ<?php echo ($groupIndex + 1); ?><br>
          <div class="card-text">
            <?php foreach ($group as $employee) : ?>
              <?php echo escape($employee['name']) . "(ID:" . $employee['id'] . ")"; ?>&nbsp;
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
