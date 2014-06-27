<?php
/**
 * Executes all test cases for JSC excluding third party plugins
 * Excludes
 * -AuditLog
 * -DebugKit
 * -Search
 * -Tags
 */
//Call JSC's AllTestCase
require_once 'AllTestCase.php';

/**
 * Executes all test cases for JSC excluding third party plugins
 * Excludes
 * -AuditLog
 * -DebugKit
 * -Search
 * -Tags
 */
class AllGroupTest extends AllTestCase {

	/**
	 * Execite all tests for core plugins
	 *
	 * @return PHPUnit_Framework_TestSuite the instance of PHPUnit_Framework_TestSuite
	 */
	public static function suite() {
		
		//Exclude thrid party plugins
		$exclude = array(
			'AuditLog',
			'DebugKit',
			'Search',
			'Tags'
		);
		
		$suite = new self;
		foreach(App::objects('plugin') as $plugin):
			if(!in_array($plugin, $exclude)){
				try{
					$suite->addTestFiles($suite->getTestFiles($plugin));
				}catch(Exception $e){
					debug("Missing Test Cases for {$plugin}");
				}

			}
		endforeach;
		return $suite;
	}
}
