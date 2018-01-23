<?php
/**
 * require bootstrap
 */
require_once '/bootstrap.php';
/**
 * require test class
 */
require_once 'Hsp/Db/Table/Abstract.php';
/**
 * @see TestTable
 */
require_once '/TestTable.php';
/**
 * Hsp_Db_Table_Abstract test case.
 */
class Hsp_Db_Table_AbstractTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var TestTable
     */
    private $_table;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        parent::setUp();
        
        $this->_table = new TestTable(Zend_Db_Table_Abstract::getDefaultAdapter());
        $this->_table->setSchema('test');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        $this->_table = null;
        
        parent::tearDown();
    }
    

    /**
     * test init 
     */
    public function testInit() {
        $this->_table->dropTable();
    }

    /**
     * Tests Hsp_Db_Table_Abstract->setSchema()
     * Tests Hsp_Db_Table_Abstract->getSchema()
     */
    public function testSetGetSchema() {
        $this->_table->setSchema('Unknown');
        $this->assertEquals('Unknown', $this->_table->getSchema());
        
        
        
    }
    
    /**
     * Tests Hsp_Db_Table_Abstract->getTableName()
     */
    public function testGetTableName() {
        $this->_table->setSchema('test');
        
    	$this->assertEquals("hsp_db_table_test", $this->_table->getTableName());
    	$this->assertEquals("test.hsp_db_table_test", $this->_table->getTableName(true));
    	$this->assertEquals("`hsp_db_table_test`", $this->_table->getTableName(false, true));
    	$this->assertEquals("`test`.`hsp_db_table_test`", $this->_table->getTableName(true, true));
    }

    /**
     * Tests Hsp_Db_Table_Abstract->createTable()
     */
    public function testCreateTable ()
    {
        $this->_table->createTable();
        
        $sql = "SHOW TABLES IN " . $this->_table->getSchema() ." LIKE '" . $this->_table->getTableName() . "';";
        $result = $this->_table->getAdapter()->query($sql);
        $this->assertEquals(1, $result->rowCount());
    }

    /**
     * Tests Hsp_Db_Table_Abstract->dropTable()
     */
    public function testDropTable ()
    {
        $this->_table->dropTable();
        
        $sql = "SHOW TABLES IN " . $this->_table->getSchema() ." LIKE '" . $this->_table->getTableName() . "';";
        $result = $this->_table->getAdapter()->query($sql);
        $this->assertEquals(0, $result->rowCount());
    }
    
    /**
     * Tests Hsp_Db_Table_Abstract->recreateTable()
     */
    public function testRecreateTable ()
    {
        $this->_table->createTable();
        $this->_table->insert(array(
        	'title' => 'test',
            'content' => 'test'
        ));
        
        $this->assertEquals(1, $this->_table->fetchAll()->count());
        
        $this->_table->recreateTable();
        
        $this->assertEquals(0, $this->_table->fetchAll()->count());
    }
}

