<?php

/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use \BearFramework\App;

$app = App::get();
$context = $app->contexts->get(__DIR__);


$app->clientPackages
    ->add('-ivopetkov-navigation-menu', function (IvoPetkov\BearFrameworkAddons\ClientPackage $package) use ($context): void {
        //$package->addJSCode(file_get_contents($context->dir . '/dev/navigationMenu.js'));
        $package->addJSCode(include $context->dir . '/assets/navigationMenu.min.js.php');
        $package->get = 'return ivoPetkov.bearFrameworkAddons.navigationMenu;';
    });

$app->components
    ->addAlias('navigation-menu', 'file:' . $context->dir . '/components/navigationMenu.php');
