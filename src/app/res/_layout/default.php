<?php echo '<?'; ?>xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo ((isset($this->metaKeywords)) ? $this->metaKeywords . ', ' : ''); ?>furm, furry, meet, furmeet, spotkania" />
        <meta name="description" content="<?php echo ((isset($this->metaDescription)) ? $this->metaDescription : 'furmeety w Polsce'); ?>" />
        <!--link rel="Search" type="application/opensearchdescription+xml" title="furm.pl" href="<?php echo port('/search/osxml') ?>" /-->
        <script type="text/javascript" src="<?php echo HTTP_CDN; ?>jquery-ui-1.10.4.custom/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_CDN; ?>jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_CDN; ?>jquery-ui-1.10.4.custom/development-bundle/ui/i18n/jquery.ui.datepicker-pl.js"></script>
        <title>furm.pl <?php echo ($this->page) ? '| ' . $this->page : ':3'; ?> </title>
        <link rel="stylesheet" href="<?php echo HTTP_RES ?>main.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo HTTP_RES ?>tabs.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo HTTP_CDN ?>jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" type="text/css" media="screen" />

        <?php /* echo $this->render('relcanonical')->render($this->canonical,true); */ ?>
        <script>
            $(function() {
                $('.datefield').datepicker({dateFormat: 'yy-mm-dd'});
            });
        </script>
    </head>
    <body>

        <div id="topCont">
            <div id="topMenu-box">
                <div id="topMenu">
                    <div style="float:right;">
                        <ul class="menu">
                            <?php if (!\yiff\stdlib\Registry::get('user')->isGuest()): ?>
                                <li><a href="<?php echo port('/users/:login:', array('login' => \yiff\stdlib\Registry::get('user')->getLogin())); ?>"><?php echo \yiff\stdlib\Registry::get('user')->getName(); ?></a></li>
                                <li><a href="<?php echo port('/auth/logout'); ?>">Wyloguj</a></li>
                                <li>/</li>
                                <li><a style="font-weight:bold;" href="<?php echo port('/dodaj-meet'); ?>">+ Dodaj meet</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo port('/auth/login'); ?>" onclick="var el = document.getElementById('small-login-form');
                                            if (el.style.display == 'block') {
                                                el.style.display = 'none';
                                            } else {
                                                el.style.display = 'block';
                                            }
                                            ;
                                            return false;">Zaloguj się</a></li>
                                <li>/</li>
                                <li><a href="<?php echo port('/auth/register'); ?>">Zarejestruj się</a></li>
                            <?php endif; ?>
                        </ul>
                        <?php if (\yiff\stdlib\Registry::get('user')->isGuest()): ?>
                            <div id="small-login-form" style="display:none; background:white; padding: 10px; opacity:0.9; -moz-border-radius: 0 0 10px 10px;">
                                <form method="post" action="<?php echo port('/auth/login'); ?>">
                                    Login:<br />
                                    <input name="login" type="text" /><br />
                                        Hasło:<br />
                                        <input name="passwd" type="password" /><br />
                                        <input type="checkbox" name="autologin" value="1" /> Zapamiętaj mnie<br />
                                        <input type=hidden name="back" value="<?php echo port(); ?>" />
                                        <input type="submit" value="Zaloguj się" />
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <b style="font-size:20px;">furm.pl :3</b>
                </div>
            </div>
            <div id="top"></div>
        </div>
        <div style="width:900px;margin:auto;">
            <ul class="menu">
                <li><a href="<?php echo port('/'); ?>">Strona główna</a></li>
                <?php if (!\yiff\stdlib\Registry::get('user')->isGuest()): ?>
                    <li><a href="<?php echo port('/browse/meet'); ?>">Zobacz wszystkie meety</a></li>
                    <li><a href="<?php echo port('/browse/users'); ?>">Futra</a></li>
                <?php endif; ?>
                <li><a href="<?php echo port('/meets/news'); ?>">Wiadomości</a></li>
                <li><a href="<?php echo port('/forum'); ?>">Forum</a></li>
                <li><a href="<?php echo port('/calendar'); ?>">Kalendarz</a></li>
                <li><a href="<?php echo port('/planeta'); ?>">Planeta</a></li>

<!--li><a href="<?php echo port('/blog'); ?>">Blog</a></li-->
<!--<li><a href="<?php echo port('/chat'); ?>">Chat</a></li>-->
<!--<li><a href="<?php echo port('/commission'); ?>">Commissions</a></li>-->
            </ul>


            <div id="content">
                <?php
                yiff\stdlib\Service::get('session');
                echo yiff\stdlib\Service::get('msg')->show();
                ?>
                <?php echo $this->getContent(); ?>
            </div>
        </div>
        <div id="footer" style="margin-top:10px">
            <div>
                <br/>
                <div style="margin:auto;width:900px;text-align:left;">
                    <div style="float:left;width:450px;text-align:left;">
                        Strona ma za zadanie zbierać informacjie o nadchodzących meetach.
                        Jednak iż jest w fazie testów, mogą występować różne problemy, które prosiłbym o zgłaszanie. Wszelkie nieprawidłowości, sugestie i błedy proszę zgłaszać na <a href="<?php echo port('/forum'); ?>">forum</a>
                    </div>
                    <div style="width:150px;float:left;padding-left:30px;">
                        <ul>
                            <li><a href="<?php echo port('/regulamin'); ?>">Regulamin</a></li>
                            <li><a href="<?php echo port('/doc/show/:name:', array('name' => 'web_api')); ?>">API</a></li>
                            <!--li><a href="<?php echo port('/blog'); ?>">Blog</a></li-->
                            <!--<li><a href="<?php echo port('/sitemap'); ?>">Mapa strony</a></li>-->
                            <li><a href="<?php echo port('/home'); ?>">Profil</a></li>
                        </ul>
                    </div>

                    <div style="width:150px;float:left;padding-left:30px;">
                        <ul>
                            <li><a href="<?php echo port('/dodaj-meet'); ?>">Dodaj meet</a></li>
                            <!--<li><a href="<?php echo port('/commission.add'); ?>">Dodaj commission</a></li>-->
                            <li>&nbsp;</li>
                            <li><a href="<?php echo port('/browse/meet'); ?>">Przeglądaj meety</a></li>
                            <li><a href="<?php echo port('/calendar'); ?>">Kalendarz</a></li>
                        </ul>
                    </div>


                    <div style="clear:both"></div>        <br/>
                    furm.pl 2010, <a href="<?php echo port('/regulamin'); ?>">Regulamin korzystania ze strony</a>, Podziękowania dla Wilczycy Jiry za zaprojektowanie grafiki,<br> Wspomóż DOGE:&nbsp;DT6uoUR2KyeoHLBorvvButQibHbrhSq4EF
                </div>


            </div>

        </div>

        <div id="seo">furry, furmeet, meet, polska, furries, poland, futrzaki, spotkania, furr</div>

        <?php
        if (!IS_PRODUCTION) {
            yiff\helpers\dump::dump(microtime(1) - SCRIPT_START_TIME);
            $p = yiff\stdlib\Service::get('db')->profiler;
            yiff\helpers\dump::dump($p);
        }
        ?>
    </body>
</html>
