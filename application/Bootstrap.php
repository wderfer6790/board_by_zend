<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initView() {
        $this->_initDb();
        $this->_initSystem();
        
        $view = new Zend_View();
        
        // html문서가 어떤 표준 규칙을 따르는지 기술한다.
        $view->doctype ( Zend_View_Helper_Doctype::HTML5 );
        // html문서의 인코딩 방식을 지정한다.
        $view->setEncoding ('UTF-8');
        // 브라우저 언어 및 캐릭터셋을 설정
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
        // html문서가 어떤 언어로 되어있는지 기술한다.
        $view->headMeta()->appendHttpEquiv('Language', 'ko-KR');
        // viewport를 지정한다. 너비, 초기화면배율
        $view->headMeta ()->appendName ("viewport", "width=device-width, initial-scale=1.0");
        
        // viewHelper
        $view->addHelperPath('View/Helper');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        
        // navigation 
        $config = new Zend_Config_Xml(APPLICATION_PATH . '\configs\navigation.xml');
        $navigation = new Zend_Navigation($config);
        $boards = Hsp_System::getInstance()->getPackage('board')->getBoards("isDisplay = 1");
        $boardPage = $navigation->findOneBy('accesskey', 'A');
        
        foreach ($boards as $row) {
            $boardPage->addPage(array(
            	'label'      => $row->name,
                'module'     => 'default',
                'controller' => 'board_board',
                'action'     => 'list',
                'params'     => array(
                    'boardPk' => $row->pk
                )
            ));
        }
        $view->navigation($navigation);
        
        // paginator
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('\partials\paginator.phtml');
        
        return $view;
    }
    
    // Db 커넥션 지정
    public function _initDb() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'production');
        $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
        Zend_Db_Table::setDefaultAdapter($db);
    }
    
    public function _initSystem() {
        $system = Hsp_System::getInstance();
        $boardPackage = new Hsp_Board(Zend_Db_Table_Abstract::getDefaultAdapter());
        $system->setPackage($boardPackage, 'board');
    }
}

