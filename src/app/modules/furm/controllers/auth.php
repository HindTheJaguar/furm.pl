<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace furm;
use yiff;
use model_users;
use yiff_session_namespace;
use yiff\helpers\msg;
use exception;
class authController extends controller {
    public function  indexAction() {
        
    }

    public function registerAction() {
        $form = new \furm\auth\form\register;
        $this->view->form = $form;
        $this->view->page = 'Rejestracja';
        if (! $this->_request->isPost()) {
            return;
        }
        $session = yiff\stdlib\Service::get('session');
        $form->populate($_REQUEST);
        $values = $form->getValues();
        $users = new model_users;
        try {
            $users->register($values);
            yiff\stdlib\Service::get('msg')->add('Konto zostało dodane', yiff\helpers\msg::E_SUCCESS, true);


            if ($u = $users->findByLogin($form->getValue('login'))) {
                $user = new yiff_session_namespace('_user');
                $user->setData($u->toArray());
                $u->date_last_login = new \yiff\db\expr('now()');
                $u->last_ip = $_SERVER['REMOTE_ADDR'];
                $u->save();
                $session->setUid($u->id);
                $this->_redirect(port('/'));
            }

            $this->view->setFile($this->space.'/'.$this->controller.'/register_ok.php');
        } catch(exception $e) {
            echo $e->sql;
        }
    }

    public function loginAction() {
        if (! yiff\stdlib\Registry::get('user')->isGuest()) {
            header('location: '.port('/'));
            return;
        }
        $session = yiff\stdlib\Service::get('session');
        $this->view->page = "Logowanie";
        $form = new \furm\auth\form\login();
        $this->view->form = $form;
        if (! $this->_request->isPost()) {
            return;
        }

        $form->populate($this->_request->getAllParams());
        $data = $form->getValues();
        
        $users = new model_users;
        $u = $users->findByLogin($data['login']);
        if (!($u && $u->isPasswd($data['passwd']))) {
            yiff\stdlib\Service::get('msg')->add(__('Podane dane są nieprawidłowe', yiff\helpers\msg::E_WRONG));
            return;
        }

        $user = new yiff_session_namespace('_user');
        $user->setData($u->toArray());
        $u->date_last_login = new \yiff\db\expr('now()');
        $u->last_ip = $_SERVER['REMOTE_ADDR'];
        $u->save();
        $session->setUid($u->id);
        yiff\stdlib\Service::get('msg')->add(__('Zostałeś/aś zalogowany'));
        $this->view->user = $u;
        $this->view->setFile('furm/views/auth/loginSuccess.php');
        
        if($this->_getParam('autologin')) {
            setcookie('_FurmAL', session_id(), time()+(3600*24*180), '/');
            $session->setLifetime(3600*24*180);
        }

        header('Refresh: 3; url='. port('/'));

    }

    public function logoutAction() {
        $session = yiff\stdlib\Service::get('session');
        setcookie('_FurmAL','',time()-3600,'/');
        $this->view->page = "Zostałęś/aś wylogowany";
        $session->setLifetime(7200);
        $_SESSION = array();
    }

    public function lostpassAction() {
        $form = new \furm\auth\form\lostpass;
        $this->view->form = $form;
        $this->view->page = 'Przypomnij hasło';
        if (! $this->_request->isPost()) {
            return;
        }
        $form->populate($_REQUEST);
        $u = new model_users;
        if (! $user = $u->findByLogin($form->getValue('login'))) {
            yiff\stdlib\Service::get('msg')->add('Podany login nie istnieje!',yiff\helpers\msg::E_WRONG);
            return;
        }

        $link = port('/auth/changelp',array('old'=>$user->passwd,'uid'=>$user->id,'cs'=>md5($user->passwd.$user->id.date('Ymd'))));
        mail($user->mail, 'Zmiana hasla na stronie furm.pl', <<<EOT
Witaj,
Z adresu IP {$_SERVER['REMOTE_ADDR']} zostala wyslana prosba o zmiane hasla.
Jesli nadal chcesz zmienic haslo przejdz na ponizsza strone.

{$link}

Zespol furm.pl

EOT
                );
        yiff\stdlib\Service::get('msg')->add('Email z linkiem do zmiany hasło został wysłany',yiff\helpers\msg::E_SUCCESS, yiff\helpers\msg::T_FLASH);
        $this->_redirect(port('/'));
    }

    public function changelpAction() {
        $old = $this->_getParam('old');
        $uid = (int) $this->_getParam('uid');
        $cs = $this->_getParam('cs');

        $u = new model_users;
        $user = $u->findOne($uid);
        if ($user->passwd != $old) {
            yiff\stdlib\Service::get('msg')->add('Podany link jest nieprawidłowy', yiff\helpers\msg::E_WRONG, true);
            $this->_redirect(port('/'));
            return;
        }

        $cs1 = md5($old.$uid.date('Ymd'));
        if ($cs != $cs1) {
            $cs1 = md5($old.$uid.(date('Ymd')-1));
        }

        if ($cs != $cs1) {
            yiff\stdlib\Service::get('msg')->add('Podany link jest już wygasły', yiff\helpers\msg::E_WRONG, true);
            $this->_redirect(port('/'));
            return;
        }

        $form = new form;
        $el = new yiff\form\element\passwd('new');
        $el->setLabel('Nowe hasło');
        $form->setElement($el);
        $el = new yiff\form\element\passwd('new2');
        $el->setLabel('Powtórz nowe hasło');
        $form->setElement($el);
        $el = new yiff\form\element\submit('button');
        $el->setLabel('Zmień hasło');
        $el->setIgnore();
        $form->setElement($el);


        $this->view->form = $form;

        if (! $this->_request->isPost()) {
            return;
        }
        $form->populate($_REQUEST);
        $data = $form->toArray();
        if ($data['new'] !== $data['new2'] || strlen($data['new']) < 5) {
            yiff\stdlib\Service::get('msg')->add("Podane hasła różnią się! lub są za krutkie (minimum 6 znaków)!",yiff\helpers\msg::E_WRONG);
            return;
        }

        $user->passwd = $data['new'];
        $user->save();

        yiff\stdlib\Service::get('msg')->add('Możesz się teraz zalogować nowym hasłem', yiff\helpers\msg::E_SUCCESS, true);
        $this->_redirect(port('/auth/login'));
    }
}
