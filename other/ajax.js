$(document).ready(function() {
	$("#message").on("click", function() {
		$(this).slideUp();
	})
	//AJAX request for database and tables creation
	var url = "/main.php";
	
	$.ajaxSetup({url: url});
	
	create = function(value) {
		$("#message").html("Loading...");
		$.ajax({
			method: 'GET',
			data: { action: value },
			success: function(data) {
				$("#message").html(data).slideDown();
			},
			error: function(data) {
				$("#message").html("ERROR").slideDown();
			}
		});
	};
	//Getting users table data
	function getUsersData() {
		$.ajax({
			method: 'GET',
			dataType: 'json',
			data: {action: 'show_users'},
			success: function (data) {
				$("#show_users").empty();
				for(var i=0; i<data.length; i++) {
					$("#show_users").append('\
						<tr><td>' + data[i].id + '</td> \
						<td>' + data[i].user_name + '</td> \
						<td>' + data[i].user_email + '</td> \
						<td>' + data[i].user_country + '</td> \
						<td><button class="btn_edit btn btn-warning" onclick="editData(\'edit_users\', ' + data[i].id + ')">Редактировать</button></td> \
						<td><button class="btn_delete btn btn-danger" onclick="delData(\'del_users\', ' + data[i].id + ')">Удалить</button></td>'
					);
				}
			}
		});
	}
	//Getting country table data
	function getCountryData() {
		$.ajax({
			method: 'GET',
			dataType: 'json',
			data: {action: 'show_country'},
			success: function (data) {
				$("#show_country").empty();
				for(var i=0; i<data.length; i++) {
					$("#show_country").append('\
						<tr><td>' + data[i].id + '</td> \
						<td>' + data[i].country_name + '</td> \
						<td><button class="btn_edit btn btn-warning" onclick="editData(\'edit_country\', ' + data[i].id + ')">Редактировать</button></td> \
						<td><button class="btn_delete btn btn-danger" onclick="delData(\'del_country\', ' + data[i].id + ')">Удалить</button></td>'
					);
				}
			}
		});
	}
	getUsersData();
	getCountryData();
	
	//Refresh tables on click
	$("#refresh_users").on("click", function() {
		$("#message").html("Refreshed users").slideDown();
		getUsersData();
	});
	$("#refresh_country").on("click", function() {
		$("#message").html("Refreshed country").slideDown();
		getCountryData();
	});
	
	//Adding forms
	$( ".add_form" ).submit(function( event ) {

		event.preventDefault();
		
		var inputs = $(this).children("div").children("input");

		var action = $(this).children(".btn_add").data("action");
		var formData = $(this).serialize();	
		var postData = formData + "&action=" + action;

		$.ajax({
			method: 'POST',
			data: postData,
			success: function(data) {
				$(inputs).val('');
				$("#message").html(data).slideDown();
				if (action == "add_users") {
					getUsersData();
				} else if(action == "add_country") {
					getCountryData();
				}
			}
		});
	});
	
	//Edit data
	editData = function(action, id) {
		var usersForm = $("#edit_users div");
		var countryForm = $("#edit_country div");
		
		$.get(url, {action: action, id: id} ).done(function(data) {
			if (action == "edit_users") {
				$(usersForm).children("#edit_user_id").val(data[0].id);
				$(usersForm).children("#edit_user_name").val(data[0].user_name);
				$(usersForm).children("#edit_user_email").val(data[0].user_email);
				$(usersForm).children("#edit_user_country_id").val(data[0].user_country);
				$("#edit_users").slideDown();
			} else if (action == "edit_country") {
				$(countryForm).children("#edit_country_id").val(data[0].id);
				$(countryForm).children("#edit_country_name").val(data[0].country_name);
				$("#edit_country").slideDown();
			}
		});
	}
	$(".btn_edit_form").on("click", function() {
		var form = $(this).parent();
		var action = $(this).data("action");
		
		$(form).submit(function(event) {
			event.preventDefault();
			
			var inputs = $(this).children("div").children("input");
			var formData = $(this).serialize();	
			var postData = "action=" + action + "&" + formData;
			
			console.log(postData);
	
			$.post(url, postData).done(function(data) {
				$(inputs).val('');
				$(form).slideUp();
				$("#message").html(data).slideDown();
				if (action == "add_users") {
					getUsersData();
				} else if(action == "add_country") {
					getCountryData();
				}
			});
		});	
	});
	
	//Delete data
	delData = function(action, id) {		
		var conf = confirm("Are you sure?");
		
		if (conf) {		
			$.ajax({
				method: 'POST',
				data: {action: action, id: id },
				success: function(data) {
					if (action == "del_users") {
						$("#message").html("User deleted").slideDown();
						getUsersData();
					} else if(action == "del_country") {
						$("#message").html("Country deleted").slideDown();
						getCountryData();
					}
				}
			});
		}
	}
});