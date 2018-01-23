<?php
/**
 * @category   Hsp
 * @package    Board_Table
 * @subpackage Row
 */
/**
 * @see Zend_Db_Table_Row_Abstract
 */
require_once 'Zend/Db/Table/Row/Abstract.php';
/**
 * @see Zend_File_Transfer_Adapter_Http
 */
require_once 'Zend/File/Transfer/Adapter/Http.php';
/**
 * @see Hsp_System
 */
require_once 'Hsp/System.php';
/**
 * @see Hsp_Board_Table_Container
 */
require_once 'Hsp/Board/Table/Container.php';
/**
 * Hsp_Board_Table_Row_Content
 */
class Hsp_Board_Table_Row_Content extends Zend_Db_Table_Row_Abstract
{
    /* (non-PHPdoc)
     * @see Zend_Db_Table_Row_Abstract::_postInsert()
     */
    protected function _postInsert() {
        $this->_uploadFile();
    }
    
    /* (non-PHPdoc)
     * @see Zend_Db_Table_Row_Abstract::_postUpdate()
     */
    protected function _postUpdate() {
        $this->_uploadFile();
    }
    
    protected function _uploadFile() {
        $upload = new Zend_File_Transfer_Adapter_Http();
        $files = $upload->getFileInfo();
        if (!empty($files)) {
            $fileTable = Hsp_System::getInstance()->getPackage('board')->getTable(Hsp_Board_Table_Container::FILE);
            foreach ($files as $file) {
                if ($file['error'] != UPLOAD_ERR_OK) continue; 
                    
            	$fileTable->insert(array(
        			'contentPk' => $this->pk,
        			'fileName'  => $file['name'],
        			'fileSize'  => $file['size'],
        			'file'      => file_get_contents($file['tmp_name']),
            	));
            }
        }
    }
}
