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
 * Hsp_Board_Table_Comment
 */
class Hsp_Board_Table_Comment extends Hsp_Db_Table_Abstract
{
    /**
     * @var string
     */
    protected $_name = "board_content_comment";
    
    /**
     * @var string
     */
    protected $_createQuery = "
CREATE TABLE % (
    contentPk int NOT NULL COMMENT '게시글 고유키',
    pk int NOT NULL AUTO_INCREMENT COMMENT '댓글 고유키',
    parentPk int NOT NULL default 0 COMMENT '부모 댓글 고유키',
    writer varchar(32) NOT NULL COMMENT '작성자',
    password int(4) NOT NULL COMMENT '비밀번호',
    comment varchar(256) NOT NULL default '' COMMENT '댓글',
    insertTime datetime default '0000-00-00 00:00:00' COMMENT '기록시간',
    updateTime datetime default '0000-00-00 00:00:00' COMMENT '변경시간',
    PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='게시판 댓글 정보 테이블';
";
    
}
