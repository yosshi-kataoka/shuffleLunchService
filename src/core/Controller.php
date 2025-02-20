<?php

namespace ShuffleLunch;

use HttpNotFoundException;

abstract class Controller
{
  protected $actionName;
  protected $request;

  public function __construct($application)
  {
    $this->request = $application->request;
  }

  public function run($action)
  {
    $this->actionName = $action;
    if (!method_exists($this, $action)) {
      throw new HttpNotFoundException();
    }
    $content = $this->$action();
    return $content;
  }

  // $variablesは各種変数、$templateはviewファイル(action)、$layoutは共通のlayoutファイル
  protected function render($variables = [], $template = null, $layout = 'Layout')
  {
    $view = new View(__DIR__ . '/../views');

    if (is_null($template)) {
      $template = $this->actionName;
    }

    // 例）shuffleを取得
    $controllerName = strtolower(substr(get_class($this), 0, -10));
    $path = ltrim(strstr($controllerName . '/' . $template, '\\'), '\\');
    return $view->render($path, $variables, $layout);
  }
}
