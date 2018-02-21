<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->redirect('/board_board/list/boardPk/0');
    }

    public function indexAction()
    {
    }
    
}

