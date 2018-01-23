<?php
/**
 * @category Hsp
 * @package  Package
 */
abstract class Hsp_Package_Abstract
{
    /**
     * @var string
     */
    protected $_name;
    
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    
    /**
     * @var string
     */
    protected $_schema;
    
    /**
     * @var Hsp_Db_Table_Container
     */
    protected $_container;
    
    /**
     * @var string
     */
    protected $_containerClass = "Hsp_Db_Table_Container";
    
    /**
     * @param Zend_Db_Adapter_Abstract 
     */
    public function __construct(Zend_Db_Adapter_Abstract $dbAdapter) {
        $this->_db = $dbAdapter;
    }
    
    /**
     * @param string
     */
    public function setName($name) {
        if (!is_string($name) || !$name) {
        	/**
        	 * @see Hsp_Package_Exception
        	 */
        	require_once 'Hsp/Package/Exception.php';
        	throw new Hsp_Package_Exception("schema is a string and must not be empty.");
        }
        
        $this->_name = $name;
        
        return $this;
    }
    
    /**
     * @throws Hsp_Package_Exception
     * @return string
     */
    public function getName() {
        if (is_string($this->_name) || !$this->_name) {
        	/**
        	 * @see Hsp_Package_Exception
        	 */
        	require_once 'Hsp/Package/Exception.php';
        	throw new Hsp_Package_Exception("name is not set.");
        }
        
        return $this->_name;
    }
    
    /**
     * @return Zend_Db_Adapter_Abstract
     */
    public function getDbAdapter() {
        return $this->_db;
    }
    
    /**
     * @return Hsp_Db_Table_Container
     */
    public function getContainer() {
        if(!$this->_container instanceof Hsp_Db_Table_Container) {
            /**
             * @see Zend_Loader
             */
            require_once 'Zend/Loader.php';
            Zend_Loader::loadClass($this->_containerClass);
            $this->_container = new $this->_containerClass($this->getDbAdapter());
            if ($this->getSchema()) {
                $this->_container->setSchema($this->getSchema());
            }
        }
        
        return $this->_container;
    }
    
    /**
     * @param string
     * @throws Hsp_Package_Exception
     * @return Hsp_Db_Table_Abstract
     */
    public function setSchema($schema) {
    	if (!is_string($schema) || !$schema) {
    		/**
    		 * @see Hsp_Package_Exception
    		 */
    		require_once 'Hsp/Package/Exception.php';
    		throw new Hsp_Package_Exception("schema is a string and must not be empty.");
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
     * @return Hsp_Package_Abstract 
     */
    public function installPackage() {
        $this->getContainer()->createAllTable();
        
        return $this;
    }
    
    /**
     * @return Hsp_Package_Abstract
     */
    public function reinstallPackage() {
    	$this->getContainer()->recreateAllTable();
    
    	return $this;
    }
}

?>