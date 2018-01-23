<?php
/**
 * require bootstrap
 */
require_once '/bootstrap.php';
/**
 * require test class
 */
require_once 'Hsp/Board/Table/Row/Content.php';
/**
 * @see Hsp_Board
 */
require_once 'Hsp/Board.php';
/**
 * @see Hsp_Board_Table_Container
 */
require_once 'Hsp/Board/Table/Container.php';
/**
 * Hsp_Board_Table_Row_Content test case.
 */
class Hsp_Board_Table_Row_ContentTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Hsp_Board
     */
    private $_board;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        
        $this->_board = new Hsp_Board(Zend_Db_Table_Abstract::getDefaultAdapter());
        $_FILES = array(
    		'test' => array(
				'name'     => "testFile.jpg",
				'type'     => "image/jpeg",
				'tmp_name' => __DIR__ . "/testFile.jpg",
				'error'    => UPLOAD_ERR_OK,
				'size'     => "687070"));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->_board = null;
        
        parent::tearDown();
    }
    
    public function testInit() {
        $this->_board->reinstallPackage();
    }
    
    public function test_uploadFile() {
        $contentTable = $this->_board->getTable(Hsp_Board_Table_Container::CONTENT);
        $row = $contentTable->createRow(array(
        	'boardPk' => 1,
            'title'   => 'test title',
            'content' => 'test content'
        ));
        $row->save();
    }
    
}

