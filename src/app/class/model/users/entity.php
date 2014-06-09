<?php

//use home;

/**
 * @yiff-db-table:users
 * @yiff-db-model:model_users
 */
class model_users_entity extends yiff_db_model_abstract_entity
{

    use \furm\common\user\actions;

    public $_flags = array();

    public function init()
    {
        $f = $this->flags;
        foreach ($this->_model->flags as $k => $v) {
            if ($f & $k) {
                $this->_flags[$k] = $v;
            }
        }
    }

    public function hasFlag($name)
    {
        return isset($this->_flags[$name]);
    }

    public function __setPasswd($value)
    {
        return sha1($value);
    }

    public function isPasswd($value)
    {
        if (sha1($value) === $this->passwd) {
            return true;
        }

        if ($value === $this->passwd) {
            $this->passwd = sha1($this->passwd);
            $this->save();
            return true;
        }
//        return (sha1($value) === $this->passwd || $value === $this->passwd);
    }

    public function __toString()
    {
        return $this->name;
    }
    
    public function isMyFriend($uid)
    {
        if(home\model\friends::model()->fetchRow([
            'user_id = ?'=>$uid,
            'friend_id = ?'=>$this->id,
        ])) {
            return true;
        }
    }

}
