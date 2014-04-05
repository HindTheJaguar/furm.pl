<?php
namespace home;
use yiff;
class sessionsController extends controller {
    public function indexAction() {
        $d = yiff\stdlib\Service::get('model_sessions')->fetchByUser(yiff\stdlib\Service::get('access')->getUser());
        $this->view->sessions = $d;
    }
}
