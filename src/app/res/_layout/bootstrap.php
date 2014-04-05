<?php
/**
 * System EKL
 * 
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2014-01-29, 07:38:44
 * 
 * 2014-01-29:
 * -Utworzenie pliku
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>furm.pl <?php echo ($this->page) ? '| ' . $this->page : ':3'; ?> </title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo HTTP_CDN; ?>bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo HTTP_CDN; ?>starter-template.css" rel="stylesheet">
        

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div id="wrap">
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo port('/'); ?>">furm.pl :3</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <!--li><a href="<?php echo port('/'); ?>">Strona główna</a></li-->
                            <?php if (!\yiff\stdlib\Registry::get('user')->isGuest()): ?>
                                <li><a href="<?php echo port('/browse/meet'); ?>">Zobacz wszystkie meety</a></li>
                                <li><a href="<?php echo port('/browse/users'); ?>">Futra</a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo port('/meets/news'); ?>">Wiadomości</a></li>
                            <li><a href="<?php echo port('/forum'); ?>">Forum</a></li>
                            <li><a href="<?php echo port('/calendar'); ?>">Kalendarz</a></li>
                            <li><a href="<?php echo port('/planeta'); ?>">Planeta</a></li>
                        </ul>



                        <ul class="nav navbar-nav navbar-right">
                            <?php if (!\yiff\stdlib\Registry::get('user')->isGuest()): ?>
                                <li><a href="<?php echo port('/users/:login:', array('login' => \yiff\stdlib\Registry::get('user')->getLogin())); ?>"><?php echo \yiff\stdlib\Registry::get('user')->getName(); ?></a></li>
                                <li><a href="<?php echo port('/auth/logout'); ?>">Wyloguj</a></li>
                                <li>/</li>
                                <li><a style="font-weight:bold;" href="<?php echo port('/dodaj-meet'); ?>">+ Dodaj meet</a></li>
                            <?php else: ?>
                                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo port('/auth/login'); ?>">Zaloguj się</a>
                                    <div class="dropdown-menu" style="width:200px">
                                        <form role="form" class="navbar-form navbar-right" method="post" action="<?php echo port('/auth/login'); ?>">
                                            <input type="hidden" name="autologin" value="1" />
                                            <input type="hidden" name="back" value="<?php echo port(); ?>" />
                                            <div class="form-group">
                                                <input type="text" name="login" class="form-control" placeholder="Login">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="passwd" class="form-control" placeholder="Hasło">
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="autologin" value="1" /> Zapamiętaj mnie
                                            </div>
                                            <button class="btn btn-warning" type="submit">Zaloguj</button>
                                        </form>
                                    </div>
                                </li>

                                <li><a href="<?php echo port('/auth/register'); ?>">Zarejestruj się</a></li>
                            <?php endif; ?>
                        </ul>



                    </div><!--/.nav-collapse -->
                </div>
            </div>

            <div id="topCont">
                <div id="top"></div>   
            </div>

            <div class="container">

                <!--div class="starter-template"-->

                <!--h1>Bootstrap starter template</h1-->
                <p class="lead">
                    <?php echo $this->getContent(); ?>
                </p>
                <!--/div-->

            </div><!-- /.container -->
        </div>
        <div id="footer" _style="margin-top:10px">
            <div class="container">
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


                    <div style="clear:both"></div>
                    furm.pl 2010, 
                    <a href="<?php echo port('/regulamin'); ?>">Regulamin korzystania ze strony</a>, 
                    Podziękowania dla Wilczycy Jiry za zaprojektowanie grafiki,<br> 
                    Wspomóż DOGE:&nbsp;DT6uoUR2KyeoHLBorvvButQibHbrhSq4EF
                </div>

            </div>

        </div>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script type="text/javascript" src="<?php echo HTTP_CDN; ?>jquery-ui-1.10.4.custom/js/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_CDN; ?>jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo HTTP_CDN; ?>jquery-ui-1.10.4.custom/development-bundle/ui/i18n/jquery.ui.datepicker-pl.js"></script>
        <!--link rel="stylesheet" href="<?php echo HTTP_RES ?>main.css" type="text/css" media="screen" /-->
        <link rel="stylesheet" href="<?php echo HTTP_RES ?>tabs.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo HTTP_CDN ?>jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" type="text/css" media="screen" />
        <script src="<?php echo HTTP_CDN; ?>bootstrap/js/bootstrap.min.js"></script>
        
        
        
    
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_CDN; ?>bootstrap3-wysihtml5/src/bootstrap-wysihtml5.css" />
    <script src="<?php echo HTTP_CDN; ?>bootstrap3-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    
    <script src="<?php echo HTTP_CDN; ?>bootstrap3-wysihtml5/src/bootstrap3-wysihtml5.js"></script>
    

        <script>
            $(function() {
                $('.datefield').datepicker({dateFormat: 'yy-mm-dd'});
                $('textarea.wysiwyg').wysihtml5();
            });
        </script>
    </body>
</html>
