<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{
    // Other methods..

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
				$role = $this->Auth->user("role");
				$allow = [];
				switch($role) {
					case "admin" :
						// Admin already gets access to everything in AppController
					case "host" :
					case "guest" :
					default :
						$allow[] = "ajaxLogin";
						$allow[] = "logout";
						break;
				}
				$this->Auth->allow($allow);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }
		
		public function ajaxLogin()
		{
			$this->autoRender = false;
			if ( $this->request->is('post') && $this->request->is('ajax') ) {
				$user = $this->Auth->identify();
				$return = ["success" => false];
				if ($user) {
					$this->Auth->setUser($user);
					$return = [
						"success" => true,
						"email" => $this->Auth->user("username")
					];
					echo json_encode($return);
					return;
				}
				$return["title"] = 'Login Failed : ';
				$return["message"] = 'Invalid username or password, please try again';
				$return["type"] = 'danger';
				echo json_encode($return);
				return;
			}
		}

    public function logout()
    {
			if($this->request->is("ajax")){
				$this->autoRender = false;
				$this->Auth->logout();
				return;
			} else {
				return $this->redirect($this->Auth->logout());
			}
		}
		
		public function index()
     {
        $this->set('users', $this->Users->find('all'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
}