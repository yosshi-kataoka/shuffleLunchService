<?php

namespace ShuffleLunch;

class AutoLoader
{
  // 複数のディレクトリの情報を保持する$dirsを定義
  private $dirs = [];

  //$this->dirsに格納されているディレクトリ配下のクラスをオートロードする
  public function register()
  {
    spl_autoload_register([$this, 'loadClass']);
  }

  public function registerDir($dir)
  {
    $this->dirs[] = $dir;
  }

  private function loadClass($className)
  {
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
      $namespace = substr($className, 0, $lastNsPos);
      $className = substr($className, $lastNsPos + 1);
      $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    foreach ($this->dirs as $dir) {
      $file = $dir . DIRECTORY_SEPARATOR . $className . '.php';
      if (is_readable($file)) {
        require $file;
        return;
      }
    }
  }
}
