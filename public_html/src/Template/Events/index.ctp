<?php
$this->layout = "fuego";
?>
<script>
	var CalDays = <?= json_encode($cal_days,JSON_FORCE_OBJECT); ?>;
	var UserPreferences = {};
	var Settings = {
		allowMultipleDaySelect : false
	};
</script>
<div class="container col-md-3 featureWindow">
	<div class="panel panel-feature collapse in manageDays" data-parent=".featureWindow">
		<div class="panel-heading text-center">
			Welcome, <span class="authUsername"><?= $authUser["username"];?></span>
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
	<div class="panel panel-feature collapse viewDay" data-parent=".featureWindow">
		<div class="panel-heading text-center">
			Day View</span>
		</div>
		<div class="panel-body">
			<p>
				You're viewing all details in a day.
			</p>
		</div>
	</div>
	<div class="panel panel-feature collapse viewEvent" data-parent=".featureWindow">
		<div class="panel-heading text-center">
			<span class="eventGroupName">Event Group</span>
		</div>
		<div class="panel-body">
			<p>
				You're viewing all details about an Event Group.
			</p>
		</div>
	</div>
	<div class="panel panel-feature collapse manageDays" id="AddEvent" data-parent=".featureWindow">
		<div class="panel-heading text-center">
			Add a New Event
		</div>
		<div class="panel-body">
			<!-- Save Event Group -->
			1) Select all the days you'd like to host this event.<br />
			2) Optionally, add a preferred start time in each day.
			<input class="form-control AddEvent" type="text" placeholder="Event Title" name="AddEvent.name" />
			<div class="input-group col-xs-12">
				<span class="input-group-addon">#</span>
				<input class="form-control AddEvent" type="number" placeholder="Guest Minimum" name="AddEvent.guest_quota" />
				<span class="input-group-addon">#</span>
				<input class="form-control AddEvent" type="number" placeholder="Guest Limit" name="AddEvent.guest_limit" />
			</div>
			<button class="btn btn-block btn-warning btn-md submitFields" data-input-class=".AddEvent" data-post-target="/events/addEvent" type="submit">Save Event Group</button>
			<!-- Settings -->
			<div class="margin-top-20">
				<div class="input-group col-xs-12">
					<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
					<input class="form-control" type="time" placeholder="Default Time" id="settingDefaultTime" />
					<div class="input-group-btn">
						<button class="btn btn-success single-input" type="submit" data-target="#settingDefaultTime" data-btn-val="1">
							<i class="glyphicon glyphicon-ok"></i>
						</button>
						<button class="btn btn-danger single-input" type="submit" data-target="#settingDefaultTime" data-btn-val="0">
							<i class="glyphicon glyphicon-remove"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container col-md-9 calendar-panels">
	<ul class="pager">
		<li class="previous col-xs-3"><a href="<?= $cal_days["last_month"]["url"]; ?>"><span class="glyphicon glyphicon-menu-left"></span> <?= $cal_days["last_month"]["display"]; ?></a></li>
		<li class="col-xs-6">
			<h1>
				&nbsp;&nbsp;<?= $cal_days["this_month"]["display"]; ?> 
				<a href="#" data-toggle="collapse" data-target=".manageDays">
					<span class="glyphicon glyphicon-chevron-down"></span>
				</a>
			</h1>
		</li>
		<li class="next col-xs-3"><a href="<?= $cal_days["next_month"]["url"]; ?>"><?= $cal_days["next_month"]["display"]; ?> <span class="glyphicon glyphicon-menu-right"></span></a></li>
	</ul>
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
		foreach ( $cal_days["days"] as $date=>$day ) :
			$panel_style = !empty($day['is_today']) ? "panel-today" : "panel-default";
			$panel_is_today = !empty($day['is_today']) ? " - today" : "";
			?>
			<div class="col-xs-1 panel <?= $panel_style; ?>" id="<?= $date; ?>">
				<div class="container-fluid panel-container panel-heading" data-toggle="panel-selected" data-target="#<?= $date; ?>" data-panel-class="<?= $panel_style; ?>">
					<?= $day["num"]; ?><?= $panel_is_today; ?>
					
					<button class="btn btn-default btn-xs pull-right text-center" data-toggle="collapse" data-target=".viewDay"><span class="glyphicon glyphicon-menu-down"></span></button>
				</div>
				<div class="panel-body">
					<div class="container-fluid panel-container collapse manageDays">
						<div class="col-xs-2">
							<a href="#" data-toggle="tooltip" data-placement="top" title="Set a preferred Start Time (optional)">
								<span class="glyphicon glyphicon-time"></span>
							</a>
						</div>
						<input type="time" class="col-xs-10 userDefaultDate saveDayData" data-date="<?= $date; ?>" data-field-name="preferred_start_time"/>
					</div>
					<div class="collapse in manageDays">
						<?php 
						if( !empty($day["Events"]) ) {
							foreach( $day["Events"] as $event ) {
								$event_group_id = $event["event_group_id"];
								$color = $cal_days['eventGroups'][$event_group_id]["color"];
								?>
								<div class="well well-sm" id="updateEventView" style="background-color: <?= $color; ?>;" 
									data-toggle="collapse" 
									data-target=".viewEvent" 
									data-event-group-id="<?= $event_group_id; ?>"
									data-setting-field="allowMultipleDaySelect"
									data-setting-value="true"
								>
									<?= $event->name; ?>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endforeach;
		?>
	</div>
</div>