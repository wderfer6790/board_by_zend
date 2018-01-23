<?php
/**
 * Hsp Package AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Hsp_Package_AllTests
 */
class Hsp_Package_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Hsp Package All Tests');

        $suite->addTestFile(__DIR__ . '/AbstractTest.php');

        return $suite;
    }
}