### Install

	chmod 777 cache/views
	chmod 777 log
	mv config/common.php.sample config/common.php
	mv config/database.php.sample config/database.php

# Development

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