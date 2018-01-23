<?php
/**
 * Hsp AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Hsp_AllTests
 */
class Hsp_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Hsp All Tests');

        $suite->addTestFile(__DIR__ . '/SystemTest.php');
        
        $suite->addTestFile(__DIR__ . '/Package/AllTests.php');

        return $suite;
    }
}