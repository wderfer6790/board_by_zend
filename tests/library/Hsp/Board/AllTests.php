<?php
/**
 * Hsp Board AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Hsp_Board_AllTests
 */
class Hsp_Board_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Hsp Board All Tests');

        $suite->addTestFile(__DIR__ . '/Table/AllTests.php');

        return $suite;
    }
}