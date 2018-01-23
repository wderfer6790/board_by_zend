<?php
/**
 * require bootstrap
 */
require_once '/bootstrap.php';
/**
 * require test class
 */
require_once 'Hsp/Db/Table/Container.php';
/**
 * Hsp_Db_Table_Container test case.
 */
class Hsp_Db_Table_ContainerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Hsp_Db_Table_Container
     */
    private $_container;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        
        $this->_container = new Hsp_Db_Table_Container(Zend_Db_Table_Abstract::getDefaultAdapter());
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
     * Tests Hsp_Db_Table_Container->getDbAdapter()
     */
    public function testGetDbAdapter ()
    {
        $this->assertTrue(Zend_Db_Table_Abstract::getDefaultAdapter() === $this->_container->getDbAdapter());
    }

    /**
     * Tests Hsp_Db_Table_Container->addReference()
     */
    public function testAddReference ()
    {
    }

    /**
     * Tests Hsp_Db_Table_Container->getReferenceMap()
     */
    public function testGetReferenceMap ()
    {
    }

    /**
     * Tests Hsp_Db_Table_Container->getTable()
     */
    public function testGetTable ()
    {
    }
}

