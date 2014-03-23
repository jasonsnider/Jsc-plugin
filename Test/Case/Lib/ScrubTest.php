<?php

/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link https://jasonsnider.com
 */
App::uses('Scrub', 'Utilities.Lib');
App::uses('Sanitize', 'Utility');

/**
 * SeoBehavior test class.
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Test.Case.Lib
 * @author Jason D Snider <root@jasonsnider.com>
 */
class SeoBehaviorTest extends CakeTestCase {

    /**
     * Fixtures associated with this test case
     *
     * @var array
     * @access public
     */
    public $fixtures = array();

    /**
     * Method executed before each test
     *
     * @return void
     * @access public
     */
    public function setUp() {
        parent::setUp();
    }

    /**
     * Method executed after each test
     *
     * @return void
     * @access public
     */
    public function tearDown() {
        parent::tearDown();
    }

    /**
     * Simulates the creation of a slug based on the column of a given record
     * 
     * @return void
     * @access public
     */
    public function testHtmlMediaAllowsYouttubeViaHtml5() {

        $input = '<iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/RVtEQxH7PWA" frameborder="0" allowfullscreen></iframe>';
        $expected = '<p><iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/RVtEQxH7PWA" frameborder="0"></iframe></p>';

        $scrubed = Scrub::htmlMedia($input);

        $this->assertEquals($scrubed, $expected);
    }

    /**
     * Simulates the creation of a slug based on the column of a given record
     * 
     * @return void
     * @access public
     */
    public function testHtmlMediaDoesNotStripEmptyIFrames() {

        $input = '<iframe></iframe>';
        $expected = '<p><iframe></iframe></p>';

        $scrubed = Scrub::htmlMedia($input);

        $this->assertEquals($scrubed, $expected);
    }

    /**
     * Tests the repair of broken tags
     * 
     * @return void
     * @access public
     */
    public function testHtmlMediaFixesBrokenTags() {

        $input = '<p></p';
        $expected = '<p></p>';

        $scrubed = Scrub::htmlMedia($input);

        $this->assertEquals($scrubed, $expected);
    }
	
    /**
     * Passes if special chars are removed
     */
    public function testPhoneNumberStripsCommonFormats() {

        $input = '614-865-5309';
		$input1 = '(614)865-5309';
		$input2 = '(614) 865-5309';
		$input3 = '614.865.5309';
		
        $expected = '6148655309';

        $scrubed = Scrub::phoneNumber($input);
        $this->assertEquals($scrubed, $expected);
		
        $scrubed1 = Scrub::phoneNumber($input1);
        $this->assertEquals($scrubed1, $expected);
		
        $scrubed2 = Scrub::phoneNumber($input2);
        $this->assertEquals($scrubed2, $expected);
		
        $scrubed3 = Scrub::phoneNumber($input3);
        $this->assertEquals($scrubed3, $expected);
    }
	
    /**
     * Passes if a 10 digit integer is returned that is not prefixed with a 1 is returned
     */
    public function testPhoneNumberStripsPreceedingOnes() {

        $input = '16148655309';
        $expected = '6148655309';

        $scrubed = Scrub::phoneNumber($input);
        $this->assertEquals($scrubed, $expected);
		
    }
	
    /**
     * Passes if a 10 digit integer is returned
     */
    public function testPhoneNumberAllowsOnlyTheFirstTenIntegers() {

        $input = '61486553090';
        $expected = '6148655309';

        $scrubed = Scrub::phoneNumber($input);
        $this->assertEquals($scrubed, $expected);
		
    }
	
    /**
     * Passes if a lower case string is returned
     */
    public function testLower() {

        $input = 'Hello World';
        $expected = 'hello world';

        $scrubed = Scrub::lower($input);
        $this->assertEquals($scrubed, $expected);
		
    }
	
}