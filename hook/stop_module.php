<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->hook('slim.before.dispatch', function () use ($app) {
	$current_module = substr($app->request()->getResourceUri(), 1);
	$target_module  = array('account/?.*', 'key/search', 'setting/?.*');

	foreach($target_module as $module_rule) {
		if (preg_match('#'.$module_rule.'#i', $current_module) == true) {
			$app->notFound();
		}
	}
});
?>