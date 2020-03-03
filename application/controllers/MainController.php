<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Db;

class MainController extends Controller
{
	public function indexAction(){
		$photos = $this->model->loadGalery();
        $vars = [
            'photos' => $photos,
        ];
        
		$this->view->render('GLAVNAA STRANITSA', $vars);
	}

	public function newPostAction(){
		$this->model->newPost();
	}

	public function newPhotoAction(){
		$this->model->newPhoto();
	}

	public function cameraAction(){
		$this->view->render('CAMS');
	}

	public function newCommentAction()
	{
		if ($this->model->newComment($_POST))
			$this->view->redirect($_SERVER['HTTP_REFERER']);
		else
			$this->view->redirect($_SERVER['HTTP_REFERER']."?error");
	}

	public function newLikeAction()
	{
		if ($this->model->newLike($_POST)){
			$this->view->redirect($_SERVER['HTTP_REFERER']);
		}
		else
			$this->view->redirect($_SERVER['HTTP_REFERER']."?error");
	}



}