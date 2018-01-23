<?php
/**
 * require bootstrap
 */
require_once '/bootstrap.php';
/**
 * require test class
 */
require_once 'Hsp/System.php';
/**
 * @see Hsp_Package_Abstract
 */
require_once 'Hsp/Package/Abstract.php';
/**
 * TestPackage
 */
class TestPackage extends Hsp_Package_Abstract {}
/**
 * Hsp_System test case.
 */
class Hsp_SystemTest extends PHPUnit_Framework_TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        parent::tearDown();
    }

    /**
     * Tests Hsp_System::getInstance()
     */
    public function testGetInstance ()
    {
        // 인스턴스 확인
        $instance = Hsp_System::getInstance();
        $this->assertInstanceOf('Hsp_System', $instance);
        
        // 싱글턴 객체 확인
        $instance2 = Hsp_System::getInstance();
        $this->assertTrue($instance === $instance2);
    }
    
    /**
     * Tests Hsp_System->setDbAdapter()
     * Tests Hsp_System->getDbAdapter()
     */
    public function testSetGetDbAdapter ()
    {
        // 예외 테스트
        $system = Hsp_System::getInstance();
        try {
            $system->getDbAdapter();
            $this->fail('No exception occurred.');
        } catch (Hsp_Exception $e) {}
        // 아답터 설정
        $adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        $system->setDbAdapter($adapter);
        // 확인
        $adapter2 = $system->getDbAdapter();
        $this->assertTrue($adapter === $adapter2);  
    }

    /**
     * Tests Hsp_System->setPackage()
     * Tests Hsp_System->getPackage()
     */
    public function testSetGetPackage ()
    {
        // 패키지 설정
        $package = new TestPackage(Zend_Db_Table_Abstract::getDefaultAdapter());
        $system = Hsp_System::getInstance();
        $system->setPackage($package, 'test');
        // 확인
        $this->assertInstanceOf('TestPackage', $system->getPackage('test'));
        $this->assertTrue($package === $system->getPackage('test'));
        // 예외테스트
        try {
            $system->getPackage('UnkonwnPackage');
            $this->fail('No exception occurred.');
        } catch (Hsp_Exception $e) {}
    }
}

