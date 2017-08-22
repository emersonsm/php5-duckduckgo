<?php

namespace DuckDuckGo;

class Misc
{
    /**
     * Path of config.php file
     * 
     * @var string
     */
    private $configPath;

    /**
     * DuckDuckGo Misc constructor.
     */
    public function __construct()
    {
        $this->configPath = realpath(__DIR__ . '/../../config.php');
    }

    /**
     * Retrieve information of config.php file based on key parameter.
     * 
     * @param string $key
     * @return string|bool
     */
    public function getConfig($key)
    {
        $config = require($this->configPath);
        return (isset($config[$key])) ? $config[$key] : false;
    }
}