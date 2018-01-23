<?php
/**
 * Library AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Library_AllTests
 */
class Library_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Library All Tests');

        $suite->addTestFile(__DIR__ . '/Hsp/AllTests.php');

        return $suite;
    }
}