<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
 namespace furm;
 use model_meets;
 use yiff;
 use model_meetComments;
\yiff\view\layout::getInstance()->disable(true);
class linkController extends \yiff\application\controller {
    public function idAction() {
    
        $m = new model_meets;
        if(!$meet = $m->findOne($this->_request->getParam(0))) {
            throw new yiff\stdlib\NoFound;
        }
        if ($this->_request->getParam(1) == 'top') {
            $mc = new model_meetComments;
            $cnt = $mc->countByMeet($meet);

            echo <<<EOT
<html>
    <head>
        <style>
            * {
                margin:0;
                padding:0;
                font-family:Tahoma, Verdana, Sans-Serif;
            }
            body {
                background: url(/page/furm/top-bg.png);
            }
            #title {
                height:24px;
                border-right:1px dotted black;
                margin-right:2px;
                padding-right:2px;
            }

        </style>
    </head>
    <body>
        <table style="width:100%;">
            <colgroup>
                <col style="width:200px;"/>
                <col />
                <col style="width:20px"/>
            </colgroup>
            <tr>
                <td style="border-right: 1px dotted black">
                    <h1 style="font-weight:22px;"><a style="border:none;text-decoration:none;color:black;" target=_top href="http://furm.pl">furm.pl :3</a></h1>
                </td>
                <td>
                    <a style="font-size:20px; color:black;" href="{$meet->getUrl()}" target=_top><h2 style="font-size:20px;">{$meet->name}</h2></a>
                    <a style="font-size:11px;" href="{$meet->getUrl()}#comments" target=_top>Komentarze ({$cnt})</a>
                </td>
                <td>
                    [<a href="{$meet->info_url}" style="color:black; font-weight:bold; text-decoration:none;" target=_top>x</a>]
                </td>
           </tr>
       </table>

    </body>
</html>
EOT;
            return;
        }

        $url = port('/link/id/:id:/top',array('id'=>$meet->id));
        echo <<<EOT
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
	<meta name="Description" content="Opis zawartości strony" />
	<meta name="Keywords" content="Wyrazy kluczowe" />
	<meta name="Author" content="Autor strony" />
    <title>furm.pl | {$meet->name}</title>
</head>
<frameset rows="44,*" border="0" frameborder="0" framespacing="0">
  <frame name="top" noresize="noresize" frameborder="0" src="{$url}" />
  <frame name="strona" noresize="noresize" frameborder="0" src="{$meet->info_url}" />
  <noframes><body><a href="{$meet->info_url}">Przejdź do strony meetu</a></body></noframes>
</frameset>
</html>
EOT;

    }
}
