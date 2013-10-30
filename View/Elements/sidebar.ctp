<?php $controller = $this->request->params['controller']; ?>
<?php $action = $this->request->params['action']; ?>
<div class="actions">
    <?php if ($this->Session->check('Auth.User')): ?>
        <h3>Sections</h3>
        <ul>
            <li><?php echo $this->Html->link('Users', '/users'); ?></li>
        </ul>

        <?php if ($this->Session->check('Auth.User.employee')): ?>
            <h3>Admin Sections</h3>
            <ul>
                <li><?php echo $this->Html->link('Users', '/admin/users'); ?></li>
                <li><?php echo $this->Html->link('UserGroups', '/admin/user_groups'); ?></li>
            </ul>
        <?php endif; ?>
            
        <?php
        //Returns all plugins in the system, if that plugin has a controller and that follows the CakePHP standard of 
        //naming, it will try to link to the index view of that controller.
        //Not intended for production, rather as an aid for plugin development.
        echo $this->Html->tag('h3', 'Plugins');
        $li = null;
        
        //Find all of the Plugins
        $plugins = scandir(APP . 'Plugin');
        foreach($plugins as $plugin):
            
            //Create the expected path to the plugins default controller
            $loc = Inflector::underscore($plugin); 

            $pluginMain = 
                ROOT . DS . 
                APP_DIR . DS . 
                'Plugin' .  DS . 
                $plugin . DS . 
                'Controller' . DS . 
                "{$plugin}Controller.php";

            //Does the plugin have a controller named after the plugin?
            if(!in_array($plugin, array('.', '..'))):
                //It does create a link
                if(is_file($pluginMain)):
                    $li .= $this->Html->tag(
                        'li', 
                        $this->Html->link($plugin, "/{$loc}")
                    );
                else:
                    //It does not, just return a list item
                    $li .= $this->Html->tag('li', $plugin);
                endif;
            endif;
        endforeach;

        echo $this->Html->tag('ul', $li);
        ?>
    
        <h3>Actions</h3>
        <ul>
            <li><?php echo $this->Html->link('Log Out', '/users/logout'); ?></li>
        </ul>
        
    <?php else: ?>
        <ul>
            <li><?php echo $this->Html->link('Login', '/users/login'); ?></li>
            <li><?php echo $this->Html->link('New Account', '/users/create'); ?></li>
        </ul>
    <?php endif; ?>
</div>