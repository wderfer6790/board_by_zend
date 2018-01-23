<?php
/**
 * Hsp Board Table AllTests file
 */
/**
 * require bootstrap
 */
require_once __DIR__ . '/bootstrap.php';

/**
 * Hsp_Board_Table_AllTests
 */
class Hsp_Board_Table_AllTests extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Hsp Board Table All Tests');

        $suite->addTestFile(__DIR__ . '/ContainerTest.php');

        return $suite;
    }
}