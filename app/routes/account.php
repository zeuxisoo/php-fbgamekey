<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/account', Application_Helper::need_admin(), function() use ($app) {
	$app->render('account/index.html');
})->name('account-index');

$app->post('/account/save', Application_Helper::need_admin(), function() use ($app) {
	$old_password = $app->request()->post('old_password');
	$new_password = $app->request()->post('new_password');
	$confirm_password = $app->request()->post('confirm_password');

	$type = 'error';
	$message = '';

	$user = Model::factory('Administrator')->where('username', $_SESSION['username'])->find_one();

	if (empty($old_password) === true) {
		$message = '請輸入舊密碼';
	}elseif ($user->password != sha1($old_password)) {
		$message = '舊密碼不正確';
	}elseif (empty($new_password) === true) {
		$message = '請輸入新的密碼';
	}elseif (strlen($new_password) < 8) {
		$message = '新的密碼必須多於 8 個字玩';
	}elseif ($new_password != $confirm_password) {
		$message = '新的密碼與確認密碼不相符';
	}else{
		$user->password = sha1($new_password);
		$user->save();

		$type = 'success';
		$message = '更新帳戶資料完成';
	}


	$app->flash($type, $message);
	$app->redirect($app->urlFor('account-index'));
});
?>