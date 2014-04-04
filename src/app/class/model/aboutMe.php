<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_aboutMe {
    static protected $table = array(
        array('id'=>'1' ,'name'=>'Profil DA','type'=>'string'),
        array('id'=>'2' ,'name'=>'Profil FA','type'=>'string'),
        array('id'=>'3' ,'name'=>'Profil YouTube'),
        array('id'=>'4' ,'name'=>'Profil SoFurry'),
        array('id'=>'5' ,'name'=>'Profil InkBunny'),
        array('id'=>'6' ,'name'=>'Gadu-Gadu','type'=>'num'),
        array('id'=>'7' ,'name'=>'Jabber'),
        array('id'=>'8' ,'name'=>'GTalk'),
        array('id'=>'9' ,'name'=>'Skype'),
        array('id'=>'10' ,'name'=>'Gatunek'),
        array('id'=>'11' ,'name'=>'Miasto'),
        array('id'=>'12' ,'name'=>'Rok urodzenia','type'=>'num'),

    );
    public function fetchOne($id) {
        foreach(self::$table as $v) {
            if ($v['id'] === $id) {
                return (object) $v;
            }
        }
    }

    public function crossData(Traversable $data) {
        $d = array();
        foreach($data as $v) {
            $d[$v->attr_id] = $v->value;
        }

        $d2=array();//self::$table;
        foreach (self::$table as $k=>$v) {
            $d2[$k] = (object) $v;
            $d2[$k]->value = ((isset($d[$v['id']]))?$d[$v['id']]:'');
        }
        return $d2;
    }
}