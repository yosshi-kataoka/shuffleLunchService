<?php

namespace ShuffleLunch;

use HttpNotFoundException;

class Application
{
  public $request;

  protected $router;
  protected $response;


  public function __construct()
  {
    $this->router = new Router($this->registerRouters());
    $this->request = new Request();
    $this->response = new Response();
  }

  public function run()
  {
    try {
      $params = $this->router->resolve($this->request->getPathInfo());
      if (!$params) {
        throw new HttpNotFoundException();
      }
      $controller = $params['controller'];
      $action = $params['action'];
      $this->runAction($controller, $action);
    } catch (HttpNotFoundException) {
      $this->render404Page();
    }
    // HTTPレスポンスを返す処理
    $this->response->send();
  }

  private function runAction($controllerName, $action)
  {
    $controllerClass = 'ShuffleLunch\\' . ucFirst($controllerName) . 'Controller';
    if (!class_exists($controllerClass)) {
      throw new HttpNotFoundException();
    }
    $controller = new $controllerClass($this);
    $content = $controller->run($action);
    $this->response->setContent($content);
  }

  private function registerRouters()
  {
    return [
      '/' => ['controller' => 'shuffle', 'action' => 'index'],
      '/shuffle' => ['controller' => 'shuffle', 'action' => 'create'],
      '/employee' => ['controller' => 'employee', 'action' => 'index'],
      '/employee/create' => ['controller' => 'employee', 'action' => 'create'],
    ];
  }


  private function render404Page()
  {
    $this->response->setStatusCode(404, 'Not Found');
    ob_start();
    require __DIR__ . '/views/PageNotFound.php';
    $content = ob_get_clean();
    $this->response->setContent($content);
  }
}
