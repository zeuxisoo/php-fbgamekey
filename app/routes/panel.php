<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/panel', function() use ($app) {
	$app->render('panel/index.html');
})->name('panel-index');

$app->get('/panel/home', Application_Helper::need_admin(), function() use ($app) {
	$app->render('panel/home.html');
})->name('panel-home');

$app->post('/panel/login', function() use ($app, $config) {
	$username = $app->request()->post('username');
	$password = $app->request()->post('password');
	$remember = $app->request()->post('remember');

	$success = false;
	$message = '';

	if (empty($username) === true) {
		$message = '請輸入帳號';
	}else if (empty($password) === true) {
		$message = '請輸入密碼';
	}else{
		$user = Model::factory('administrator')->where('username', $username)->find_one();

		if ($user === false) {
			$message = '找不到此用戶';
		}else if ($user->password != sha1($password)) {
			$message = '密碼錯誤';
		}else{
			$remember = empty($remember) === false ? intval($remember) : 3600 * 2;

			$auth_string = Permission::create_key($username, $password, $config['common']['cookies_secret_key']);

			$app->setCookie('auth_key', $auth_string, time()+$remember);

			$user->update_at = time();
			$user->save();

			$success = true;
			$message = '登入成功';
		}
	}

	if ($success === false) {
		$app->flash('error', $message);
		$app->redirect($app->urlFor('panel-index'));
	}else{
		$app->flash('success', $message);
		$app->redirect($app->urlFor('panel-home'));
	}
});


$app->get('/panel/logout', function() use ($app) {
	session_destroy();

	$app->setCookie('auth_key', "");

	$app->redirect($app->urlFor('panel-index'));
});
?>