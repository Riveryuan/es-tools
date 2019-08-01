<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) 2019
 * @license Please see LICENSE
 */

namespace EsTools\modules;

/**
 * Class EsModule
 *
 * @package EsTools\modules
 */
abstract class EsModule
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * EsModule constructor
     */
    public function __construct()
    {
        $enable_config_files = ['UserAgents.php', 'Config.php'];
        $dir_name = dirname(dirname(__FILE__));
        $dir_config = $dir_name . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

        array_map(function ($item) use ($dir_config) {
            $tmp_file = $dir_config . $item;

            if (file_exists($tmp_file)) {
                $config_item = include_once($tmp_file);
                if (is_array($config_item)) {
                    $this->config = array_merge($this->config, $config_item);
                }
            }

            unset($config_item, $tmp_file);

        }, $enable_config_files);

        if (isset($this->config['timezone'])){
            ini_set('date.timezone', $this->config['timezone']);
        }
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
 