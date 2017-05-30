<?php
$this->layout = "fuego";
//will move this to the controller later
$this_day = date("d");
$this_month = date("m");
$this_year = date("Y");
$days_in_month = cal_days_in_month(CAL_GREGORIAN,$this_month, $this_year);
$first_day_of_month = date("w",strtotime($this_year . $this_month . "01")) + 1;
$last_day_of_month = date("w",strtotime($this_year . $this_month . $days_in_month)) + 1;
$days_of_week = [1 => "Sun",2 => "Mon",3 => "Tue",4 => "Wed",5 => "Thu",6 => "Fri",7 => "Sat"];
$days_before_start = $first_day_of_month - 1;
$days_after_end = 7 - $last_day_of_month;
$cal_days = [];
for( $i = 1; $i <= $days_before_start; $i++ ) {
	$cal_days[$i] = ["num" => "&nbsp;"];
	$empty_cell_key = $i;
}
$current_day_of_week = $first_day_of_month;
for( $i = 1; $i <= $days_in_month; $i++ ) {
	$this_date = $this_year . $this_month . $i;
	$cal_days[$this_date] = [
		"num" => $i,
		"weekday" => $days_of_week[$current_day_of_week]
	];
	$current_day_of_week = $current_day_of_week == 7 ? 1 : $current_day_of_week + 1;
}
for( $i = 1; $i <= $days_after_end; $i++ ) {
	$cal_days[++$empty_cell_key] = ["num" => "&nbsp;"];
}
?>
<div class="container col-md-3">
	<div class="panel panel-info">
		<div class="panel-heading text-center">
			Welcome!
		</div>
		<div class="panel-body">
			<p>
				You can click on a day to list its events...
			</p>
			<p>
				And you can click directly on an event icon for details.
			</p>
		</div>
	</div>
</div>
<div class="container col-md-9 calendar-panels">
	<div class="text-center">
		<h1>May</h1>
	</div>
	<div class="seven-cols text-center">
		<div class="col-xs-1">Sun</div>
		<div class="col-xs-1">Mon</div>
		<div class="col-xs-1">Tue</div>
		<div class="col-xs-1">Wed</div>
		<div class="col-xs-1">Thu</div>
		<div class="col-xs-1">Fri</div>
		<div class="col-xs-1">Sat</div>
	</div>
	<div class="seven-cols">
		<?php
		foreach ( $cal_days as $date=>$day ) :
			?>
			<div class="col-xs-1 panel panel-default" id="<?= $date; ?>">
				<div class="panel-heading">
					<?= $day["num"]; ?>
				</div>
				<div class="panel-body">
					<?php 
					if( !empty($day["body_parts"]) ) {
						foreach( $day["body_parts"] as $part ) {
							echo $part . "<br />";
						}
					}
					?>
				</div>
			</div>
			<?php
		endforeach;
		?>
	</div>
</div>