<?php
/**
 * @author Eric Shi <wwolf5566@outlook.com>
 * @copyright Copyright (c) 2019
 * @license Please see LICENSE
 */

namespace EsTools;

/**
 * Class Es
 *
 * @package EsTools
 */
class Es
{
    /**
     * Create instance of hole class
     *
     * @param $className
     * @return bool
     */
    static public function getInstance($className)
    {
        $class_prefix = 'Es';
        $class_full = 'EsTools\\modules\\' . $class_prefix . ucfirst($className);

        if (class_exists($class_full)) {
            return new $class_full();
        }

        return false;
    }

}
 