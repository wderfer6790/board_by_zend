<?php

/**
 * @category Hsp
 */
class Hsp_System
{
    /**
     * @var Hsp_System
     */
    static protected $_instance;
    
    /**
     * @var array
     */
    protected $_packages = array();
    
    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    
    /**
     * singleton 
     */
    protected function __construct() {}
    
    /**
     * @return Hsp_System 
     */
    static public function getInstance() {
        if (!Hsp_System::$_instance instanceof Hsp_System) {
            Hsp_System::$_instance = new self();
        }
        
        return Hsp_System::$_instance;
    }
    
    /**
     * 데이터베이스 아답터를 설정한다.
     * 
     * @param  Zend_Db_Adapter_Abstract
     * @return Hsp_System
     */
    public function setDbAdapter(Zend_Db_Adapter_Abstract $adapter) {
        $this->_db = $adapter;
        
        return $this;
    }
    
    /**
     * 설정된 데이터베이스 아답터를 리턴한다.
     * 
     * @throws Hsp_Exception
     * @return Zend_Db_Adapter_Abstract 
     */
    public function getDbAdapter() {
        if (!$this->_db instanceof Zend_Db_Adapter_Abstract) {
            /**
             * @see Hsp_Exception
             */
            require_once 'Hsp/Exception.php';
            throw new Hsp_Exception('database adapter is not set.');
        }
        
        return $this->_db;
    }
    
    /**
     * 인덱스를 키로 패키지를 설정한다.
     * 
     * @param Hsp_Package_Abstract
     * @param String
     * @return Hsp_System
     */
    public function setPackage(Hsp_Package_Abstract $package, $index) {
        $this->_packages[$index] = $package;

        return $this;
    }
    
    /**
     * 설정된 패키지 중 해당 인덱스에 맞는 패키지를 리턴한다.
     * 
     * @throws Hsp_Exception
     * @param String 
     * @return Hsp_Package_Abstract|NULL
     */
    public function getPackage($index) {
        if (!isset($this->_packages[$index])) {
            /**
             * @see Hsp_Exception
             */
            require_once 'Hsp/Exception.php';
            throw new Hsp_Exception("'{$index}' package not found.");
        }
        
        return $this->_packages[$index];
    }
}

?>