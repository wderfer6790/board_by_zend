<?php
/**
 * require bootstrap
 */
require_once '/bootstrap.php';
/**
 * require test class
 */
require_once 'Hsp/Package/Abstract.php';

/**
 * Hsp_Package_AbstractTestClass
 */
class Hsp_Package_AbstractTestClass extends Hsp_Package_Abstract {
    
}
/**
 * Hsp_Package_Abstract test case.
 */
class Hsp_Package_AbstractTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Hsp_Package_AbstractTestClass
     */
    private $_abstract;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        
        $this->_abstract = new Hsp_Package_AbstractTestClass(Zend_Db_Table_Abstract::getDefaultAdapter());
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->_abstract = null;
        
        parent::tearDown();
    }

    /**
     * Tests Hsp_Package_Abstract->getDbAdapter()
     */
    public function testGetDbAdapter ()
    {
        $this->assertTrue(Zend_Db_Table_Abstract::getDefaultAdapter() === $this->_abstract->getDbAdapter());
    }

    /**
     * Tests Hsp_Package_Abstract->getContainer()
     */
    public function testGetContainer ()
    {
        $container = $this->_abstract->getContainer();
        $this->assertInstanceOf('Hsp_Db_Table_Container', $container);
        $this->assertTrue($this->_abstract->getDbAdapter() === $container->getDbAdapter());
    }
}

