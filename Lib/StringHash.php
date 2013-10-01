<?php
/**
 * A library for hashing strings
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
 * A library for hashing strings
 * 
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package Utilities
 */
class StringHash {

    /**
     * Creates a hash that represents a users password.
     * 
     * @param string $password The string the user has submitted as their password.
     * @param string $salt The users unique salt value.
     * @return string
     */
    public static function password($password, $salt) {

        $preHash = Configure::read('Security.salt');
        $preHash .= $salt;
        $preHash .= Security::hash($password, 'sha512', true);

        $hash = Security::hash($preHash, 'sha512', true);

        for ($i = 0; $i < 5; $i++) {
            $hash = Security::hash($hash, 'sha512', true);
        }

        return $hash;
    }

}