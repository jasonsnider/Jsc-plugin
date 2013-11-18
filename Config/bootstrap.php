<?php
/**
 * Provides a sort of schema and a default configuration for The Parbake Project
 *
 * Parbake (http://jasonsnider.com/parbake)
 * Copyright 2013, Jason D Snider. (http://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @copyright Copyright 2013, Jason D Snider
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Sets a projects default theme
 */
//Configure::write('Parbake.Themed.default', 'Parbake');
//Configure::write('Parbake.Themed.default', 'ParbakeBootstrap');
Configure::write('Parbake.Themed.default', 'JasonSnider');

/**
 * Demonstrates a method of setting themes on specific actions
 */
Configure::write(
    'Parbake.Themed.Controller.pages.display', 
    array(
        'theme' => 'JasonSnider',
        'layout' => 'home'
    )
);