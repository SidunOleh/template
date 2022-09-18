<?php 

namespace App\Components;

use App\Exceptions\PageNotFoundException;

class Router
{
	/** 
     * @var array routes
     */
	private $routes;

	public function __construct()
	{
		$routes = require(ROOT . '/routes/routes.php');

		$this->routes = $routes[$_SERVER['REQUEST_METHOD']];
	}

	/**
     * Path out of URI
     *      
     * @return string path
     */
	private function getPath()
	{
		$path = preg_replace("~\?.*~", '', $_SERVER['REQUEST_URI']);

		return $path == '/' ? $path : rtrim($path, '/');
	}

	/**
     * Routing
     *      
     * @return string response
	 * 
	 * @throws PageNotFoundException
     */
	public function run()
	{
		$path = $this->getPath();

		foreach ($this->routes as $pattern => $route) {
			if(preg_match("~^$pattern$~", $path)) {
				$route = preg_replace("~^$pattern$~", $route, $path);
				
				$segms = explode('/', $route);

				$controllerName = 'App\Controllers\\' . ucfirst(array_shift($segms)) . 'Controller';
				$methodName     = array_shift($segms);

				$response = call_user_func_array([new $controllerName, $methodName], $segms);

				return $response;
			}
		}

		throw new PageNotFoundException('Page Not Found.');
	}
}
