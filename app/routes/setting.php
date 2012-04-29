<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/setting', Application_Helper::need_admin(), function() use ($app) {
	$config  = array();
	$setting = Model::factory('Setting')->find_many();
	foreach($setting as $row) {
		$config[$row->name] = $row->content;
	}
	$setting = &$config;

	$app->render('setting/index.html', array(
		'setting' => $setting,
	));
})->name('setting-index');

$app->post('/setting/save', Application_Helper::need_admin(), function() use ($app) {
	$app_id      = $app->request()->post('app_id');
	$title       = $app->request()->post('title');
	$link        = $app->request()->post('link');
	$picture     = $app->request()->post('picture');
	$caption     = $app->request()->post('caption');
	$description = $app->request()->post('description');

	$type = 'error';
	$message = '';

	if (empty($app_id) === true) {
		$message = '請輸入應用程式 ID';
	}elseif (empty($title) === true) {
		$message = '請輸入訊息標題';
	}elseif (empty($picture) === true) {
		$message = '請輸入訊息圖片';
	}elseif (empty($caption) === true) {
		$message = '請輸入訊息副標題';
	}elseif (empty($description) === true) {
		$message = '請輸入訊息描述';
	}else{
		$setting = Model::factory('Setting')->find_many();
		foreach($setting as $row) {
			$variable_name = $row->name;
			if ($$variable_name != $row->content) {
				$target_setting = Model::factory('Setting')->where('name', $variable_name)->find_one();
				$target_setting->content = $$variable_name;
				$target_setting->save();
			}
		}

		$type = 'success';
		$message = '更新系統設置資料完成';
	}

	$app->flash($type, $message);
	$app->redirect($app->urlFor('setting-index'));
});
?>