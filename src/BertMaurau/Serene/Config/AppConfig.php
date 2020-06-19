<?php

namespace BertMaurau\Serene\Config;

use Exception;

/**
 * Description of AppConfig
 *
 * @author bertmaurau
 */
class AppConfig
{

    /**
     * The configuration file
     * @var string $file
     */
    private static $file;

    /**
     * The loaded App Configuration
     * @var array $appConfig
     */
    private static $appConfig;

    /**
     * Load the requested configuration file
     * @param string $file The file to load (eg. /app/config.json)
     * @param bool $reload Reload the configuration from file
     * @return \BertMaurau\Serene\Config\Config
     * @throws Exception
     */
    public static function load(string $file = 'config.json', bool $reload = false)
    {
        // check if configuration has been loaded already
        if (self::$appConfig && !$reload) {
            //
        }

        // check if file exists
        if (!file_exists($file)) {
            throw new Exception("Config file: `$file` not found.");
        }

        // load file (which should populate the appConfig variable
        $json = file_get_contents($file);
        try {
            $appConfig = json_decode($json, true);
        } catch (Exception $ex) {
            throw new Exception("Failed to parse file: {$ex -> getMessage()}");
        }

        // assign to self
        self::$file = $file;
        self::$appConfig = $appConfig;
    }

    /**
     * Reload the current configuration from file
     * @return \BertMaurau\Serene\Config\Config
     * @throws Exception
     */
    public static function reload()
    {
        if (!self::$file) {
            throw new Exception("No configuration loaded.");
        }

        self::load(self::$file, true);
    }

    /**
     * Save the current configuration to file
     * @return bool Saved successfully
     */
    public static function save()
    {
        return file_put_contents(self::$file, json_encode(self::$appConfig));
    }

    /**
     * Get the value for given setting
     * @param string $setting The setting to get
     * @return mixed The setting's value
     * @throws Exception
     */
    public static function setting(string $setting)
    {
        // check if loaded
        if (!self::$appConfig) {
            throw new Exception("Config not loaded.");
        }

        // split $setting
        $tree = explode('.', $setting);

        // set the initial node
        $currentNode = self::$appConfig;

        $nodeString = 'AppConfig';

        // travert the nested settings
        foreach ($tree as $item) {

            $nodeString .= ' > ' . $item;

            // check if next level node is set in current node
            if (!isset($currentNode[$item])) {
                throw new Exception("Unknown settings-node: $nodeString.");
            } else {
                // set the current node
                $currentNode = $currentNode[$item];
            }
        }

        // the current node should be the actual setting
        return $currentNode['value'];
    }

}
