<?php
/**
 * Hsp Db AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Hsp_Db_AllTests
 */
class Hsp_Db_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Hsp Db All Tests');

        $suite->addTestFile(__DIR__ . '/Table/AllTests.php');

        return $suite;
    }
}