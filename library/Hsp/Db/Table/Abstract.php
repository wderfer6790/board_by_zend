<?php
/**
 * @category   Hsp
 * @package    Db
 * @subpackage Table
 */
/**
 * Zend_Db_Table_Abstract
 */
require_once 'Zend/Db/Table/Abstract.php';
/**
 * Hsp_Db_Table_Abstract
 */
abstract class Hsp_Db_Table_Abstract extends Zend_Db_Table_Abstract
{
    
    /**
     * @var string
     */
    protected $_schema;
    
    /**
     * @var string
     */
    protected $_name;
    
    /**
     * @var string
     */
    protected $_createQuery;
    
    /**
     * @param string
     * @throws Hsp_Db_Table_Exception
     * @return Hsp_Db_Table_Abstract
     */
    public function setSchema($schema) {
        if (!is_string($schema) || !$schema) {
            /**
             * @see Hsp_Db_Table_Exception
             */
            require_once 'Hsp/Db/Table/Exception.php';
            throw new Hsp_Db_Table_Exception("schema is a string and must not be empty.");
        }
        
        $this->_schema = $schema;
        
        return $this;
    }
    
    /**
     * @param boolean
     * @return string
     */
    public function getSchema($quote = false) {
        $schema = "";
        if ($this->_schema) {
        	$quote ? $this->getAdapter()->quoteIdentifier($this->_schema) : $this->_schema;
        }

        return $schema;
    }
    
    
    /**
     * @param boolean
     * @param boolean
     * @throws Hsp_Db_Table_Exception
     * @return string 
     */
    public function getTableName($schema = false, $quote = false) {
        if (!is_string($this->_name) || strlen($this->_name) < 0) {
            /**
             * @see Hsp_Db_Table_Exception
             */
            require_once 'Hsp/Db/Table/Exception.php';
            throw new Hsp_Db_Table_Exception("'_name' property invalid.");
        }
        
        $tableName = $quote ? $this->getAdapter()->quoteIdentifier($this->_name) : $this->_name;
        
        if ($schema || !$this->getSchema()) {
            $tableName = $this->getSchema($quote) . "." . $tableName;
        }
        
        return $tableName;
    }
    
    /**
     * @throws Hsp_Db_Table_Exception
     * @return Hsp_Table_Abstract  
     */
    public function createTable() {
        if (!is_string($this->_createQuery) || !preg_match("/\%/", $this->_createQuery)) {
            /**
             * @see Hsp_Db_Table_Exception
             */
            require_once 'Hsp/Db/Table/Exception.php';
            throw new Hsp_Db_Table_Exception("'_createQuery' property invalid.");
        }
        
        $sql = preg_replace("/\%/", $this->getTableName(true, true), $this->_createQuery);
        $this->getAdapter()->query($sql);
        
        return $this;
    }

    /**
     * @return Hsp_Table_Abstract
     */
    public function recreateTable() {
        $this->dropTable();
        $this->createTable();
        
        return $this;
    }
    
    /**
     * @return Hsp_Table_Abstract
     */
    public function dropTable() {
        $sql = "DROP TABLE IF EXISTS " . $this->getTableName(true, true);
        $this->getAdapter()->query($sql);
        
        return $this;
    }
}
