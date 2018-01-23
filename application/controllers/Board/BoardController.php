<?php

class Board_BoardController extends Zend_Controller_Action
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
    public function listAction() {
        $searchForm = new Zend_Form(array(
        	"name"   => "searchForm",
            "method" => Zend_Form::METHOD_POST,
            "class"  => "form-inline text-right"
        ));
        $searchForm->setDecorators(array(
        	"FormElements",
//             array("HtmlTag", array('tag' => 'div')),
            "Form"
        ));
        $searchForm->setElementDecorators(array(
        	"ViewHelper",
            array("Label", array("tag" => "lebel")),
            array("HtmlTag", array("tag" => "div", "class" => "form-group")),
        ));
        
        $searchForm->addElement("text", "searchValue", array("class" => "form-control"));
        $searchForm->addElement("submit", "searchBtn", array("label" => "검색", "class" => "btn"));
        $searchForm->getElement('searchBtn')->removeDecorator('Label');
        
        $searchForm->addElement("hidden", "orderField", array("value" => "insertTime"));
        $searchForm->getElement('orderField')->removeDecorator('Label');
        $searchForm->getElement('orderField')->removeDecorator('HtmlTag');
        
        $searchForm->addElement("hidden", "order", array("value" => Zend_Db_Select::SQL_DESC));
        $searchForm->getElement('order')->removeDecorator('Label');
        $searchForm->getElement('order')->removeDecorator('HtmlTag');
        
        $searchForm->addElement("hidden", "page", array("value" => 1));
        $searchForm->getElement('page')->removeDecorator('Label');
        $searchForm->getElement('page')->removeDecorator('HtmlTag');
        
        $this->view->searchForm = $searchForm;
        
        $contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
        $select = $contentTable->select()->order("insertTime " . Zend_Db_Select::SQL_DESC);
        
        $boardPk = $this->getRequest()->getParam('boardPk');
        if ($boardPk) {
        	$boardPks = array($boardPk);
        	$this->view->isTotal = false;
        } else {
        	$boardTable = $this->_board->getTable(Hsp_Board_Table_Container::BOARD);
        	$boardPks = $boardTable->getAdapter()->fetchCol(
        			$boardTable->select()->from($boardTable, "pk")->where("isDisplay = ?", 1));
        	$this->view->isTotal = true;
        }
        if (!empty($boardPks)) {
            $select->where("boardPk IN (?)", $boardPks);
        }
        $select->order(array(
            	$searchForm->getElement("orderField")->getValue() . " " . $searchForm->getElement("order")->getValue()));

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if (!empty($data['searchValue'])) {
                $select->where("title LIKE ?", "%{$data['searchValue']}%")
                    ->orWhere("tag LIKE ?", "%{$data['searchValue']}%");
            }
            
            $select->reset(Zend_Db_Select::ORDER);
            $select->order(array("{$data['orderField']} {$data['order']}"));
            
            $searchForm->setDefaults($data);
        }
        
        
//                 for($i=1; $i<=100; $i++) {
//                     if ($i <= 10) {
//                         $time = strtotime("now");
//                     } else if ($i > 10 && $i <= 20) {
//                         $time = strtotime("-1hours {$i}minutes");
//                     } else if ($i > 20) {
//                         $time = strtotime("-1day");
//                     }
        
//                     $contentTable->insert(array(
//                     	'boardPk'    => 1,
//                         'title'      => 'test_title' . $i,
//                         'content'    => 'test_content' . $i,
//                         'insertTime' => date("Y-m-d H:i:s", $time)
//                     ));
//                 }
        $paginator = Zend_Paginator::factory($select);
        $paginator->setPageRange(5);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($searchForm->getElement('page')->getValue());
        $this->view->paginator = $paginator;
        $this->view->boardPk = $boardPk;
    }
    
    /**
     * 
     */
    public function editContentAction() {
        $contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
        $this->view->boardPk = $this->getRequest()->getParam('boardPk');
        $this->view->contentPk = $this->getRequest()->getParam('contentPk');

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if ($data['contentPk']) {
                $contentRow = $contentTable->find($data['contentPk'])->current();
                $contentRow->setFromArray(array(
                    'title'      => $data['contentTitle'],
                    'content'    => $data['contentEdit'],
                    'tag'        => $data['contentTag'],
                    'updateTime' => date("Y-m-d H:i:s")
                ));
                $contentRow->save();
            } else {
                $contentRow = $contentTable->createRow(array(
                    'boardPk'    => $data['boardPk'],
                    'title'      => $data['contentTitle'],
                    'content'    => $data['contentEdit'],
                    'tag'        => $data['contentTag'],
                    'insertTime' => date("Y-m-d H:i:s")));
                $contentRow->save();
            }

            $this->_helper->redirector("read-content", "board_board", "default", array(
                "contentPk" => $contentRow->pk, "message" => ($data['contentPk'] ? "수정" : "작성")."되었습니다."));
        }
        
        if ($this->view->contentPk) {
            $this->view->contentRow = $contentTable->find($this->view->contentPk)->current();
            $fileTable = $this->_board->getTable(Hsp_Board_Table_Container::FILE);
            $this->view->fileRows = $fileTable->fetchAll(
                $fileTable->getAdapter()->quoteInto("contentPk = ?", $this->view->contentPk));
        }
    }
    
    
    /**
     * 
     */
    public function readContentAction() {
        $contentPk = $this->getRequest()->getParam("contentPk");
        $this->view->message = $this->getRequest()->getParam("message");

        $contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
        $this->view->contentRow = $contentTable->find($contentPk)->current();
        
        $fileTable = $this->_board->getTable(Hsp_Board_Table_Container::FILE);
        $this->view->fileRows = $fileTable->fetchAll($fileTable->getAdapter()->quoteInto("contentPk = ?", $contentPk));
        
        $commentTable = $this->_board->getTable(Hsp_Board_Table_Container::COMMENT);
        
        $select = $commentTable->select()->where("contentPk = ?", $contentPk)->where("parentPk = ?", 0)
            ->order(array("insertTime " . Zend_Db_Select::SQL_DESC));
        $this->view->comments = $commentTable->fetchAll($select);
        
        $select->reset(Zend_Db_Select::WHERE)->reset(Zend_Db_Select::ORDER)
            ->where("contentPk = ?", $contentPk)->where("parentPk != ?", 0)
            ->order("insertTime " . Zend_Db_Select::SQL_ASC);
        $this->view->subComments = $commentTable->fetchAll($select);
    }
    
    /**
     *
     */
    public function deleteContentAction() {
    	$this->_helper->viewRenderer->setNoRender();
    
    	if ($this->getRequest()->isXmlHttpRequest()) {
    		$result = array("result" => false, "message" => "");
    		$contentPk = $this->getRequest()->getParam('contentPk');
    		try {
    			$contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
    			$fileTable = $this->_board->getTable(Hsp_Board_Table_Container::FILE);
    			$commentTable = $this->_board->getTable(Hsp_Board_Table_Container::COMMENT);
    			 
    			$contentTable->getAdapter()->beginTransaction();
    			 
    			$fileTable->delete($fileTable->getAdapter()->quoteInto("contentPk = ?", $contentPk));
    			$commentTable->delete($commentTable->getAdapter()->quoteInto("contentPk = ?", $contentPk));
    			 
    			$contentRow = $contentTable->find($contentPk)->current();
    			$contentRow->delete();
    
    			$contentTable->getAdapter()->commit();
    			$result['message'] = "게시물이 삭제되었습니다.";
    			$result['result'] = true;
    		} catch (Exception $e) {
    			$contentTable->getAdapter()->rollBack();
    			$result['message'] = $e->getMessage();
    		}
    		 
    		$this->_helper->json->sendJson($result);
    	}
    }
    
    /**
     * 
     */
    public function deleteContentFileAction() {
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $result = array('result' => false, 'message');
            try {
                $fileTable = $this->_board->getTable(Hsp_Board_Table_Container::FILE);
                $fileRow = $fileTable->find($this->getRequest()->getParam("filePk"))->current();
                $filename = $fileRow->fileName;
                
                $fileRow->delete();
                
                $result['result'] = true;
                $result['message'] = "'{$filename}' 파일이 삭제되었습니다.";
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            
            $this->_helper->json($result);
        }
    }
    
    /**
     *
     */
    public function downloadContentFileAction() {
    	$this->_helper->layout()->disableLayout();
    
    	$fileTable = $this->_board->getTable(Hsp_Board_Table_Container::FILE);
    	$filePk = $this->getRequest()->getParam("filePk");
    	$this->view->fileRow = $fileTable->find($filePk)->current();
    }
    
    /**
     * 
     */
    public function editCommentAction() {
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
        	$result = array('result' => false, 'message');
        	try {
        		$commentTable = $this->_board->getTable(Hsp_Board_Table_Container::COMMENT);
        		$datas = $this->getRequest()->getParams();
        		if (isset($datas['commentPk'])) {
        		    $commentRow = $commentTable->find($datas['commentPk'])->current();
        		    if ($commentRow->password == $datas['password']) {
        		        $commentRow->setFromArray(array(
                            'comment' => $datas['comment'],
    		                'updateTime' => date("Y-m-d H:i:s")
        		        ));
        		        $commentRow->save();

        		        $result['result'] = true;
        		        $result['message'] = "수정되었습니다.";
        		    } else {
        		        $result['message'] = "비밀번호가 다릅니다.";
        		    }
        		    
        		} else {
        		    $commentRow = $commentTable->createRow(array(
    		            'contentPk' => $datas['contentPk'],
        		        'parentPk'  => isset($datas['parentPk']) ? $datas['parentPk'] : 0,
        		    	'writer'    => $datas['writer'],
    		            'password'  => $datas['password'],
    		            'comment'   => $datas['comment'],
    		            'insertTime' => date("Y-m-d H:i:s")
        		    ));
        		    $commentRow->save();
        		    
        		    $result['result'] = true;
        		    $result['message'] = "작성되었습니다.";
        		}
        	} catch (Exception $e) {
        		$result['message'] = $e->getMessage();
        	}
        
        	$this->_helper->json($result);
        }
    }
    
    /**
     * 
     */
    public function deleteCommentAction() {
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->getRequest()->isXmlHttpRequest()) {
        	$result = array('result' => false, 'message');
        	try {
        		$commentTable = $this->_board->getTable(Hsp_Board_Table_Container::COMMENT);
        		$datas = $this->getRequest()->getParams();
        		
        		$commentRow = $commentTable->find($datas['commentPk'])->current();
        		if ($commentRow->password == $datas['password']) {
            		$commentRow->delete();
            		$result['message'] = "댓글이 삭제되었습니다.";
            		
            		if ($commentRow->parentPk == 0) {
            		    $deleteCnt = $commentTable->delete($commentTable->getAdapter()->quoteInto("parentPk = ?", $datas['commentPk']));
            		    $result['message'] .= "\n{$deleteCnt}건의 하위 댓글이 삭제되었습니다.";
            		}
                    
            		$result['result'] = true;
        		} else {
        		    $result['message'] = "비밀번호가 다릅니다.";
        		}
        	} catch (Exception $e) {
        		$result['message'] = $e->getMessage();
        	}
        
        	$this->_helper->json($result);
        }
    }
    
}
