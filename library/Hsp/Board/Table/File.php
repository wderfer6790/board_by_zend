<?php
/**
 * @category   Hsp
 * @package    Board
 * @subpackage Table
 */
/**
 * @see Hsp_Db_Table_Abstract
 */
require_once 'Hsp/Db/Table/Abstract.php';
/**
 * Hsp_Board_Table_File
 */
class Hsp_Board_Table_File extends Hsp_Db_Table_Abstract
{
    /**
     * @var string
     */
    protected $_name = "board_content_file";
    
    /**
     * @var string
     */
    protected $_createQuery = "
CREATE TABLE % (
    contentPk int NOT NULL COMMENT '게시글 고유키',
    pk int NOT NULL AUTO_INCREMENT COMMENT '파일 고유키',
    fileName varchar(64) NOT NULL COMMENT '파일명',
    fileSize int NOT NULL COMMENT '파일 크기',
    file mediumblob NOT NULL COMMENT '파일',
    PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='게시글 첨부파일 테이블';
";
    
}
