<?php
/**
 * @category   Hsp
 * @package    Db
 * @subpackage Table
 */
/**
 * Hsp_Db_Table_Container
 */
class Hsp_Db_Table_Container
{
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    
    /**
     * @var string
     */
    protected $_schema;
    
    /**
     * @var Zend_Loader
     */
    protected $_loader;
    
    /**
     * @var array
     */
    protected $_referenceMap = array();
    
    /**
     * @var array
     */
    protected $_tables = array();
    
    /**
     * @param Zend_Db_Adapter_Abstract
     */
    public function __construct(Zend_Db_Adapter_Abstract $adapter) {
        $this->_db = $adapter;
        
        /**
         * @see Zend_Loader
         */
        require_once 'Zend/Loader.php';
        $this->_loader = new Zend_Loader();
        
        $this->_init();
    }
    
    /**
     * @return Zend_Db_Adapter_Abstract 
     */
    public function getDbAdapter() {
        return $this->_db;
    }
    
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
     * @return string
     */
    public function getSchema() {
    	return $this->_schema;
    }
    
    
    /**
     * @param  string
     * @param  string
     * @return Hsp_Db_Table_Container
     */
    public function addReference($index, $className) {
        $this->_referenceMap[$index] = $className;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getReferenceMap() {
        return $this->_referenceMap;
    }
    
    /**
     * @throws Hsp_Db_Table_Exception
     * @param  string
     * @return Hsp_Db_Table_Abstract
     */
    public function getTable($index) {
        if (!isset($this->_tables[$index])) {
            if (!isset($this->_referenceMap[$index])) {
            	/**
            	 * Hsp_Db_Table_Exception
            	 */
            	require_once 'Hsp/Db/Table/Exception.php';
            	throw new Hsp_Db_Table_Exception("'{$index}' table is not exist.");
            }
            
            $this->_loader->loadClass($this->_referenceMap[$index]);
            $table = new $this->_referenceMap[$index]($this->getDbAdapter());
            $this->_tables[$index] = $this->getSchema() ? $table->setSchema($this->getSchema()) : $table; 
        }
        
        return $this->_tables[$index];
    }
    
    /**
     * @return Hsp_Db_Table_Container 
     */
    public function createAllTable() {
        foreach ($this->_referenceMap as $index => $className) {
            $this->getTable($index)->createTable();
        }
    }
    
    /**
     * @return Hsp_Db_Table_Container 
     */
    public function recreateAllTable() {
        foreach ($this->_referenceMap as $index => $className) {
        	$this->getTable($index)->recreateTable();
        }    
    }
    
    /**
     * init
     */
    protected function _init() {}
}

?>