<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2013-08-25, 20:23:29
 */


namespace yiff\stdlib;

class DateTime extends \DateTime
{
    public function getDBValueTZ() {
        return $this->format('c');
    }
    
    public function getDBValue() {
        return $this->format('Y-m-d H:i:s');
    }
    
    /**
     * 
     * @param type $ts
     * @return Datetime
     */
    public static function createFromTimestamp($ts)
    {
        return new self("@$ts");
    }
    
    public function __toString()
    {
        return $this->format('Y-m-d H:i');
    }
}