<?php
/**
 * @see Hsp_Db_Table_Abstract
 */
require_once 'Hsp/Db/Table/Abstract.php';
/**
 * TestTable
 */
class TestTable extends Hsp_Db_Table_Abstract
{
    /**
     * @var String
     */
    protected $_name = "hsp_db_table_test";
    
    /**
     * @var String
     */
    protected $_createQuery = "
CREATE TABLE IF NOT EXISTS % (
  `pk` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '기본키',
  `title` varchar(64) NOT NULL COMMENT '제목',
  `content` text COMMENT '내용',
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='test' AUTO_INCREMENT=1 ;
";
}

?>