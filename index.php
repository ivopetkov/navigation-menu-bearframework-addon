<?php

/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

use \BearFramework\App;

$app = App::get();
$context = $app->getContext(__FILE__);

$context->assets->addDir('assets');

$app->components->addAlias('navigation-menu', 'file:' . $context->dir . '/components/navigationMenu.php');
