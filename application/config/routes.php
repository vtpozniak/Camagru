<?php

return [
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
	
	'login' => [
		'controller' => 'account',
		'action' => 'login',
	],
	
	'register' => [
		'controller' => 'account',
		'action' => 'register',
	],

	'confirm/{token:\w+}' => [
		'controller' => 'account',
		'action' => 'confirm',
	],

	'reset/{token:\w+}' => [
		'controller' => 'account',
		'action' => 'reset',
	],

	'profile\/([0-9]*)' => [
		'controller' => 'account',
		'action' => 'profile',
	],

	'logout' => [
		'controller' => 'account',
		'action' => 'logout',
	],

	'recovery' => [
		'controller' => 'account',
		'action' => 'recovery',
	],

	'data/new' => [
		'controller' => 'account',
		'action' => 'data/new',
	],

	'camera' => [
		'controller' => 'main',
		'action' => 'camera',
	],

	'post/new' => [
		'controller' => 'main',
		'action' => 'newPost',
	],

	'photo/new' => [
		'controller' => 'main',
		'action' => 'newPhoto',
	],

	'comment/new' => [
		'controller' => 'main',
		'action' => 'newComment',
	],

	'like/new' => [
		'controller' => 'main',
		'action' => 'newLike',
	],


];
