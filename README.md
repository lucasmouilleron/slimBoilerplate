slimBoilerplate
===============

Slim is a lightweight but powerfull API Rest PHP framework.

Features
--------
- A nice slim boilerplate
- Stack : slim, php, SimpleCache, JWT authentication
- Build : install, build, watch, grunt, bower

Install requirements
--------------------
- Install NodeJS : http://nodejs.org/download
- `sudo npm install bower -g`
- `sudo npm install grunt -g`
- `sudo gem install sass`
- `sudo gem install --pre sass-css-importer`
- Install composer :
    - `curl -sS https://getcomposer.org/installer | php`
    - `mv composer.phar /usr/local/bin/composer`

Install
-------
- `cd api && composer install`
- `cd build && npm install`

Run and tests
-------------
- little JS app at `index.php` and `_dev/js`
- php requests at `test.php`

TODO
----
- edit `api/libs/JWTAuthenticationMiddleware.php` > `JWTAuthenticationMiddleware->doLogin` to add login logic

Credits
-------
Thanks to guys at [Slim](http://www.slimframework.com)