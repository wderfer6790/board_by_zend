<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

$db = Zend_Db::factory('PDO_MYSQL', array(
	'host'     => 'localhost',
    'username' => 'root',
    'password' => 'admin',
    'dbname'   => 'test',
    'charset'  => 'utf8'
));
Zend_Db_Table_Abstract::setDefaultAdapter($db);

/**
 * @see Hsp_System
 * @see Hsp_Board
 */
require_once 'Hsp/System.php';
require_once 'Hsp/Board.php';
Hsp_System::getInstance()->setPackage(new Hsp_Board($db), 'board');

require_once 'Zend/Debug.php';
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/TestCase.php';
