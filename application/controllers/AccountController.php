<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

class AccountController extends Controller
{

	//Реєстрація
	
	public function registerAction(){
		if (!empty($_POST)) {
			if (!$this->model->checkEmailExists($_POST['email'])) {
				echo '<script>alert("incorrect E-mail");</script>';
			}
			 if (!$this->model->checkLoginExists($_POST['login'])) {
				echo'<script>alert("incorrect Login");</script>';
			}else{
				$this->model->AcRegister($_POST);
			}
		}
		$this->view->render('STRANITSA REGISTR');
	}

	public function confirmAction(){
		if ($this->model->checkTokenExists($this->route['token'])) {

			View::errorCode(404);
		}
		$this->model->activate($this->route['token']);
		$this->view->render(' OK REGISTER');
	}

	//Вхід

	public function loginAction(){
		if (!empty($_POST)) {
			if (!$this->model->checkData($_POST['login'], $_POST['password'])) {
				View::redirect('/login?alert=Login or password is incorrect');
			}
			elseif (!$this->model->checkStatus('login', $_POST['login'])) {
				View::redirect('/login?alert=Confirm your account by Email');
			} else {
				$this->model->loginAc($_POST['login']);
				View::redirect("/profile/{$_SESSION['users']['id']}");
			}
		}
		$this->view->render('STRANITSA VHODA');
	}

	//Профіль

	public function profileAction(){
		$photos = $this->model->loadPhotos($this->route['id']);
		$vars = [
			'photos' => $photos,
		];
		if (($info = $this->model->loadProfile($this->route['id'])) == false)
			$this->view->errorCode(404);
		$this->view->render('STRANITSA Profile', $vars);
	}

	public function logoutAction(){
		unset($_SESSION['users']);
		$this->view->redirect('/login');
	}

	//Відновлення паролю

	public function recoveryAction() {
		if (!empty($_POST)) {
			if ($this->model->checkEmailExists($_POST['email'])) {
				View::redirect('/recovery?alert=E-mail not found');
			}
			elseif (!$this->model->checkStatus('email', $_POST['email'])) {
				View::redirect('/recovery?alert=Confirm your account by E-mail');
			}
			$this->model->recoveryAction($_POST);
		}
		$this->view->render('Recovering password');
	}

	public function resetAction(){

		if ($this->model->checkTokenExists($this->route['token'])) {
			View::errorCode(404);
		}
		$this->model->reset($_POST, $this->route['token']);
		$this->view->render(' OK REGISTER');
	}

}
