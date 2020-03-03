<?php


namespace application\core;

use application\core\View;

class Controller
{
	public $route;
	public $view;
	public $acl;
	
	public function  __construct($route)
	{
		$this->route = $route;
		$this->view = new View($route);
		$this->model = $this->loadModel($route['controller']);
	}
	
	public function loadModel($name){
		$path = 'application\models\\'.ucfirst($name);
		if(class_exists($path)){
			return new $path;
		}
	}
	
	public function checkAcl() {
		$this->acl = require 'application/acl/permission.php';
		if ($this->idAcl('all')){
			return true;
		}
        elseif (isset($_SESSION['users']['id']) and $this->idAcl('authorize')) {
            return true;
        }
        elseif (!isset($_SESSION['users']['id']) and $this->idAcl('guest')) {
            return true;
        }
		elseif (isset($_SESSION['admin']) and $this->idAcl('admin')){
			return true;
		}
		return false;
	}
	
	public function idAcl($key) {
		return in_array($this->route['action'], $this->acl[$key]);
	}
}

