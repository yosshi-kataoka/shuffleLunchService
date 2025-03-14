<?php

use function  ShuffleLunch\escape;
?>
<div class="container px-0">
  <h3>社員の削除</h3>
  <h4>以下の社員を削除しますがよろしいでしょうか。</h4>
  <form class="mb-3 fs-4" method="POST" action="deleteComplete">
    <div class="card">
      <input type="hidden" name="deleteEmployee" value='{"id": <?php echo escape($deleteEmployeeId); ?>, "name": "<?php echo escape($deleteEmployeeName); ?>"}'>
      <?php echo escape($deleteEmployeeName) . "(ID:" . $deleteEmployeeId . ")"; ?>
    </div>
    <div class="mt-2">
      <button type="submit" class="btn btn-danger">社員を削除する</button>
      <a href="delete" class="btn btn-primary mx-3">戻る</a>
    </div>
  </form>
</div>
