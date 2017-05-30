<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class EventsTable extends Table
{
	public $colors = [
		"#a6ff4d","#99ccff","#ff99ff","#6666ff","#66ffcc"
	];
	
	public function initialize( array $config )
	{
		$this->addBehavior('Timestamp');
	}
	
	public function add_event_days( $cal_days )
	{
		$start_date = key($cal_days["days"]);
		end($cal_days["days"]);
		$end_date = key($cal_days["days"]);
		$conditions = [
			"date >= " => date("Y-m-d",strtotime($start_date)),
			"date <= " => date("Y-m-d",strtotime($end_date))
		];
		$eventGroups = [];
		$events = $this->find("all",["conditions" => $conditions]);
		foreach( $events as $event ) {
			$event_date = date("Ymd",strtotime($event->date));
			$event_group_id = $event->event_group_id;
			$cal_days["eventGroups"][$event_group_id]["days"][] = $event_date;
			$cal_days["eventGroups"][$event_group_id]["name"] = $event->name;
			$cal_days["days"][$event_date]["Events"][] = $event;
		}
		$i = 0;
		foreach( $cal_days["eventGroups"] as $key=>$group) {
			$cal_days["eventGroups"][$key]["color"] = $this->colors[$i++];
			if( $i > count($this->colors) ) $i = 0;
		}
		$i = 0;
		return $cal_days;
	}
	
}