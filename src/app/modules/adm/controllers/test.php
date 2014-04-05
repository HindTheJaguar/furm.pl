<?php

/**
 *
 * @author Przemysław 'Hind' Jakubowski <hind@hind.pl>
 * @date 2012-08-28, 20:51:08
 */


class adm_testController extends adm\controller {
    public function indexAction() {
        $c = new yiff_ac_codegen('test');
        $c->add(new yiff_ac_codegen_const('T','val'));
        $c->add(new yiff_ac_codegen_const('TD','val2'));
        $c->add(new yiff_ac_codegen_property('me',array('value'=>'xxx')));
        $c->add(new yiff_ac_codegen_method('__construct',['params'=>['test'=>'xxx'],'code'=>'$this->test = $test']));
        $c->extends = 'yiff_base';
        $c->implements = ['Countable'];
        echo '<pre>';
        echo str_replace('<', '&lt',$c);
        echo '</pre>';
    }
}