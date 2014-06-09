<?php

/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-23, 19:19:48
 * 
 * 2014-01-23:
 * -Utworzenie pliku
 */

namespace yiff\db\model;

/**
 * Description of factory
 *
 */
class factory
{

    protected static $tMap = array();

    public static function factory($table)
    {
        if (!isset(self::$tMap[$table])) {
            $reflection = new \ReflectionClass($table);
            $conf = [];
            $classHead = $reflection->getDocComment();
            if (!preg_match('/@yiff-db-table:(.*)/', $classHead, $o)) {
                throw new modelException('Brak info o tabeli');
            }
            $conf['table'] = $o[1];
            if (preg_match('/yiff-db-model:(.*)/', $classHead, $o)) {
                $conf['model'] = $o[1];
            } else {
                $conf['model'] = 'yiff_db_model_abstract';
            }
            self::$tMap[$table] = $conf;
        }
        return self::$tMap[$table];
    }

}
