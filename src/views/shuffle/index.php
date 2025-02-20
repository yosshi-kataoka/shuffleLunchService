<?php
// こちらではトップページの内容を記載
use function  ShuffleLunch\escape;
?>

<div class="container px-0">
  <a href="employee" class="fs-2 inline-block text-decoration-none">
    <span class="fa-solid fa-user"></span>社員を登録する</a><br>
  <form action="shuffle" method="POST">
    <button type="submit" class="btn btn-primary my-3">シャッフルする</button>
  </form>
  <h2>グループ結果</h2>
  <div class="card">
    <?php if (count($shuffleEmployees) > 0) : ?>
      <?php foreach ($shuffleEmployees as $groupIndex => $group) : ?>
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
