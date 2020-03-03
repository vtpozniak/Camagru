<?php

namespace application\models;

use application\core\View;
use application\core\Model;
use application\lib\Db;
use application\Model\Main;

class Account extends Model
{
	//Реєстрація

	public function AcRegister($post)
	{
		$result = false;
		if ($post) {
			$token = $this->createToken();
			$name = filter_var(trim($post['name']), FILTER_SANITIZE_STRING);
			$email = filter_var(trim($post['email']), FILTER_SANITIZE_STRING);
			$login = filter_var(trim($post['login']), FILTER_SANITIZE_STRING);
			$password = $post['password'];
			$password2 = $post['password2'];
			if (!preg_match("/^[a-z0-9_-]{3,16}$/", $name)) {
				View::redirect('/register?alert=incorrect name');
			}else if (!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email)) {
				View::redirect('/register?alert=incorrect E-mail');
			} else if (!preg_match("/^[a-z0-9_-]{3,16}$/", $login)) {
				View::redirect('/register?alert=incorrect Login');
			} else if (!preg_match("/^\S*(?=\S{10,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
				View::redirect('/register?alert=incorrect password');
			} else if (!preg_match("/^\S*(?=\S{10,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password2) || $password != $password2) {
				View::redirect('/register?alert=passwords do not match');
			}
			$password = password_hash($password, PASSWORD_DEFAULT);
			$sql = 'INSERT INTO `users` (name, email, login, password, token, status) VALUES (:name, :email, :login, :password, :token, :status)';
			$params = [':name' => $name, 'email' => $email, ':login' => $login, ':password' => $password, ':token' => $token, ':status' => 0];
			$result = $this->db->query($sql, $params);
			mail($email, 'Register', 'Confirm: http://127.0.0.1:8080/confirm/' . $token);
			View::redirect('/');
		}
	}

	public function checkEmailExists($email)
	{
		$params = [
			'email' => $email,
		];
		$email_exist = $this->db->column('SELECT COUNT(id) FROM users WHERE email = :email', $params);
		$email_exist = intval($email_exist);
		if ($email_exist) {
			return false;
		}
		return true;
	}

	public function checkLoginExists($login)
	{
		$params = [
			'login' => $login,
		];
		$login_exist = $this->db->column('SELECT COUNT(id) FROM users WHERE login = :login', $params);
		$login_exist = intval($login_exist);
		if ($login_exist) {
			return false;
		}
		return true;
	}

	public function checkTokenExists($token)
	{
		$params = [
			'token' => $token,
		];
		$token_exist = $this->db->column('SELECT COUNT(id) FROM users WHERE token = :token', $params);
		$token_exist = intval($token_exist);
		if ($token_exist) {
			return false;
		}
		return true;
	}

	public function activate($token)
	{
		$params = [
			'token' => $token,
		];
		$this->db->query('UPDATE users SET status = 1, token = "" WHERE token = :token', $params);
	}

	public function createToken()
	{
		return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 30)), 0, 30);
	}

//Вхід

	public function checkData($login, $password)
	{
		$params = [
			'login' => $login,
		];
		$login_exist = $this->db->column('SELECT password FROM users WHERE login = :login', $params);
		if (!$login_exist or !password_verify($password, $login_exist)) {
			return false;
		}
		return true;
	}

	public function checkStatus($type, $data)
	{
		$params = [
			$type => $data,
		];
		$status = $this->db->column('SELECT status FROM users WHERE ' . $type . ' = :' . $type, $params);
		if ($status != 1) {
			return false;
		}
		return true;
	}

	public function loginAc($login)
	{
		$params = [
			'login' => $login,
		];
		$data = $this->db->row('SELECT * FROM users WHERE login = :login', $params);
		$_SESSION['users'] = $data[0];
	}

	// Відновлення/зміна паролю

	public function recoveryAction($post)
	{
		$result = false;
		if ($post) {
			$token = $this->createToken();
			$email = filter_var(trim($post['email']), FILTER_SANITIZE_STRING);
			$params = [
			  'email' => $post['email'],
			  'token' => $token,
			];
			$this->db->query('UPDATE users SET token = :token WHERE email = :email', $params);
			mail($email, 'Recovery', 'Confirm: http://127.0.0.1:8080/reset/' . $token);
			unset($_SESSION['users']);
			View::redirect('/?alert=Request sent to E-mail');
		}
	}

	public function reset($post, $token)
	{
		if (!empty($post)){
			$password = $post['password'];
			$password2 = $post['password2'];
			if (!preg_match("/^\S*(?=\S{10,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
				View::redirect('/reset/' . $token . '?alert=incorrect password');
			} else if (!preg_match("/^\S*(?=\S{10,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password2) || $password != $password2) {
				View::redirect('/reset/' . $token . '?alert=passwords do not match');
			}
			$params = [
				'token' => $token,
				'password' => password_hash($password, PASSWORD_DEFAULT),
			];
			$this->db->query('UPDATE users SET token = "", password = :password WHERE token = :token', $params);
			View::redirect('/login');
		}
	}

	public function loadProfile($info)
	{

		$res = $this->db->row("SELECT * FROM `users` WHERE `id` = :id", ['id' => $info]);
		if (!empty($res))
			return $res;
		return false;
	}

	public function getLike($id){
		$res = $this->db->row("SELECT COUNT( * ) AS 'likeCont' FROM `like` WHERE `photo_id` = :id", ['id' => $id])[0]['likeCont'];
		return($res);
	}

	public function loadPhotos($info)
	{
		if (empty($_GET['page']) || !is_numeric($_GET['page']))
			$_GET['page'] = 1;
		$start = ($_GET['page'] - 1) * 6;
		$end = $_GET['page'] * 6;
		$res = $this->db->galery("SELECT `photo`, `id` FROM `photo` WHERE `user_id` = ${info} ORDER BY `id` DESC LIMIT 6 OFFSET ${start}");
		$count = $this->db->galery("SELECT COUNT(`id`) AS 'post_count' FROM `photo` WHERE `user_id` = ${info}");
		foreach ($res as $key => $value) {
			$res[$key]['lileCount'] = $this->getLike($value['id']);
			$res[$key]['comment'] = $this->db->row("SELECT * FROM `coment` WHERE `photo_id` = :id", ['id' => $value['id']]);
		}
		$rez = [
			$res,
			$count,
		];
		if (!empty($rez))
			return $rez;
		return false;
	}

}
