### Install

	chmod 777 cache/views
	chmod 777 log
	mv config/common.php.sample config/common.php
	mv config/database.php.sample config/database.php

### Configure

	open db/20120921140700-fb_app_gamekey.sql
	replace the 1234567891011121 to your APP_ID
	import db/*.sql into database

	login into http://your/site/url/panel (admin / 12345678)

### Development

	gem install guard
	guard init livereload
	guard

	npm install -g coffee-script
	coffee -o public/javascripts -w -c public/coffeescripts/

	gem install compass
	compass create --sass-dir "public/scss" --css-dir "public/stylesheets" --javascripts-dir "public/javascripts" --images-dir "public/images"
	compass watch

### License

	The BSD 2-Clause License