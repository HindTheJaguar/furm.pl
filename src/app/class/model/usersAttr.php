<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */

class model_usersAttr extends yiff_db_model_abstract {
    protected $_name = 'users_attr';
    protected $_primary = array('user_id','attr_id');
    protected $_sequence = false;

    public function multiUpdate(array $data) {
        foreach ($data as $v) {
            if (! is_array($v)) {
                throw new exception('not array');
            }
            try {
                $r = $this->findOne(array('user_id'=>$v['user_id'],'attr_id'=>$v['attr_id']));
                $r->value = $v['value'];
            } catch (\yiff\stdlib\NoFound $e) {
                $r = $this->create($v);
            }
            $r->save();
        }
    }
}