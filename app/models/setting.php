<?php
if (defined("IN_APPS") === false) exit("Access Dead");

class Setting extends Model {
	public static $_id_column = 'name';
	public static $_table = 'setting';
}
?>