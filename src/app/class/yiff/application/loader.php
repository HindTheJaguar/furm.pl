<?php

/**
 * Klasa wczytująca klasy
 * 
 * @author pjak
 * @date 2010-10-14
 */

namespace yiff\application;

class loader
{
    
    public static function register()
    {
        spl_autoload_register('yiff\\application\\loader::basic');
    }

    /**
     * domyślny loader klass (zarejstrowany przez jako __autoload())
     * 
     * @param string $className
     */
    public static function basic($className)
    {
        $className = ltrim($className, '\\');
        if ($mod = self::module($className)) {
            if (realpath(\CORE_DIR . \DIRECTORY_SEPARATOR . $mod)) {
                require \CORE_DIR . \DIRECTORY_SEPARATOR . $mod;
                return;
            }
        }
        self::basic_lagency($className);
    }

    public static function basic_lagency($className)
    {
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', \DIRECTORY_SEPARATOR, $namespace) . \DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', \DIRECTORY_SEPARATOR, $className) . '.php';

        require CORE_DIR . '/class/' . $fileName;
    }

    public static function module($className)
    {
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $firstNsPos = strpos($className, '\\');
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            if ($lastNsPos == $firstNsPos) {
                $namespace = "modules\\" . $namespace . '\\class';
            } else {
                $c = substr($namespace, $firstNsPos + 1);
                $c2 = substr($namespace, 0, $firstNsPos);

                $namespace = "modules\\$c2\\class\\$c";
            }
            $fileName = str_replace('\\', \DIRECTORY_SEPARATOR, $namespace) . \DIRECTORY_SEPARATOR;
        } else {
            return false;
        }
        $fileName .= str_replace('_', \DIRECTORY_SEPARATOR, $className) . '.php';
        return $fileName;
    }

}
