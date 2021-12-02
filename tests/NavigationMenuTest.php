<?php

/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class NavigationMenuTest extends BearFramework\AddonTests\PHPUnitTestCase
{

    /**
     * 
     */
    public function testOutput()
    {
        $app = $this->getApp();

        $result = $app->components->process('<component src="navigation-menu">'
            . '<ul>'
            . '<li><a>Button 1</a></li>'
            . '<li><a>Button 2</a>'
            . '<ul>'
            . '<li><a>Button 2.1</a></li>'
            . '<li><a>Button 2.2</a></li>'
            . '<li><a>Button 2.3</a></li>'
            . '</ul>'
            . '</li>'
            . '<li><a>Button 3</a></li>'
            . '</ul>'
            . '</component>');
        $this->assertTrue(strpos($result, '<li><a>Button 2.2</a></li>') !== false);
    }
}
