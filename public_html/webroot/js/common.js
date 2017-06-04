function postCalDays(postTarget){
	console.log("posting to " + postTarget);
	$.ajax({
		method: "POST",
		dataType: "JSON",
		url: postTarget,
		data: CalDays,
		success: function(result){
			console.log("in success");
			console.log(result);
			// if( result.success == true ) {
			// } else {
			// 	$("#alert-title").text(result.title);
			// 	$("#alert-message").text(result.message);
			// 	$("#js-alert")
			// 		.removeClass("alert-success alert-info alert-warning alert-danger")
			// 		.addClass("alert-" + result.type)
			// 		.collapse("show");
			// }
		},
		error: function(error){
			console.log("in error");
			console.log(error);
		}
	});
}
function clearSelectedDays(callback){
	var selected_days = CalDays["selected_days"];
	$.each(selected_days, function(key,val){
		var panel = $("#" + val);
		var originalPanelClass = $("#" + val + " .panel-heading").attr("data-panel-class");
		panel.removeClass("panel-feature panel-selected panel-today panel-default")
			.addClass(originalPanelClass);
		delete CalDays["selected_days"][val];
		CalDays["days"][val]["selected"] = false;
	});
	if( callback && typeof callback === "function" ) {
		callback();
	}
}
$( document ).ready(function() {
	//////////////////////////////////////
	// ---     Events Functions     --- //
	//////////////////////////////////////
	console.log(CalDays);
	$(".collapse").on('show.bs.collapse', function(){
		var dataParent = $(this).attr("data-parent");
		$(dataParent + " .collapse").collapse("hide");
	});
	$(".clearSelectedDays").click(function(){
		clearSelectedDays();
	});
	$(".updateEventView").click(function(){
		$(".viewEvent").collapse("show");
		Settings["allowMultipleDaySelect"] = true;
		var event_group_id = $(this).attr("data-event-group-id");
		var name = CalDays["eventGroups"][event_group_id]["name"];
		var days = CalDays["eventGroups"][event_group_id]["days"];
		$(".eventGroupName").text(name);
		clearSelectedDays(function(){
			$.each(days, function(key,val){
				$("#" + val + " .panel-heading").trigger("click");
			});
		});
		
		console.log("updateEventView:");
		console.log(Settings);
	});
	
	
	$('[data-toggle="tooltip"]').tooltip();
	$('.submitFields').click(function(e){
		var inputClass = $(this).attr("data-input-class");
		var model = inputClass.split(".");
		var postTarget = $(this).attr("data-post-target");
		model = model[1];
		CalDays[model] = {};
		$(inputClass).each(function(){
			var val = $(this).val();
			var obj = $(this).attr("name");
			var obj = obj.split(".");
			var field = obj[1];
			CalDays[model][field] = val;
		});
		postCalDays(postTarget);
	});
	$('.calendar-panels .panel-heading').click(function(e){
		e.preventDefault();
		var panelSelected = $(this).attr("data-toggle");
		var target = $(this).attr("data-target");
		var date = $(target).attr("id");
		var preferredDateInput = $(target).find(".userDefaultDate");
		var originalPanelClass = $(this).attr("data-panel-class");
		if( !Settings.allowMultipleDaySelect ) {
			clearSelectedDays();
		}
		if ( !CalDays["days"][date]["selected"] ) {
			CalDays["days"][date]["selected"] = true;
			CalDays["selected_days"][date] = date;
			if( Settings.allowMultipleDaySelect ) {
				$(preferredDateInput).val(UserPreferences["default_date"]).trigger("change");
			}
			if( panelSelected == "panel-selected" ) {
				$(target)
					.removeClass("panel-feature panel-selected panel-today panel-default")
					.addClass("panel-selected");
			}
		} else {
			CalDays["days"][date]["selected"] = false;
			delete CalDays["selected_days"][date];
			if( Settings.allowMultipleDaySelect ) {
				$(preferredDateInput).val(null).trigger("change");
			}
			$(target)
				.removeClass("panel-feature panel-selected panel-today panel-default")
				.addClass(originalPanelClass);
		}
	});
	$('.saveDayData').on("change",function(e){
		var date = $(this).attr("data-date");
		var field_name = $(this).attr("data-field-name");
		var val = $(this).val() == "" ? null : $(this).val();
		CalDays["days"][date][field_name] = val;
	});
	$('.single-input').click(function(e){
		e.preventDefault();
		var target = $(this).attr("data-target");
		var is_true = $(this).attr("data-btn-val");
		if( is_true == 1 ) {
			var default_date = $(target).val() == "" ? null : $(target).val();
			UserPreferences["default_date"] = default_date;
			$(".panel-selected").find(".userDefaultDate").val(default_date).trigger("change");
		} else {
			UserPreferences["default_date"] = null;
			$(".userDefaultDate").val(null).trigger("change");
		}
	});
	//////////////////////////////////////
	// --- Authentication Functions --- //
	//////////////////////////////////////
	$("#menuLoginForm").on("submit",function(e){
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			method: "POST",
			dataType: "JSON",
			url: "/Users/ajax_login",
			data: data,
			success: function(result){
				if( result.success == true ) {
					$(".authUsername").text(result.email);
					$(".authLoggedOut").hide();
					$("#nav2").collapse("hide");
					$(".authLoggedIn").show();
				} else {
					$("#alert-title").text(result.title);
					$("#alert-message").text(result.message);
					$("#js-alert")
						.removeClass("alert-success alert-info alert-warning alert-danger")
						.addClass("alert-" + result.type)
						.collapse("show");
				}
			}
		});
	});
	$(".ajaxLogout").on("click",function(e){
		e.preventDefault();
		$.ajax({
			method: "POST",
			url: "/Users/logout",
			success: function(result){
				$(".authUsername").text("");
				$(".authLoggedIn").hide();
				$(".authLoggedOut").show();
			}
		});
	});
});