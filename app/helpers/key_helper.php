<?php
if (defined("IN_APPS") === false) exit("Access Dead");

class Key_Helper extends Application_Helper {
	public static function key_list_per_page() {
		return 12;
	}
}
?>