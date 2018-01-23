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
 * Hsp_Board_Table_Board
 */
class Hsp_Board_Table_Board extends Hsp_Db_Table_Abstract
{
    /**
     * @var string
     */
    protected $_name = "board";
    
    /**
     * @var string
     */
    protected $_createQuery = "
CREATE TABLE % (
    pk int NOT NULL AUTO_INCREMENT COMMENT '고유키',
    name varchar(16) NOT NULL COMMENT '게시판명',
    ordered tinyint(3) default 0 COMMENT '정렬순서',
    isDisplay tinyint(1) default 1 COMMENT '표시유무',
    insertTime datetime default '0000-00-00 00:00:00' COMMENT '기록시간',
    updateTime datetime default '0000-00-00 00:00:00' COMMENT '변경시간',
    PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='게시판 정보 테이블';
";
    
}
