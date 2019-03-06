<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) ${YEAR}
 * @license Please see LICENSE
 */

namespace EsTools\lib;

/**
 * Class EsBase
 *
 * @package EsTools\lib
 */
class EsBase
{
    /**
     * Config items
     *
     * @var array
     */
    protected $config = [];

    /**
     * EsBase constructor.
     */
    public function __construct()
    {
        $dir_name = dirname(dirname(__FILE__));
        $file = $dir_name . DIRECTORY_SEPARATOR . 'config/UserAgents.php';
        $user_agents = include_once $file;

        $this->config = array_merge($this->config, $user_agents);
    }
}
 