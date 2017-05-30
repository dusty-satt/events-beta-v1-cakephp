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

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Event\Event;

class EventsController extends AppController
{
	
	public function beforeFilter(Event $event)
	{
			parent::beforeFilter($event);
			$role = $this->Auth->user("role");
			$allow = [];
			switch($role) {
				case "admin" :
					// Admin already gets access to everything in AppController
				case "host" :
				case "guest" :
				default :
					$allow[] = "add_event";
					break;
			}
			$this->Auth->allow($allow);
	}
	
	public function index($year = null, $month = null){
		$cal_date = null;
		if( !empty($year) && !empty($month) ) {
			$cal_date = $year . "-" . $month . "-01";
		}
		$calendars = TableRegistry::get('Calendars');
		$events = TableRegistry::get('Events');
		$cal_days = $calendars->cal_days($cal_date);
		$cal_days = $events->add_event_days($cal_days);
		$this->set("cal_days",$cal_days);
	}
	
	public function addEvent(){
		$this->autoRender = false;
		// $this->log($this->request->data);
		if( $this->request->is("ajax") ) {
			if ( empty($this->request->data["AddEvent"]) ) {
				
			} else {
				if( empty($this->request->data["selected_days"]) ) {
					
				} else {
					// Create an EventGroup
					$eventGroupsTable = TableRegistry::get('EventGroups');
					
					$eventGroup = $eventGroupsTable->newEntity();
					$eventGroup->name = $this->request->data["AddEvent"]["name"];
					if( $eventGroupsTable->save($eventGroup) ) {
						$eventsTable = TableRegistry::get('Events');
						// Save each Event for selected days
						foreach( $this->request->data["selected_days"] as $selected_day ){
							$this->log($selected_day);
							$event = $eventsTable->newEntity();
							$event->event_group_id = $eventGroup->id;
							$event->date = date("Y-m-d",strtotime($selected_day));
							$event->name = $this->request->data["AddEvent"]["name"];
							$event->guest_quota = $this->request->data["AddEvent"]["guest_quota"];
							$event->guest_limit = $this->request->data["AddEvent"]["guest_limit"];
							$event->preferred_start_time = $this->request->data["days"][$selected_day]["preferred_start_time"];
							if( $eventsTable->save($event) ) {
								echo "success";
							}
						}
					}
				}
			}
		}
	}
	
}
