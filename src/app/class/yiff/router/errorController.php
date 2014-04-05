<?php

/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
namespace yiff\router;
use yiff;
class errorController
{

    /**
     *
     * @var exception
     */
    public $e;

    /**
     * @var bootstrap
     */
    public $app;

    public function setError(\Exception $e)
    {
        $this->e = $e;
    }

    public function setApp($a)
    {
        $this->app = $a;
    }

    public function dispatch()
    {
        if ($this->e instanceof yiff\stdlib\NoFound || $this->e->getCode() == 404) {
            $this->e404();
            return;
        }

        if ($this->e instanceof yiff\stdlib\Restricted || $this->e->getCode() == 403) {
            $this->e403();
            return;
        }

        $this->e500();
    }

    public function e404()
    {
        header('Content-Type: text/html; charset=urf8');
        echo '<html>
            <head><title>404 - File no found</title>
            </head>
            <body>
            Poszukiwana strona nie istnieje. <br>
            <a href="' . port('/') . '">Proszę przejść na stronę główną</a>
            </body>
</html>
';
    }

    public function e403()
    {
        yiff\stdlib\Registry::get('msg')->add('Podana strona wymaga zalogowania się!', yiff\helpers\msg::E_NOTICE, true);
        header('Location: ' . port('/auth/login'));
        die();
    }

    public function e500()
    {
//        header('content-type: text/plain');
        echo '500 - Wystąpił błąd wewnętrzny!';
        echo '<pre>';
        echo $this->e;
        echo '</pre>';
    }

}
