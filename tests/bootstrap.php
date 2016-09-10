<?php

/*
 * Navigation menu addon for Bear Framework
 * https://github.com/ivopetkov/navigation-menu-bearframework-addon
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */


require __DIR__ . '/../vendor/autoload.php';

/**
 * 
 */
class BearFrameworkAddonTestCase extends PHPUnit_Framework_TestCase
{

    private $app = null;

    function getTestDir()
    {
        return sys_get_temp_dir() . '/unittests/' . uniqid() . '/';
    }

    function getApp($config = [], $createNew = false)
    {
        if ($this->app == null || $createNew) {
            $rootDir = $this->getTestDir();
            $this->app = new BearFramework\App();
            $this->app->filesystem->makeDir($rootDir . 'app/');
            $this->app->filesystem->makeDir($rootDir . 'data/');
            $this->app->filesystem->makeDir($rootDir . 'logs/');
            $this->app->filesystem->makeDir($rootDir . 'addons/');

            $initialConfig = [
                'appDir' => $rootDir . 'app/',
                'dataDir' => $rootDir . 'data/',
                'logsDir' => $rootDir . 'logs/',
                'addonsDir' => realpath($rootDir . 'addons/')
            ];
            $config = array_merge($initialConfig, $config);
            foreach ($config as $key => $value) {
                $this->app->config->$key = $value;
            }

            $this->app->initialize();
            $this->app->request->base = 'http://example.com/www';
            $this->app->request->method = 'GET';

            $this->app->addons->add('ivopetkov/navigation-menu-bearframework-addon');
        }

        return $this->app;
    }

    function createDir($dir)
    {
        $this->app->filesystem->makeDir($dir);
    }

    function createFile($filename, $content)
    {
        $this->app->filesystem->makeFileDir($filename);
        file_put_contents($filename, $content);
    }

}
