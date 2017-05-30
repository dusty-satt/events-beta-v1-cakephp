<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class CalendarsTable extends Table
{
	public function initialize( array $config )
	{
		
	}
	
	public function cal_days( $date = null )
	{
		if( empty($date) ) {
			$date = date("Y-m-d");
			$this_month_timestamp = strtotime(date("Y-m-d"));
		} else {
			$this_month_timestamp = strtotime($date);
		}
		//Today's details
		$today = date("Ymd");
		//Selected month's details
		$this_month = date("m", $this_month_timestamp);
		$this_year = date("Y", $this_month_timestamp);
		$days_in_month = cal_days_in_month(CAL_GREGORIAN,$this_month, $this_year);
		$first_day_of_month = date("w",strtotime($this_year . $this_month . "01")) + 1;
		$last_day_of_month = date("w",strtotime($this_year . $this_month . $days_in_month)) + 1;
		$days_of_week = [1 => "Sun",2 => "Mon",3 => "Tue",4 => "Wed",5 => "Thu",6 => "Fri",7 => "Sat"];
		$days_before_start = $first_day_of_month - 1;
		$days_after_end = 7 - $last_day_of_month;
		$cal_days = [];
		$cal_days["this_month"] = [
			"display" => date("M, Y", $this_month_timestamp)
		];
		// Include days from last month
		$last_month = date('m',strtotime($date . "-1 month"));
		$last_year = date('Y',strtotime($date . "-1 month"));
		$cal_days["last_month"] = [
			"display" => date("M", strtotime($date . "-1 month")),
			"url" => "/Events/$last_year/$last_month"
		];
		$days_last_month = cal_days_in_month(CAL_GREGORIAN,$last_month, $last_year);
		$last_month_day_key = $days_before_start;
		for( $i = 1; $i <= $days_before_start; $i++ ) {
			$date_key = $last_year . $last_month . $days_last_month;
			$cal_days["days"][$date_key] = [
				"num" => $days_last_month--,
				"weekday" => $days_of_week[$last_month_day_key--]
			];
		}
		// Include days from this month
		$current_day_of_week = $first_day_of_month;
		for( $i = 1; $i <= $days_in_month; $i++ ) {
			$day = sprintf('%02d', $i);
			$this_date = $this_year . $this_month . $day;
			$cal_days["days"][$this_date] = [
				"num" => $i,
				"weekday" => $days_of_week[$current_day_of_week]
			];
			if( $this_date == $today ) {
				$cal_days["days"][$this_date]["is_today"] = 1;
			}
			$current_day_of_week = $current_day_of_week == 7 ? 1 : $current_day_of_week + 1;
		}
		// Include days for next month
		$next_month = date('m',strtotime($date . "+1 month"));
		$next_year = date('Y',strtotime($date . "+1 month"));
		$cal_days["next_month"] = [
			"display" => date("M", strtotime($date . "+1 month")),
			"url" => "/Events/$next_year/$next_month"
		];
		$next_month_day_key = $last_day_of_month + 1;
		for( $i = 1; $i <= $days_after_end; $i++ ) {
			$day = sprintf('%02d', $i);
			$date_key = $next_year . $next_month . $day;
			$cal_days["days"][$date_key] = [
				"num" => $i,
				"weekday" => $days_of_week[$next_month_day_key++]
			];
		}
		$cal_days["selected_days"] = [];
		ksort($cal_days["days"],SORT_NUMERIC);
		return $cal_days;
	}
	
}