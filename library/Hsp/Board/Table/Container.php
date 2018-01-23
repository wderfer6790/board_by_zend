<?php
/**
 * @category   Hsp
 * @package    Board
 * @subpackage Table
 */
/**
 * @see Hsp_Db_Table_Container
 */
require_once 'Hsp/Db/Table/Container.php';
/**
 * Hsp_Board_Table_Container
 */
class Hsp_Board_Table_Container extends Hsp_Db_Table_Container
{
    /**
     * @var string
     */
    const BOARD = "board";
    /**
     * @var string
     */
    const COMMENT = "comment";
    /**
     * @var string
     */
    const CONTENT = "content";
    /**
     * @var string
     */
    const FILE = "file";
    /**
     * @var string
     */
    const GALLERY = "gallery";
    /**
     * @var string
     */
    const GALLERY_COMMENT = "galleryComment";
    
    /* (non-PHPdoc)
     * @see Hsp_Db_Table_Container::_init()
     */
    protected function _init() {
        $this->addReference(self::BOARD, "Hsp_Board_Table_Board");
        $this->addReference(self::COMMENT, "Hsp_Board_Table_Comment");
        $this->addReference(self::CONTENT, "Hsp_Board_Table_Content");
        $this->addReference(self::FILE, "Hsp_Board_Table_File");
        $this->addReference(self::GALLERY, "Hsp_Board_Table_Gallery");
        $this->addReference(self::GALLERY_COMMENT, "Hsp_Board_Table_GalleryComment");
    }
}

?>