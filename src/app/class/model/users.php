<?php
/**
 * @yiff-registry:users_repository
 */
class model_users extends yiff_db_model_abstract {
    protected $_name = 'users';
    protected $_primary = 'id';
    protected $_rowClass = 'model_users_entity';
    public $flags = array(
        0=>'none',
        2=>'hide_mail',
        1=>'hide_profile',
    );
    
    const FLAG_HIDE_MAIL = 2;
    const FLAG_HIDE_PROFILE = 1;
    
    protected $_resolv_cache = [];
    
    public function register($data) {
        $errors = array();
        //Array ( [login] => hind [passwd] => hind [passwd2] => hind [mail] => hind@hind.pl [name] => Hind )
        if ($data['passwd'] === $data['passwd2']) {
            unset($data['passwd2']);
        } else {
            $errors['passwd'] = __('Hasła są różne');
        }
        
        $data['passwd'] = $this->passwd($data['passwd']);
        if($this->findByLogin($data['login'])) {
            $erros['login'] = __('Podany login jest już zarejestrowany');
        }

        if ($errors === array()) {

            $this->_db->insert($this->_name, $data);
            return true;
        }
        return $errors;
    }

    public function findByLogin($login) {
        return $this->fetchRow(array("login = ?"=>$login));
    }
    
    public function getCurrnet(\yiff\auth\User $access) {
        $u = $access->getUid();
        return $this->findOne($u);
    }

    public function decode_flags($flg) {
        $ret = array();
        foreach($this->flags as $k=>$v) {
            if ($flg&$k) {
                $ret[$k]=$v;
            }
        }
        return $ret;
    }
    
    public function passwd($pass) {
        return sha1($pass);
    }
    
    public function resolv($id)
    {
        if (! isset($this->_resolv_cache[$id]))
        {
            $user = $this->findOne($id);
            $this->_resolv_cache[$id] = '<a href="'.$user->getUrl().'">'.$user.'</a>';
        }
        
        return $this->_resolv_cache[$id];
        
    }
}
