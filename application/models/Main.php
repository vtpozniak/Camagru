<?php

namespace application\models;

use application\core\Model;
use application\core\View;

class Main extends Model
{
	public function newPost() {
	if(isset($_POST['upload'])) {
		if(empty($_FILES['upfile']['size']))
			die('Вы не выбрали файл');
		if($_FILES['upfile']['size'] > (5 * 1024 * 1024))
			die('Размер файла не должен превышать 5Мб');
		$imageinfo = getimagesize($_FILES['upfile']['tmp_name']);
		$arr = array('image/jpeg','image/gif','image/png', 'image/jpg');
		if(!in_array($imageinfo['mime'], $arr)) echo ('Картинка должна быть формата JPG, GIF или PNG');
		else {
			$upload_dir = 'public/upload/'; 
			$name = $upload_dir.date('YmdHis').basename($_FILES['upfile']['name']);
			$mov = move_uploaded_file($_FILES['upfile']['tmp_name'],$name);
			if($mov) {	
				$name = htmlentities(stripslashes(strip_tags(trim($name))),ENT_QUOTES,'UTF-8');
				$postlike = 0;
				$user_id = $_SESSION['users']['id'];
				$photo = $name;
				$sql = 'INSERT INTO `photo` (postlike, user_id, photo) VALUES (:postlike, :user_id, :photo)';
				$params = [':postlike' => $postlike, ':user_id' => $user_id, ':photo' => $photo];
				$result = $this->db->row($sql, $params);
				View::redirect("/profile/{$_SESSION['users']['id']}");
				}
				else echo 'Произошла ошибка при загрузке фотографии. Пожалуйста, попробуйте снова';
			}
		}
	}

	public function newPhoto(){
		if(isset($_POST)){
			$imageInfo = explode(";base64,", $_POST['photo']);
			$imgExt = str_replace('data:image/', '', $imageInfo[0]);
			$image = str_replace(' ', '+', $imageInfo[1]);
			$pathPhoto = "public/images/cams/{$_SESSION['users']['id']}-".time().".png";
			file_put_contents($pathPhoto, base64_decode($image));
			$postlike = 0;
			$user_id = $_SESSION['users']['id'];
			$photo = $pathPhoto;
			$sql = 'INSERT INTO `photo` (postlike, user_id, photo) VALUES (:postlike, :user_id, :photo)';
			$params = [':postlike' => $postlike, ':user_id' => $user_id, ':photo' => $photo];
			$result = $this->db->row($sql, $params);
			View::redirect("/profile/{$_SESSION['users']['id']}");
		}
	}

	public function newComment($info){
		$name = $_SESSION['users']['name'];
		$sql = 'INSERT INTO `coment` (photo_id, user_name, comment) VALUES (:photo_id, :user_name, :comment)';
		$params = ['photo_id' => $info['id'], 'user_name' => $_SESSION['users']['name'], 'comment' => $info['comment']];
		$result = $this->db->row($sql, $params);
		$com = 'SELECT `user_id` FROM `photo` WHERE `id` = :id';
		$user_id = $this->db->row($com, ['id' => $info['id']]);
		$user_email = $this->db->row('SELECT * FROM `users` WHERE `id` = :id', ['id' => $user_id[0]['user_id']])[0];
		mail($user_email['email'], 'Comment', 'New comment from' . $name . $info['comment']);
		return ($result == []);
	}

	public function newLike($info){
		$sql = 'INSERT INTO `like` (photo_id, photo_like) VALUES (:photo_id, :photo_like)';
		$params = ['photo_id' => $info['id'], 'photo_like' => $_SESSION['users']['id']];
		$result = $this->db->row($sql, $params);
		return ($result == []);
	}

	public function getLike($id){
		$res = $this->db->row("SELECT COUNT( * ) AS 'likeCont' FROM `like` WHERE `photo_id` = :id", ['id' => $id])[0]['likeCont'];
		return($res);
	}

	public function loadGalery()
	{
		if (empty($_GET['page']) || !is_numeric($_GET['page']))
			$_GET['page'] = 1;
		$start = ($_GET['page'] - 1) * 6;
		$end = $_GET['page'] * 6;
		$res = $this->db->galery("SELECT `photo`, `id` FROM `photo` ORDER BY `id` DESC LIMIT 6 OFFSET ${start}");
		$count = $this->db->galery("SELECT COUNT(`id`) AS 'post_count' FROM `photo`");
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
