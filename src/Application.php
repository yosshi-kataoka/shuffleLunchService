<?php

namespace ShuffleLunch;

use HttpNotFoundException;
use Dotenv;

class Application
{
  protected $request;
  protected $router;
  protected $response;
  protected $databaseManager;


  public function __construct()
  {
    $this->router = new Router($this->registerRouters());
    $this->request = new Request();
    $this->response = new Response();
    $this->databaseManager = new DatabaseManager();
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__  . '/');
    $dotenv->load();
    $this->databaseManager->connect(
      [
        'hostname' => $_ENV['DB_HOST'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'database' => $_ENV['DB_DATABASE'],
      ]
    );
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

  public function getDatabaseManager()
  {
    return $this->databaseManager;
  }

  public function getRequest()
  {
    return $this->request;
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
      '/employee/createSuccess' => ['controller' => 'employee', 'action' => 'createSuccess'],
      '/employee/update' => ['controller' => 'employee', 'action' => 'update'],
      '/employee/updateProcess' => ['controller' => 'employee', 'action' => 'updateProcess'],
      '/employee/updateSuccess' => ['controller' => 'employee', 'action' => 'updateSuccess'],
      '/employee/delete' => ['controller' => 'employee', 'action' => 'delete'],
      '/employee/deleteCheck' => ['controller' => 'employee', 'action' => 'deleteCheck'],
      '/employee/deleteProcess' => ['controller' => 'employee', 'action' => 'deleteProcess'],
      '/employee/deleteSuccess' => ['controller' => 'employee', 'action' => 'deleteSuccess'],
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
