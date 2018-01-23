<?php
/**
 * Hsp Board Table Row AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Hsp_Board_Table_Row_AllTests
 */
class Hsp_Board_Table_Row_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Hsp Board Table Row All Tests');

        $suite->addTestFile(__DIR__ . '/ContentTest.php');

        return $suite;
    }
}