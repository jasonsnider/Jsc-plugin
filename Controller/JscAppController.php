<?php
/**
 * Application Controller
 */
App::uses('AppController', 'Controller');

/**
 * Application Controller
 *
 * @property Auth $Auth
 * @property Authorize $Authorize
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package Jsc
 */

class JscAppController extends AppController {

/**
 * Set the default theme for the site
 */
    public $theme;
    
/**
 * Calls the application wide components
 * @var array $components
 */
    public $components = array(
        'Auth' => array(
            //Force a central login (1 login per prefix by default).
            'loginAction' => array(
                'admin' => false,
                'plugin' => 'users',
                'controller' => 'users',
                'action' => 'login'
            ),
            'authError' => 'You are not allowed to do that.',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'username',
                        'password' => 'hash'
                    )
                )
            )
        ),
		'Contents.Meta',
		'Paginator',
        'Security',
        'Session',
		'Users.Authorize'
    );
    
/**
 * Executes logic prior to the execution of the invoked action.
 * Sets the theme to the value specified by the Configure class
 * @return void
 */
    public function beforeFilter() {
		parent::beforeFilter();
        $this->setTheme(); 
        $this->request->isEmployee = $this->isEmployee();
    }
    
/**
 * Called after the action
 * @return void
 */
    public function beforeRender() {
        parent::beforeRender();
    }
	
/**
 * Sets the theme to a Configured value
 * @todo - Refactor
 * @return void
 */
    public function setTheme(){
        if(Configure::check('JSC.Themed.default')){
            $this->theme = Configure::read('JSC.Themed.default');
        }

        //Set path segments to allow for easy reuse and improved readability
        $root = 'JSC.Themed.Controller';
        $controller = $this->request->controller;
        $action = $this->request->action;
        
        //Check the config file for controller specific themes
        if(Configure::check('JSC.Themed.Controller')){
            //Is the current controller named?
            if(array_key_exists($controller, Configure::read($root))){
				
				//If we see a wild card for a controller set that against all controlle actions
				if(array_key_exists('*', Configure::read("{$root}.{$controller}"))){

					//Set the theme and layout paths for easy reuse and improved readability
					$themePath = "{$root}.{$controller}.*.theme";
					$layoutPath = "{$root}.{$controller}.*.layout";
					
					//Set the controller/action specific theme
					if(Configure::check($themePath)){
						$this->theme = Configure::read($themePath);
					}

					//Set the controller/action specific layout
					if(Configure::check($layoutPath)){
						$this->layout = Configure::read($layoutPath);
					}
				}
				
                //Is the current action named? if so set those values (overrides wildcard setting)
                if(array_key_exists($action, Configure::read("{$root}.{$controller}"))){
                        
                        //Set the theme and layout paths for easy reuse and improved readability
                        $themePath = "{$root}.{$controller}.{$action}.theme";
                        $layoutPath = "{$root}.{$controller}.{$action}.layout";
                        
                        //Set the controller/action specific theme
                        if(Configure::check($themePath)){
                            $this->theme = Configure::read($themePath);
                        }
                        
                        //Set the controller/action specific layout
                        if(Configure::check($layoutPath)){
                            $this->layout = Configure::read($layoutPath);
                        }
                  
                }
            }
        }

		if ($this->name == 'CakeError') {
            $this->theme = Configure::read('JSC.Themed.error.theme');
            $this->layout = Configure::read('JSC.Themed.error.layout');
		}
		
		if($this->request->prefix == 'admin'){
            $this->theme = Configure::read('JSC.Themed.admin.theme');
            $this->layout = Configure::read('JSC.Themed.admin.layout');
		}

    }    
    
/**
 * Returns true if a user is an employee and/or root user.
 * @return boolean
 */
    function isEmployee(){
        $user = $this->Session->read('Auth.User');
        if($user['root'] || $user['employee']){
            return true;
        }
        return false;
    }
}
