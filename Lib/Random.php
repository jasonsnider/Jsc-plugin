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
class Random {
	
	/**
	 * Inititalizes the class
	 */
	public function __construct() {}

    /**
     * Generates a random string of a specified length and character set
     * @param integer $length The length of the string
     * @param boolean $upper Add the A-Z character set
     * @param boolean $lower Add the a-z character set
     * @param boolean $numeric Add the numeric character set
     * @param boolean $special Add the special character set
     * @param boolean $disambiguate Removes potentially ambiguous characters from the alphabets
     * @return string
     */
    private static function __randomizer($length, $upper, $lower, $numeric, $special, $disambiguate) {

        $characters = '';
        $string = '';

        if ($numeric) {
            $characters .= ($disambiguate) ? '23456789' : '0123456789';
        }

        if ($lower) {
            $characters .= ($disambiguate) ? 'abcdefghijmnpqrstuvwxyz' : 'abcdefghijklmnopqrstuvwxyz';
        }

        if ($upper) {
            $characters .= ($disambiguate) ? 'ABCDEFGHLMNPQRSTUVWXYZ' : 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
        }

        if ($special) {
            $characters .= ($disambiguate) ? '!@#$%^&*()-_=+;:\'"<>,./?\\`~' : '!@#$%^&*()-_=+;:\'"<>,./?\\`~';
        }

        $size = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, $size - 1)];
        }

        return $string;
    }

    /**
     * Returns a random string matching the input requirements. These requirements may consist of custom or predefined
     * types
     * 
     * Predefined Random String Types
     * 
     * - CAKE_CIPHER returns a CakePHP cipher string 
     * - CAKE_SALT returns a CakePHP salt string 
     * 
     * Custom Random String Types
     * Passing a string consiting of any of the following characters. For example Utility::random('ul', 10); will
     * return a 10 character string containing upper and lower case letters.
     * 
     * - u Calls the uppercase character set
     * - l Calls the lowercase character set
     * - n Calls the numeric character set
     * - s Calls the special character set
     * - d Disambiguate all character sets
     * 
     * @param integer|string $arg1 This can be either the `length` of the string or the `type`
     * @param integer|string $arg2 This can be either the `length` of the string or the `type`
     * 
     * @return string
     */
    public static function random($arg1 = null, $arg2 = null) {

        $length = null;
        $type = null;

        //Try and figure out which arg is the $length and which is the $type
        if (is_integer($arg1)) {
            $length = $arg1;
            $type = $arg2;
        } else {
            $length = $arg2;
            $type = $arg1;
        }

        //If no integer is passed, set a default length
        if (is_null($length)) {
            $length = 5;
        }

        //If no string is passed, set the default string type
        if (is_null($type)) {
            $type = 'ulnsd';
        }

        //If the string is not all caps we will parse it for args, otherwise we assume it's a predefined type
        if (!ctype_upper($type)) {
            $chars = str_split($type);

            $upper = in_array('u', $chars) ? true : false;
            $lower = in_array('l', $chars) ? true : false;
            $numeric = in_array('n', $chars) ? true : false;
            $special = in_array('s', $chars) ? true : false;
            $disambiguate = in_array('d', $chars) ? true : false;

            return self::__randomizer($length, $upper, $lower, $numeric, $special, $disambiguate);
        }

        //If we have made it this far, try and set a default type
        switch ($type) {
            //self::__randomizer($length, $upper, $lower, $numeric, $special, $disambiguate);
            case 'CAKECIPHER':
                return self::__randomizer(128, false, false, true, false, false);
                break;

            case 'CAKESALT':
                return self::__randomizer(128, true, true, true, false, false);
                break;

            default:
                throw new Exception(__("The prefdefined type doesn't exist!"));
                break;
        }
    }

    /**
     * Creates some pseudo random jibberish to be used as a salt value.
     * 
     * @return string
     */
    public static function makeSalt() {
        $seed = openssl_random_pseudo_bytes(4096);
        $seed .= String::uuid();
        $seed .= mt_rand(1000000000, 2147483647);
        $seed .= self::random(4096, 'ulns');
        $seed .= Security::hash(php_ini_loaded_file(), 'sha512', true);

        if (is_dir(DS . 'var')) {
            $seed .= Security::hash(implode(scandir(DS . 'var')), 'sha512');
        }

        $salt = $hash = Security::hash($seed, 'sha512', true);

        for ($i = 0; $i < 10; $i++) {
            $salt = Security::hash($salt, 'sha512', true);
        }

        return $salt;
    }
	
	/**
	 * Generates a  version 4 compliant psuedo-random UUID.
	 * 
	 * @link http://www.php.net/manual/en/function.uniqid.php#88023
	 * @see http://tools.ietf.org/html/rfc4122#section-4.4
	 * @see http://en.wikipedia.org/wiki/UUID
	 *
	 * @return string A UUID, made up of 32 hex digits and 4 hyphens.
	 */
	public static function uuid() {
        
		$pr_bits = null;
		$fp = @fopen('/dev/urandom','rb');
		if ($fp !== false) {
			$pr_bits .= @fread($fp, 16);
			@fclose($fp);
		} else {
			// If /dev/urandom isn't available (eg: in non-unix systems), use mt_rand().
			$pr_bits = "";
			for($cnt=0; $cnt < 16; $cnt++){
				$pr_bits .= chr(mt_rand(0, 255));
			}
		}
        
		$time_low = bin2hex(substr($pr_bits,0, 4));
		$time_mid = bin2hex(substr($pr_bits,4, 2));
		$time_hi_and_version = bin2hex(substr($pr_bits,6, 2));
		$clock_seq_hi_and_reserved = bin2hex(substr($pr_bits,8, 2));
		$node = bin2hex(substr($pr_bits,10, 6));
        
		/**
		 * Set the four most significant bits (bits 12 through 15) of the
		 * time_hi_and_version field to the 4-bit version number from
		 * Section 4.1.3.
		 * @see http://tools.ietf.org/html/rfc4122#section-4.1.3
		 */
        $time_hi_and_version = hexdec($time_hi_and_version);
        $time_hi_and_version = $time_hi_and_version >> 4;
        $time_hi_and_version = $time_hi_and_version | 0x4000;

        /**
         * Set the two most significant bits (bits 6 and 7) of the
         * clock_seq_hi_and_reserved to zero and one, respectively.
         */
        $clock_seq_hi_and_reserved = hexdec($clock_seq_hi_and_reserved);
        $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved >> 2;
        $clock_seq_hi_and_reserved = $clock_seq_hi_and_reserved | 0x8000;
        
		return sprintf(
            '%08s-%04s-%04x-%04x-%012s',
            $time_low,
            $time_mid,
            $time_hi_and_version,
            $clock_seq_hi_and_reserved,
            $node
		);
    }    
}