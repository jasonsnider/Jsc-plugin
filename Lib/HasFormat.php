<?php
/**
 * A library for crateing a psuedo-random noise
 * 
 * Jason Snider's Website (http://jasonsnider.com)
 * Copyright 2012, Jason D Snider. (http://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider. (http://jasonsnider.com)
 * @link http://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package Utilities
 */
App::uses('Security', 'Utility');
App::uses('String', 'Utility');

/**
 * A library for crateing a psuedo-random noise
 * 
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package Utilities
 */
class HasFormat {
	
	/**
	 * Inititalizes the class
	 */
	public function __construct() {}
    
/**
 * Returns true if a given string is a uuid
 * @param string $string
 * @return boolean
 */
    public static function uuid($string){
        if (eregi("^[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}$", $string)) {
            return true;
        }
        return false;
    }
 
}