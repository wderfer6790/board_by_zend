<?php
echo "작업을 진행하시겠습니까? (y/n) : ";
$answer = fgetc(STDIN);
if ('y' != strtolower($answer)) {
    die("작업이 취소되었습니다.\n");
}

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

$paths = array(realpath(APPLICATION_PATH . '/../library'));
if (function_exists('zend_deployment_library_path') && zend_deployment_library_path('Zend Framework 1')) {
	$paths[] = zend_deployment_library_path('Zend Framework 1');
}

$paths[] = get_include_path();
set_include_path(implode(PATH_SEPARATOR, $paths));

require_once 'Zend/Db.php';
require_once 'Zend/Config/Ini.php';
require_once 'Hsp/Board.php';
require_once 'Hsp/Board/Table/Container.php';

$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini");
$config = $config->toArray();

$adapter = Zend_Db::factory($config['production']['resources']['db']['adapter'], $config['production']['resources']['db']['params']);

echo "게시판 데이터베이스 인스톨...  ";
$board = new Hsp_Board($adapter);
$board->reinstallPackage();
echo "완료\n";

echo "작업이 완료되었습니다.\n";