<?php
/**
*/
//Call JSC's AllTestCase
require_once ROOT . DS . APP_DIR . DS . 'Test' . DS . 'Case' . DS . 'AllTestCase.php';

/**
 */
class AllJscTest extends AllTestCase {

	/**
	 * Assemble Test Suite
	 *
	 * @return PHPUnit_Framework_TestSuite the instance of PHPUnit_Framework_TestSuite
	 */
	public static function suite() {
		$suite = new self;
		$files = $suite->getTestFiles('Jsc');
		$suite->addTestFiles($files);
		
		return $suite;
	}
}
