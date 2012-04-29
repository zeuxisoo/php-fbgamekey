<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/', function() use ($app) {
	$app->render('index/index.html');
})->name('index');

$app->get('/index/gain_key/:user_id/:username/:post_id', function($user_id, $username, $post_id) use ($app) {
	$has_key = Model::factory('Key')->where('facebook_user_id', $user_id)->count();

	// If user have not gained key, then give a key
	if ($has_key <= 0) {
		$keys_total = Model::factory('Key')->where('lock', 0)->limit(5)->count();
		$keys_all   = Model::factory('Key')->where('lock', 0)->limit(5)->find_many();

		if ($keys_total <= 0) {
			$gained_key = '所有金鑰已派發完畢';
		}else{
			// Update the given key detail and lock it
			$key = $keys_all[array_rand($keys_all, 1)];
			$key->facebook_user_id  = $user_id;
			$key->facebook_username = $username;
			$key->facebook_post_id  = $post_id;
			$key->lock              = 1;
			$key->update_at         = time();
			$key->save();

			$gained_key = $key->code;
		}
	}else{
		// If user own a key, then show the key to user
		$gained_key = Model::factory('Key')->where('facebook_user_id', $user_id)->find_one()->code;
	}

	$app->render('index/gain-key.html', array(
		'gained_key' => $gained_key
	));
});
?>