<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php if (isset($title)) : echo $title . ' - ';
    endif; ?>シャッフルランチ
  </title>
  <link rel="stylesheet" href="../styleSheets/css/app.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <div class="container">
    <a href="/" class="fs-1 inline-block text-decoration-none">シャッフルランチ</a>
    <?php echo $content; ?>

  </div>
</body>

</html>
