<?php

/**
 * Provides unit tests for the utility library
 * 
 * JSC (http://jasonsnider.com/jsc)
 * Copyright 2012, Jason D Snider. (http://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider. (http://jasonsnider.com)
 * @link http://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package Jsc
 */
App::uses('Random', 'Jsc.Lib');
App::uses('StringHash', 'Jsc.Lib');

/**
 * Provides unit tests for the utility library
 * 
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package test/Random
 */
class RandomTest extends CakeTestCase {

    /**
     * Fixtures associated with this test case
     *
     * @var array
     * @access public
     */
    public $fixtures = array();

    /**
     * Method executed before each test
     */
    public function setUp() {
        parent::setUp();
    }

    /**
     * Method executed after each test
     */
    public function tearDown() {
        parent::tearDown();
    }

    /**
     * Test that the order of the args doesn't matter
     */
    public function testRandomBySwitchingTheOrderOfTheArgs() {

        $result1 = Random::random(10, 'lnu');
        debug($result1);

        $result2 = Random::random('lnu', 10);
        debug($result2);

        $this->assertEquals(10, strlen($result1));
        $this->assertEquals(10, strlen($result2));
    }

    /**
     * Test that any single arg can be passed.
     */
    public function testRandomByPassingOnlyOneArg() {

        $result1 = Random::random('lnu');
        debug($result1);

        $result2 = Random::random(10);
        debug($result2);

        $this->assertEquals(5, strlen($result1));
        $this->assertEquals(10, strlen($result2));
    }

    /**
     * Test if passing predefined types returns the expected results.
     */
    public function testRandomByPassingAPredefinedType() {

        $result1 = Random::random('CAKECIPHER');
        debug($result1);

        $result2 = Random::random('CAKESALT');
        debug($result2);

        $this->assertEquals(128, strlen($result1));
        $this->assertEquals(128, strlen($result2));
    }

    /**
     * Tests" the "Throws" functionality against predefined types.
     */
    public function testRandomThrowsErrorProperErrorsAgainstPrefdefinedTypes() {
        $caught1 = false;
        $caught2 = false;

        try {
            Random::random('CAKESALT');
        } catch (Exception $e) {
            $caught1 = true;
        }
        $this->assertFalse($caught1);

        try {
            Random::random('XXX');
        } catch (Exception $e) {
            $caught2 = true;
        }

        $this->assertTrue($caught2);
    }

    /**
     * A test for makeSalt
     */
    public function testMakeSalt() {
        $result1 = Random::makeSalt();
        $result2 = Random::makeSalt();

        $match = false;
        if ($result1 == $result2) {
            $match = true;
        }

        $this->assertFalse($match);
        $this->assertEquals(128, strlen($result1));
    }

    /**
     * Tests that the hash method returns consitant results with common input
     */
    public function testHashPasswordConsitancy() {
        $result1 = StringHash::password('abc', 123);
        $result2 = StringHash::password('abc', 123);
        $this->assertEquals($result1, $result2);
    }

}