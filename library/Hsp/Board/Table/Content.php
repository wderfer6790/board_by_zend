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
 * Hsp_Board_Table_Content
 */
class Hsp_Board_Table_Content extends Hsp_Db_Table_Abstract
{
    /**
     * @var string
     */
    protected $_rowClass = "Hsp_Board_Table_Row_Content";
    
    /**
     * @var string
     */
    protected $_name = "board_content";
    
    /**
     * @var string
     */
    protected $_createQuery = "
CREATE TABLE % (
    boardPk int NOT NULL COMMENT '게시판 고유키',
    pk int NOT NULL AUTO_INCREMENT COMMENT '게시글 고유키',
    title varchar(64) NOT NULL COMMENT '게시글 제목',
    content text NULL COMMENT '게시글 내용',
    tag varchar(32) NULL COMMENT '게시글 태그',
    insertTime datetime default '0000-00-00 00:00:00' COMMENT '기록시간',
    updateTime datetime default '0000-00-00 00:00:00' COMMENT '변경시간',
    PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='게시판 게시글 테이블';
";
    
}
