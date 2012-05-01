<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/key', Application_Helper::need_admin(), function() use ($app) {
	$app->render('key/index.html');
})->name('key-index');

$app->post('/key/create', Application_Helper::need_admin(), function() use ($app) {
	$code = $app->request()->post('code');
	$lock = $app->request()->post('lock');

	$type = 'error';
	$message = '';

	if (empty($code) === true) {
		$message = '請輸入金鑰';
	}else if (in_array($lock, array('0', '1')) === false) {
		$message = '可使用狀態不正確';
	}else{
		$exists_code = Model::factory('key')->where('code', $code)->find_one();

		if ($exists_code !== false) {
			$message = '金鑰已存在';
		}else{
			$key = Model::factory('key')->create();
			$key->code = $code;
			$key->lock = $lock;
			$key->create_at = time();
			$key->save();

			$type = 'success';
			$message = '建立新的金鑰完成';
		}
	}

	$app->flash($type, $message);
	$app->redirect($app->urlFor('key-index'));
});

$app->get('/key/list', Application_Helper::need_admin(), function() use ($app) {
	$code = $app->request()->get('code');
	$lock = $app->request()->get('lock');

	$key_list_per_page = Key_Helper::key_list_per_page();

	$key_count = Model::factory('Key');
	$key_search = Model::factory('Key');

	if (empty($code) === false) {
		$key_search->where_like("code", "%".rawurldecode($code)."%");
	}

	if (in_array($lock, array('0', '1')) === true) {
		$key_search->where_like("lock", "%".rawurldecode($lock)."%");
	}

	$paginate = new Paginate($key_count->count(), $key_list_per_page);
	$keys = $key_search->limit($key_list_per_page)->offset($paginate->offset)->order_by_desc('create_at')->find_many();

	$app->render('key/list.html', array(
		'keys' => $keys,
		'paginate' => $paginate->build_page_bar()
	));
})->name('key-list');

$app->get('/key/edit/:id', Application_Helper::need_admin(), function($id) use ($app) {
	$key = Model::factory('Key')->find_one($id);

	if ($key === false) {
		$app->flash('error', '找不到此客戶');
		$app->redirect($app->urlFor('key-list'));
	}else{
		$app->render('key/edit.html', array(
			'id' => $id,
			'key' => $key,
		));
	}
});

$app->post('/key/update', Application_Helper::need_admin(), function() use ($app) {
	$id = $app->request()->post('id');

	$key = Model::factory('Key')->find_one($id);

	if ($key === false) {
		$app->flash('error', '更新金鑰出錯,找不到對應的金鑰');
	}else{
		$code = $app->request()->post('code');
		$lock = $app->request()->post('lock');

		$type = 'error';
		$message = '';

		if (empty($code) === true) {
			$message = '請輸入金鑰';
		}else if (in_array($lock, array('0', '1')) === false) {
			$message = '可使用狀態不正確';
		}else{
			$key->code = $code;
			$key->lock = $lock;
			$key->update_at = time();
			$key->save();

			$type = 'success';
			$message = '更新金鑰資料完成';
		}

		$app->flash($type, $message);
	}

	$app->redirect($app->urlFor('key-list'));
});

$app->get('/key/delete/:id', Application_Helper::need_admin(), function($id) use ($app) {
	$key = Model::factory('Key')->find_one($id);

	if ($key === false) {
		$app->flash('error', '刪除出錯,找不到對應的金鑰');
	}else{
		$key->delete();
		$app->flash('success', '刪除金鑰資料完成');
	}

	$app->redirect($app->urlFor('key-list'));
});

$app->get('/key/search', Application_Helper::need_admin(), function() use ($app) {
	$app->render('key/search.html');
});

$app->post('/key/search', Application_Helper::need_admin(), function() use ($app) {
	$code = $app->request()->post('code');
	$lock = $app->request()->post('lock');

	$query_strings = array(
		'code' => $code,
		'lock' => $lock
	);

	$app->redirect($app->urlFor("key-list")."?".http_build_query($query_strings));
});

$app->get('/key/detail/:id', Application_Helper::need_admin(), function($id) use ($app) {
	$key = Model::factory('Key')->find_one($id);

	if ($key === false) {
		$app->flash('error', '更新金鑰出錯,找不到對應的金鑰');
		$app->redirect($app->urlFor('key-list'));
	}else{
		$app->render('key/detail.html', array(
			'key' => $key,
		));
	}
});
?>