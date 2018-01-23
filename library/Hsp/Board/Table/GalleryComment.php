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
 * Hsp_Board_Table_GalleryComment
 */
class Hsp_Board_Table_GalleryComment extends Hsp_Db_Table_Abstract
{
    /**
     * @var string
     */
    protected $_name = "board_gallery_comment";
    
    /**
     * @var string
     */
    protected $_createQuery = "
CREATE TABLE % (
    galleryPk int NOT NULL COMMENT '갤러리 이미지 고유키',
    pk int NOT NULL AUTO_INCREMENT COMMENT '댓글 고유키',
    parentPk int NOT NULL default 0 COMMENT '부모 댓글 고유키',
    comment varchar(256) NOT NULL default '' COMMENT '댓글',
    insertTime datetime default '0000-00-00 00:00:00' COMMENT '기록시간',
    updateTime datetime default '0000-00-00 00:00:00' COMMENT '수정시간',
    PRIMARY KEY (`pk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT='갤러리 댓글 정보 테이블';
";
    
}
