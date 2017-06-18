<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
				$this->loadComponent('Auth', [
					'authorize' => ['Controller'], // Added this line
					'loginRedirect' => [
						'controller' => 'Events',
						'action' => 'index'
					],
					'logoutRedirect' => [
						'controller' => 'Events',
						'action' => 'index'
					]
				]);
				$this->loadComponent('AkkaFacebook.Graph', [
					'app_id' => FACEBOOK_APP_ID,
					'app_secret' => FACEBOOK_APP_SECRET,
					'app_scope' => 'email,public_profile', // https://developers.facebook.com/docs/facebook-login/permissions/v2.4
					'redirect_url' => Router::url(['controller' => 'Events', 'action' => 'index'], TRUE), // This should be enabled by default
					'post_login_redirect' => '', //ie. Router::url(['controller' => 'Users', 'action' => 'account'], TRUE)
					// 'user_columns' => [
					// 	'first_name' => 'first_name', 
					// 	'last_name' => 'last_name', 
					// 	'username' => 'username', 
					// 	'password' => 'password',
					// 	'email' => 'username'
					// ] //not required
				]);
				
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
				
				date_default_timezone_set("America/Chicago");
    }
		
		public function beforeFilter(Event $event)
		{
			$this->Auth->allow(['index', 'view', 'display']);
			$this->set('authUser', $this->Auth->user());
		}
		
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
		
		
		public function isAuthorized($user)
		{
	    // Admin can access every action
	    if (isset($user['role']) && $user['role'] === 'admin') {
	        return true;
	    }

	    // Default deny
	    return false;
		}
}
