<?php
/**
 * require bootstrap
 */
require_once '/bootstrap.php';
/**
 * require test class
 */
require_once 'Hsp/Board/Table/Container.php';
/**
 * Hsp_Board_Table_Container test case.
 */
class Hsp_Board_Table_ContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Hsp_Board_Table_Container
     */
    private $_container;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        
        $this->_container = new Hsp_Board_Table_Container(Zend_Db_Table_Abstract::getDefaultAdapter());
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->_container = null;
        
        parent::tearDown();
    }

    /**
     * test referenceMap
     */
    public function testRefercenceMap ()
    {
        $this->_container->recreateAllTable();
    }
}

