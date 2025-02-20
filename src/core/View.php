<?php

namespace ShuffleLunch;

class view
{
  protected $baseDir;
  public function __construct($baseDir)
  {
    $this->baseDir = $baseDir;
  }

  // layoutは受け取らない可能性があるので初期値false
  public function render($path, $variables, $layout = false)
  {

    extract($variables);

    ob_start();
    require $this->baseDir . '/' . $path . '.php';
    $content = ob_get_clean();

    ob_start();
    require $this->baseDir . '/' . $layout . '.php';
    $layout = ob_get_clean();

    return $layout;
  }
}
