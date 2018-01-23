<?php

class Gallery_GalleryController extends Zend_Controller_Action
{
    /**
     * @var Hsp_Board
     */
    protected $_board;

    /* (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
    public function init()
    {
        $this->_board = Hsp_System::getInstance()->getPackage('board');
    }
    
    /**
     * 
     */
    public function totalListAction() {
        
    }
}

