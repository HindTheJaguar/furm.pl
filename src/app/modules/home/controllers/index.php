<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace home;
use furm\controller;
use yiff;
use model_users;
use furm;

class indexController extends controller {
    public function indexAction() {
        if (! uid()) {
            throw new yiff\stdlib\Restricted;
        }
        $this->view->page = 'Dane podstawowe';
        $users = new model_users;
        $u = $users->findOne(uid());
        if ($this->_request->isPost()) {
            $a = $_REQUEST['user'];
            $u->name = $a['name'];
            $u->mail = $a['mail'];
            $flg =(int) $u->flags;

            
            if ($a['public_profile']) {
                $flg = $flg & ~ model_users::FLAG_HIDE_PROFILE;
            } else {
                $flg = $flg | model_users::FLAG_HIDE_PROFILE;
            }
            
            if ($a['show_mail']) {
                $flg = $flg & ~ model_users::FLAG_HIDE_MAIL;
            } else {
                $flg = $flg | model_users::FLAG_HIDE_MAIL;
            }
            
            $u->flags = $flg;


            yiff\stdlib\Service::get('msg')->add('Nowe dane zostały zapisane');
            if (!empty($a['old_pass']) && ! empty($a['new_pass']) && $a['new_pass'] === $a['new_pass2']) {
                $u->passwd = $a['new_pass'];
                yiff\stdlib\Service::get('msg')->add('Hasło zostało zmienione');
            }
            $u->save();


        }


        
        $flags = $users->decode_flags($u->flags);
        $this->view->user = $u;
        $this->view->show_mail = ! in_array('hide_mail', $flags);
        $this->view->public_profile = ! in_array('hide_profile', $flags);
    }
}
