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

                            <li class="b1"><a class="icon view_page" href="<?= port('/adm/news'); ?>">Wiadomości</a></li>
                            <li class="b2"><a class="icon view_page" href="<?= port('/adm/users'); ?>">Futra</a></li>


                        </ul>



                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo port('/users/:login:', array('login' => \yiff\stdlib\Registry::get('user')->getLogin())); ?>"><?php echo \yiff\stdlib\Registry::get('user')->getName(); ?></a></li>
                            <li><a href="<?php echo port('/auth/logout'); ?>">Wyloguj</a></li>
                            <li>/</li>
                            <li><a style="font-weight:bold;" href="<?php echo port('/dodaj-meet'); ?>">+ Dodaj meet</a></li>

                        </ul>



                    </div><!--/.nav-collapse -->
                </div>
            </div>

            <?php
            if (isset($this->actionMenu) && $this->actionMenu instanceof adm\actionMenu) {
                echo '<ul class="breadcrumb">';
                echo $this->actionMenu->render();
                echo '</ul>';
            }
            ?>

            <div class="container">

                <!--div class="starter-template"-->

                <!--h1>Bootstrap starter template</h1-->
                <p class="lead">
                    <?php echo $this->getContent(); ?>
                </p>
                <!--/div-->

            </div><!-- /.container -->
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
        <script>
            $(function() {
                $('.datefield').datepicker({dateFormat: 'yy-mm-dd'});
            });
        </script>
    </body>
</html>
