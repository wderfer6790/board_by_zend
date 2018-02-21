<?php

class Board_ConfigController extends Zend_Controller_Action
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
    public function indexAction() {
        $addForm = new Zend_Form(array(
    		'name' => 'addForm',
    		'method' => Zend_Form::METHOD_POST,
            'class' => 'form-inline'
        ));
        $addForm->setDecorators(array(
    		'FormElements',
    		'Form',
        ));
        $addForm->setElementDecorators(array(
    		'ViewHelper',
    		array('Label', array('separator' => " ")),
    		array('HtmlTag', array('tag' => 'div', 'class' => 'form-group col-xs-3 ')),
        ));
        $addForm->addElement("text", "name", array("label" => "게시판명", "class" => "form-control input-sm name", "maxlength" => "16"));
        $addForm->getElement("name")->getDecorator("HtmlTag")->setOption("class", "form-group col-xs-5");
        $addForm->addElement("text", "ordered", array("label" => "정렬순서", "class" => "form-control input-sm ordered"));

        $addForm->addElement("submit", "addButton", array("label" => "추가", "class" => "btn btn-sm"));
        $addForm->getElement("addButton")->removeDecorator('Label')->removeDecorator('HtmlTag');
        
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $this->_board->addBoard($data);
            $this->view->message = "추가되었습니다.";
        }
        
        $this->view->addForm = $addForm;
        $this->view->boards = $this->_board->getBoards();
        $this->view->boardList = array(null => "선택하세요.");
        foreach ($this->view->boards as $row) {
            $this->view->boardList[$row->pk] = $row->name;
        }
    }
    
    /**
     * 
     */
    public function boardEditAction() {
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $result = array("result" => false, "message" => "");
            try {
                $data = $this->getRequest()->getParams();
                
                $boardRow = $this->_board->getBoard($data['pk']);
                $boardRow->setFromArray($data);
                $boardRow->save();
                
                $result['result'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }            
            
            $this->_helper->json->sendJson($result);
        }
    }
    
    /**
     * 
     */
    public function boardMoveAction() {
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $result = array("result" => false, "message" => "");
            try {
                $params = $this->getRequest()->getParams();
                $contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
                $updateCnt = $contentTable->update(array("boardPk" => $params['movePk']), 
                    $contentTable->getAdapter()->quoteInto("boardPk = ?", $params['pk']));

                $result['result'] = true;
                $result['message'] = $updateCnt < 1 ? "이동할 게시물이 없습니다." : number_format($updateCnt) . "건의 게시물이 이동되었습니다.";
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            
            $this->_helper->json->sendJson($result);
        }
    }
    
    /**
     * 
     */
    public function boardDeleteAction() {
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
        	$result = array("result" => false, "message" => "");
        	
        	try {
        	    $params = $this->getRequest()->getParams();
        	    $boardTable = $this->_board->getTable(Hsp_Board_Table_Container::BOARD);
        	    $contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
        	    $commentTable = $this->_board->getTable(Hsp_Board_Table_Container::COMMENT);
        	    $fileTable = $this->_board->getTable(Hsp_Board_Table_Container::FILE);
        	    
        	    $boardTable->getAdapter()->beginTransaction();
        	    
        	    $select = $contentTable->select()->from($contentTable, array('pk'))->where("boardPk = ?", $params['pk']);
        	    $contentPks = $contentTable->getAdapter()->fetchCol($select);
        	    foreach ($contentPks as $contentPk) {
        	        $commentTable->delete($commentTable->getAdapter()->quoteInto("contentPk = ?", $contentPk));
        	        $fileTable->delete($commentTable->getAdapter()->quoteInto("contentPk = ?", $contentPk));
        	        $contentTable->delete($commentTable->getAdapter()->quoteInto("pk = ?", $contentPk));
        	    }
        	    
        	    $boardTable->delete($boardTable->getAdapter()->quoteInto("pk = ?", $params['pk']));
        	    
        	    $result['message'] = "게시판이 삭제되었습니다. " . number_format(count($contentPks)) . "건의 게시물이 삭제되었습니다.";
        	    $result['result'] = true;
        	    
        	    $boardTable->getAdapter()->commit();
    	    } catch (Exception $e) {
    	    	$result['message'] = $e->getMessage();
    	    	$boardTable->getAdapter()->rollBack();
    	    }
        	    
    	    $this->_helper->json->sendJson($result);
        }
    }
    
}

