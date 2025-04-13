<?php

/* included vendors */
require "vendor/lib/os.php";
require "vendor/lib/router.php";
require "vendor/lib/compress.php";
require "vendor/autoload.php";

/* init whoops errors  */
$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

/* init multi language */
require 'app/vendor/i18n/i18n.class.php';
$i18n = new i18n('app/lang/{LANGUAGE}.json','app/cache/','en');