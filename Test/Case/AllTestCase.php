<?php
/**
 * Gathers all unit tests from within a single plugin
 * Adapted from DebugKit
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Gathers all unit tests from within a single plugin
 * Adapted from DebugKit
 *
 */
class AllTestCase extends PHPUnit_Framework_TestSuite {

	/**
	 * Constructor
	 * - Accepts the $plugin argument from the child constructor and sets that value as the plugin to be tested. 
	 * - Humanizes and passes a label back to the parent
	 * @param string $plugin 
	 */
	public function __construct() {
		$label = Inflector::humanize(Inflector::underscore(get_class($this)));
		parent::__construct($label);
	}

	/**
	 * Get Test Files
	 *
	 * @param null $directory
	 * @param null $excludes
	 * @return array
	 */
	public static function getTestFiles($plugin) {
		
		$directory = App::pluginPath($plugin) . 'Test' . DS . 'Case' . DS;

		$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

		$files = array();
		while ($it->valid()) {

			if (!$it->isDot()) {
				$file = $it->key();

				if (
					preg_match('|Test\.php$|', $file) &&
					$file !== __FILE__ &&
					!preg_match('|^All.+?\.php$|', basename($file))
				) {
					$files[] = $file;
				}
			}

			$it->next();
		}

		return $files;
	}
}
