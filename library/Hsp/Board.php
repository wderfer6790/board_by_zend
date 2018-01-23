<?php
/**
 * @category Hsp
 */
/**
 * @see Hsp_Package_Abstract
 */
require_once 'Hsp/Package/Abstract.php';
/**
 * @see Hsp_Board_Table_Container
 */
require_once 'Hsp/Board/Table/Container.php';
/**
 * Hsp_Board
 */
class Hsp_Board extends Hsp_Package_Abstract
{
    
    /**
     * @var string
     */
    protected $_containerClass = "Hsp_Board_Table_Container";
    
    /**
     * @param integer
     * @return Zend_Db_Table_Row_Abstract
     */
    public function getBoard($pk) {
        $boardTable = $this->getContainer()->getTable(Hsp_Board_Table_Container::BOARD);
        return $boardTable->find($pk)->current();
    }
    
    /**
     * @param string|Zend_Db_Select
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function getBoards($where = null) {
        $boardTable = $this->getContainer()->getTable(Hsp_Board_Table_Container::BOARD);
        return $boardTable->fetchAll($where, "ordered");
    }
    
    /**
     * @param string
     * @return Hsp_Db_Table_Abstract
     */
    public function getTable($index) {
    	return $this->getContainer()->getTable($index);
    }
        
    /**
     * @param array 
     * @return integer 
     */
    public function addBoard($data) {
        $boardTable = $this->getContainer()->getTable(Hsp_Board_Table_Container::BOARD);
        $cols = array_flip($boardTable->info(Zend_Db_Table_Abstract::COLS));
        $data = array_intersect_key($data, $cols);
        
        return $boardTable->insert($data);
    }
}

?>