<html>
<head>
	<meta charset="utf-8">
	<title>Test task</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<div class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header"><span class="navbar-brand">Hi, Сайт Імідж</span></div>	
			<div class="collapse navbar-collapse">		
				<ul class="nav navbar-nav navbar-right">
					<li><button class="btn btn-default" name="base" onclick="create('add_database');">Create database</button></li>
					<li><button class="btn btn-default" name="table" onclick="create('add_tables');">Create tables</button></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<form action="/" method="POST" class="add_form col-md-6 row">
			<div class="form-group">
				<label for="user_name">User name:</label>
				<input name="user_name" id="user_name" type="text" placeholder="Taras Shevchenko" class="form-control"></input>
				<label for="user_email">User email:</label>
				<input name="user_email" id="user_email" type="email" placeholder="shevchenko@mysite.com" class="form-control"></input>
				<label for="user_country_id">Country ID:</label>
				<input name="user_country_id" id="user_country_id" type="number" placeholder="Country ID" class="form-control"></input>
			</div>
			<button type="submit" data-action="add_users" class="btn_add btn btn-primary" class="form-control">Add user</button>
		</form>
		<form action="/" method="POST" class="add_form col-md-5 pull-right">
			<div class="form-group">
				<label for="country_name">Country name</label>
				<input name="country_name" id="country_name" type="text" placeholder="Country" class="form-control"></input>
			</div>		
			<button type="submit" data-action="add_country" class="btn_add btn btn-primary">Add country</button>
		</form>
	</div>
	<div class="container">
		<div class="col-sm-6 row">
			<form action="/" method="POST" id="edit_users" style="display: none;">
				<div class="form-group">
					<input type="hidden" name="id" id="edit_user_id"></input>
					<label for="edit_user_name">User name:</label>
					<input name="edit_user_name" id="edit_user_name" type="text" placeholder="Taras Shevchenko" class="form-control"></input>
					<label for="edit_user_email">User email:</label>
					<input name="edit_user_email" id="edit_user_email" type="email" placeholder="shevchenko@mysite.com" class="form-control"></input>
					<label for="edit_user_country_id">Country ID:</label>
					<input name="edit_user_country_id" id="edit_user_country_id" type="number" placeholder="Country ID" class="form-control"></input>
				</div>
				<button type="submit" data-action="edit_users" class="btn_edit_form btn btn-primary" class="form-control">Edit user</button>
			</form>
		</div>
		<div class="col-sm-5 pull-right">
			<form action="/" method="POST" id="edit_country" style="display: none;">
				<div class="form-group">
					<input type="hidden" name="id" id="edit_country_id"></input>
					<label for="edit_country_name">Country name</label>
					<input name="edit_country_name" id="edit_country_name" type="text" placeholder="Country" class="form-control"></input>
				</div>		
				<button type="submit" data-action="edit_country" class="btn_edit_form btn btn-primary">Edit country</button>
			</form>
		</div>
	</div>
	<div class="container">
		<div class="col-sm-7 row">
			<table id="users" class="table table-striped table-hover">
				<caption>Users table <span id="refresh_users" class="btn btn-link">(Refresh)</span></caption>
				<thead>
					<tr>
						<th>ID</th><th>User</th><th>Email</th><th>Country ID</th><th>Edit option</th><th>Delete option</th>
					</tr>
				</thead>
				<tbody id="show_users">
					
				</tbody>
			</table>
		</div>
		<div class="col-sm-5">
			<table id="country" class="table table-striped table-hover">
				<caption>Country table <span id="refresh_country" class="btn btn-link">(Refresh)</span></caption>
				<thead>
					<tr>
						<th>ID</th><th>Country</th><th>Edit option</th><th>Delete option</th>
					</tr>
				</thead>
				<tbody id="show_country">
				
				</tbody>
			</table>
		</div>
	</div>
	<p class="bg-warning" id="message" style="position: fixed; width: 100%; min-height: 70px; padding: 5px; display: none; font-weight: 600; bottom: 0px;"></p>
	
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="/other/ajax.js"></script>
</body>
</html>