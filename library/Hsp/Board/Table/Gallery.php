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
 * Hsp_Board_Table_Gallery
 */
class Hsp_Board_Table_Gallery extends Hsp_Db_Table_Abstract
{
    /**
     * @var string
     */
    protected $_name = "board_gallery";
    
    /**
     * @var string
     */
    protected $_createQuery = "
CREATE TABLE % (
    pk int NOT NULL AUTO_INCREMENT COMMENT '이미지 고유키',
    title varchar(32) NOT NULL COMMENT '이미지 제목',
    imageName varchar(12) NOT NULL COMMENT '이미지명',
    imageSize int NOT NULL COMMENT '이미지 크기',
    image mediumblob NOT NULL COMMENT '이미지',
    tag varchar(32) NOT NULL DEFAULT '' COMMENT '태그',
    insertTime datetime default '0000-00-00 00:00:00' COMMENT '기록시간',
    PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='갤러리 이미지 테이블';
";
    
}
