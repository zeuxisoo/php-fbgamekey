<?php
if (defined("IN_APPS") === false) exit("Access Dead");

class Application_Helper {
	public static function need_admin() {
		return array('Permission', 'need_admin');
	}
}
?>