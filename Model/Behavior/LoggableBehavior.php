<?php
/**
 * Automatically sets the values of the created and modified user ids
 *
 * JSC (http://jasonsnider.com/jsc)
 * Copyright 2012 - 2013, Jason D Snider. (http://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @copyright Copyright 2012-2013, Jason D Snider
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Automatically sets the values of the created and modified user ids
 * @author Jason D Snider <jason@jasonsnider.com>
 * @package Utilities
 */
class LoggableBehavior extends ModelBehavior {

    /**
     * The user to get credit for either the creation or the last modification of a record.
     * @var string
     */
    private $__userId = '00000000-0000-0000-0000-000000000000';

    /**
     * Read the id of the logged in user into an instance variable
     * @param object $model 
     * @param array $options
     * @return void
     */
    function setup(Model $model, $options = array()) {
		
		$userId = CakeSession::read('Auth.User.id');
		
        if (!empty($userId)){
            $this->__userId = $userId;
        }
		//debug($this->__userId);
    }

    /**
     * Adds user tracking to $model->data
     * @param object $model
     * @param array $options
     * @return boolean 
     */
    public function beforeSave(Model $model, $options = array()) {

        if (!isset($model->data[$model->name]['id'])) {
            $model->data[$model->name]['created_user_id'] = $this->__userId;
        } else {
            $model->data[$model->name]['modified_user_id'] = $this->__userId;
        }

        return true;
    }

    /**
     * Allows the userId to be set manually 
     * @param $id the 'forced' id
	 * @return void
     */
    public function setUserId($id = false) {
        if ($id) {
            $this->__userId = $id;
        }
    }

    /**
     * Retrives the userId
     * @param $id the 'forced' id
	 * @return void
     */
    public function getUserId() {
        return $this->__userId;
    }
    
}
